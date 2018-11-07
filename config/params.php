<?php

return [
    'adminEmail' => 'admin@example.com',
    'core'  => [
        'place_types'   => ['toll','loading','unloading'],
        'place_collections'     => ['services','clients','loading','toll'],
        'static_costs' => [
            'vehicle'   => [
                // ['non_translated_name','prefix_used_in_db']
                // see below
                ['leasing','lsng'],
                ['road_tax','rdtx'],
                ['servis','srvs'],
                ['other_a','otha'],
                ['other_b','othb'],
                ['pneumatic','pnmt'],
                ['common_insurance','cmins'],
                ['collision_insurance','colins'],
                ['cmr_insurance','cmrins'],
                ['private_time_cost_a','privtma'],
                ['private_time_cost_b','privtmb'],
                ['private_time_cost_c','privtmc'],
            ]
        ]
    ]
];
