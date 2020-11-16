<?php


use App\Paises;
use Illuminate\Database\Seeder;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('paises')->truncate();

        $items = [
            'Argentina','Bolivia','Brasil','Chile','Colombia','Ecuador','Paraguay','Perú','Uruguay','Venezuela'
        ];

        foreach ($items as $value) {
            Paises::create([
                'nombre' => $value,
            ]);
        }
    }
}
