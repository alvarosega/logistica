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
        fgetcsv($handle, 0, ","); // Saltar cabecera

        $batch = [];
        DB::beginTransaction();

        try {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                if (empty($data[0])) continue;

                // CORRECCIÓN: La fecha ahora está en el índice 3
                $fechaRaw = trim($data[3]); 
                
                $fechaFinal = is_numeric($fechaRaw) 
                    ? Carbon::create(1899, 12, 30)->addDays((int)$fechaRaw)->format('Y-m-d')
                    : Carbon::createFromFormat('d/m/Y', $fechaRaw)->format('Y-m-d');

                $batch[] = [
                    'codigo_cliente' => trim($data[0]),
                    'razon_social'   => trim($data[1]),
                    'codigo_camion'  => trim($data[2]), // Índice 2 es el camión (TM9)
                    'fecha_entrega'  => $fechaFinal,    // El valor procesado de $data[3]
                    'producto'       => trim($data[4]),
                    'cantidad'       => (int)$data[5],
                    'territorio'     => (int)$data[6],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

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