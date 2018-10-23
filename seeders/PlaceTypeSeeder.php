<?php

namespace app\seeders;



class PlaceTypeSeeder extends Seeder
{
    public function run()
    {
        $options =
            [
                [1,'Colnica'],
                [2,'Nakládka'],
                [3,'Vykládka'],
            ];
        $columnConfig = [false,'placetype_name'];

        $this->table('place_types')->data($options, $columnConfig)->rowQuantity(count($options));

    }
}