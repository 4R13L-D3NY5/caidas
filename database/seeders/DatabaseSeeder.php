<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sembrar las escalas de valoración
        $this->call([
            EscalaCaidasSeeder::class,
            EscalaUlcerasSeeder::class,
        ]);

        // Crear usuario de prueba (supervisora)
        User::factory()->create([
            'name' => 'Aracely Sevilla',
            'email' => 'aracely@supervision.com',
            'rol' => 'supervisora',
        ]);

        // Crear usuario de prueba (enfermera)
        // User::factory()->create([
        //     'name' => 'Enfermera',
        //     'email' => 'enfermera@caidas.com',
        //     'rol' => 'enfermera',
        // ]);

        // Crear pacientes de prueba
        // $this->call(PacientesPruebaSeeder::class);
    }
}
