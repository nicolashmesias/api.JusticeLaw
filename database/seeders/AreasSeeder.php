<?php

namespace Database\Seeders;

use App\Models\Area;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::insert([
            [
                'name' => 'Derecho Penal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Civil',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Laboral',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Mercantil',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        Area::insert([
            [
                'name' => 'Derecho Constitucional',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Administrativo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Ambiental',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Internacional',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        Area::insert([
            [
                'name' => 'Propiedad Intelectual',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Informático',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho de Familia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);


        Area::insert([
            [
                'name' => 'Derecho Inmobiliario',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        Area::insert([
            [
                'name' => 'Derecho Fiscal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

    }
}