<?php

namespace Database\Seeders;

use App\Models\TypeDocument;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeDocument::insert([
            [
                'code' => 'CC',
                'description' => 'Cedula de ciudadania',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        TypeDocument::insert([
            [
                'code' => 'CE',
                'description' => 'Cedula de Extranjeria',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        TypeDocument::insert([
            [
                'code' => 'DE',
                'description' => 'Documento extranjero',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        TypeDocument::insert([
            [
                'code' => 'PA',
                'description' => 'Pasaporte',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        TypeDocument::insert([
            [
                'code' => 'TI',
                'description' => 'Tarjeta de Identidad',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
