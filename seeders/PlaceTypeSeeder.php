<?php

namespace app\seeders;



class PlaceTypeSeeder extends Seeder
{
    public function run()
    {
        $options =
            [
                [1,'toll','toll'],
                [2,'loading','loading'],
                [3,'unloading','loading'],
                [4,'services','services'],
                [5,'clients','clients'],
            ];
        $columnConfig = [false,'placetype_name','place_section'];

        $this->table('place_types')->data($options, $columnConfig)->rowQuantity(count($options));

    }
}