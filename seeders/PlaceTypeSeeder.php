<?php

namespace app\seeders;



use app\support\helpers\AppParams;

class PlaceTypeSeeder extends Seeder
{
    public function run()
    {

        $options = collect(AppParams::getPlaceTypes())->transform(function($type,$place){
            return [false, $place, $type];
        })->toArray();

        $columnConfig = [false,'placetype_name','place_section'];

        $this->table('place_types')->data($options, $columnConfig)->rowQuantity(count($options));

    }
}