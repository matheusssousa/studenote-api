<?php

namespace Database\Seeders;

use App\Models\ColorsPredefined;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorsPredefinedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = collect([
            '#9A8BF2',
            '#FB67A1',
            '#F49291',
            '#08EBFC',
            '#00BBC9',
            '#007A7C',
            '#F75A68',
            '#E93848',
            '#F49220',
            '#D27508',
            '#A4F420',
            '#629B06',
            '#202022',
            '#343436',
            '#ECECEC',
            '#878787',
        ]);


        for ($i = 0; $i < 10; $i++) {
            $randomColors = $colors->shuffle()->take(3)->values();

            ColorsPredefined::create([
                'cor_1' => $randomColors[0],
                'cor_2' => $randomColors[1],
                'cor_3' => $randomColors[2],
            ]);
        }
    }
}
