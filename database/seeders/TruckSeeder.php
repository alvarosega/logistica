<?php

namespace Database\Seeders;

use App\Models\Truck;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path("database/data/trucks.csv");
        if (!file_exists($file)) return;

        $handle = fopen($file, "r");
        fgetcsv($handle, 0, ";");

        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            // Saltar si el código del camión está vacío
            if (empty($data) || !isset($data[0]) || empty(trim($data[0]))) {
                continue;
            }

            Truck::updateOrCreate(
                ['codigo_camion' => trim($data[0])],
                [
                    'sru'    => trim($data[1] ?? ''),
                    'region' => trim($data[2] ?? 'N/A'),
                    'cel'    => trim($data[3] ?? '0'),
                    'nombre' => trim($data[4] ?? 'Sin Nombre'),
                ]
            );
        }
        fclose($handle);
    }
}