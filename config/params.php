<?php

return [
    'adminEmail' => 'admin@example.com',
    'version'   => '0.0.2',
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
                // liquid statics :S
                ['main_vehicle','mnvhcl'],
                ['main_with_trailer_is_empty','mnvhcl_trlr_empty'],
                ['main_with_trailer_by_weight','mnvhcl_trlr_weight'],
            ],
            'company' => [
                ['mass_required_insurance','mass_req_ins'],
                ['mass_collision_insurance','mass_cls_ins'],
                ['mass_cmr_insurance','mass_cmr_ins'],
                ['mass_accountable_insurance','mass_acc_ins'],
                ['adm_rental','adm_rntl'],
                ['adm_prev','adm_prev'],
                ['adm_buy_technic','adm_buy_thnc'],
                ['adm_disposal_rubbish','adm_disp_rbsh'],

            ]
        ],

    ]
];
