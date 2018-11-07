<?php

namespace app\seeders;

class VehicleTypeSeeder extends Seeder
{
    public function run()
    {
        // TODO define translatable prefixes
        $records = [
            [1,'Ťahač'],
            [2,'Príves'],
            [3,'Náves'],

        ];
        $columnConfig = [false,'vehicle_type_name'];

        $this->table('vehicle_types')->data($records, $columnConfig)->rowQuantity(count($records));
    }
}