<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path("database/data/orders.csv");
        if (!file_exists($file)) return;

        $handle = fopen($file, "r");
        fgetcsv($handle, 0, ","); // Saltar cabecera usando coma

        $batch = [];
        DB::beginTransaction();

        try {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                // Validación básica: omitir si falta el código de cliente
                if (empty($data[0])) continue;

                // Lógica de fecha: soporta número de serie Excel (46100) o formato DD/MM/YYYY
                $fechaRaw = trim($data[2]);
                $fechaFinal = is_numeric($fechaRaw) 
                    ? Carbon::create(1899, 12, 30)->addDays((int)$fechaRaw)->format('Y-m-d')
                    : Carbon::createFromFormat('d/m/Y', $fechaRaw)->format('Y-m-d');

                $batch[] = [
                    'codigo_cliente' => trim($data[0]),
                    'codigo_camion'  => trim($data[1]),
                    'fecha_entrega'  => $fechaFinal,
                    'producto'       => trim($data[3]),
                    'cantidad'       => (int)$data[4],
                    'territorio'     => (int)$data[5], // Nueva columna
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

                // Inserción en bloques de 1000 para eficiencia en los 3,000 registros diarios
                if (count($batch) >= 1000) {
                    Order::insert($batch);
                    $batch = [];
                }
            }
            
            if (!empty($batch)) {
                Order::insert($batch);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        fclose($handle);
    }
}