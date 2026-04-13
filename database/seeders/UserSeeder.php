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
        fgetcsv($handle, 0, ";"); // Saltar cabecera

        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            // Validar que la fila no esté vacía y tenga los campos necesarios
            if (empty($data) || !isset($data[1]) || empty(trim($data[1]))) {
                continue;
            }

            User::updateOrCreate(
                ['codigo_cliente' => trim($data[1])],
                [
                    'name'     => trim($data[0]),
                    'role'     => trim($data[2]),
                    'password' => Hash::make(trim($data[3])),
                ]
            );
        }
        fclose($handle);
    }
}