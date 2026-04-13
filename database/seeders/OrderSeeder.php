<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path("database/data/orders.csv");
        $handle = fopen($file, "r");
        fgetcsv($handle, 0, ";"); // Cabecera
    
        $batch = [];
        DB::beginTransaction();
    
        try {
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                if (empty($data[0])) continue;
    
                // Conversión de fecha Excel (46100 -> 2026-04-01)
                $fechaFinal = is_numeric($data[2]) 
                    ? Carbon::create(1899, 12, 30)->addDays((int)$data[2])->format('Y-m-d')
                    : Carbon::createFromFormat('d/m/Y', $data[2])->format('Y-m-d');
    
                $batch[] = [
                    'codigo_cliente' => trim($data[0]),
                    'codigo_camion'  => trim($data[1]),
                    'fecha_entrega'  => $fechaFinal,
                    'producto'       => trim($data[3]),
                    'cantidad'       => (int)$data[4],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
    
                if (count($batch) >= 1000) {
                    Order::insert($batch);
                    $batch = [];
                }
            }
            Order::insert($batch);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        fclose($handle);
    }
}