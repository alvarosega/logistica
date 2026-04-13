<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path("database/data/users.csv");
        if (!file_exists($file)) return;

        $handle = fopen($file, "r");
        fgetcsv($handle, 0, ","); // Saltar cabecera con separador de coma

        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            // Validar legajo (columna 1) y rol (columna 2)
            if (empty($data) || !isset($data[1]) || !is_numeric(trim($data[1]))) {
                continue;
            }

            User::updateOrCreate(
                ['legajo' => (int)trim($data[1])],
                [
                    'name'       => trim($data[0]),
                    'role'       => trim($data[2]),
                    'password'   => Hash::make(trim($data[3])),
                    'territorio' => !empty($data[4]) ? (int)trim($data[4]) : null,
                ]
            );
        }
        fclose($handle);
    }
}