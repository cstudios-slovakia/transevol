<?php

namespace app\seeders;

class EmissionsSeeder extends Seeder
{
    public function run()
    {
        $records = [
                [1,'EURO5'],
                [2,'EURO6'],
                [3,'FilterEltomitoNorma2024'],

        ];
        $columnConfig = [false,'emission_name'];

        $this->table('emission_classes')->data($records, $columnConfig)->rowQuantity(count($records));

    }
}