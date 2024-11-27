<?php

namespace Database\Seeders;

use App\Models\Information;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Information::insert([
            [
                'name' => 'Guía completa sobre los pasos a seguir después de un accidente de tráfico',
                'body' => 'Este artículo podría ofrecer información detallada sobre qué hacer
                    inmediatamente después de verse involucrado en un accidente de tráfico,
                     cómo recopilar pruebas, cuándo y cómo comunicarse con las compañías de
                      seguros y cómo buscar ayuda legal si es necesario.', // Contenido para la columna body
                'cover_photo' => '../../img/Accidente.png', // Ruta o URL de la foto de portada
                'category' => Information::PENAL, // Usando la constante definida
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);



        Information::insert([
            [
                'name' => 'Los derechos del consumidor',
                'body' => 'Conoce tus derechos como consumidor y aprende cómo protegerte contra el fraude y las prácticas comerciales injustas', // Contenido para la columna body
                'cover_photo' => '../../img/Derechosdelconsumidor.png', // Ruta o URL de la foto de portada
                'category' => Information::PENAL, // Usando la constante definida
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        Information::insert([
            [
                'name' => 'spectos legales para iniciar un negocio',
                'body' => 'Aprende los aspectos legales fundamentales al iniciar un negocio', // Contenido para la columna body
                'cover_photo' => '../../img/Iniciarunnegocio.png', // Ruta o URL de la foto de portada
                'category' => Information::PENAL, // Usando la constante definida
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);


    }
}
