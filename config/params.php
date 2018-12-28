<?php

return [
    'adminEmail' => 'admin@example.com',
    'version'   => '0.0.6',
    'core'  => [
        'place_types'   => [
            'toll'          => 'places',
            'loading'       => 'places',
            'unloading'     => 'places',
            'services'      => 'listings',
            'clients'       => 'listings',
        ],
        'places'     => ['unloading','loading','toll'],
        'static_costs' => [
            'vehicle'   => [
                // ['non_translated_name','prefix_used_in_db']
                // see below
                ['leasing','lsng',Yii::t('static_costs','leasing')],
                ['road_tax','rdtx',Yii::t('static_costs','rdtx')],
                ['servis','srvs',Yii::t('static_costs','srvs')],
                ['other_a','otha',Yii::t('static_costs','otha')],
                ['other_b','othb',Yii::t('static_costs','othb')],
                ['pneumatic','pnmt',Yii::t('static_costs','pnmt')],
                ['common_insurance','cmins',Yii::t('static_costs','cmins')],
                ['collision_insurance','colins',Yii::t('static_costs','colins')],
                ['cmr_insurance','cmrins',Yii::t('static_costs','cmrins')],
                ['private_time_cost_a','privtma',Yii::t('static_costs','privtma')],
                ['private_time_cost_b','privtmb',Yii::t('static_costs','privtmb')],
                ['private_time_cost_c','privtmc',Yii::t('static_costs','privtmb')],
                // liquid statics :S
                ['main_vehicle','mnvhcl',Yii::t('static_costs','mnvhcl')],
                ['main_with_trailer_is_empty','mnvhcl_trlr_empty',Yii::t('static_costs','mnvhcl_trlr_empty')],
                ['main_with_trailer_by_weight','mnvhcl_trlr_weight',Yii::t('static_costs','mnvhcl_trlr_weight')],
            ],
            'company' => [
                ['mass_required_insurance','mass_req_ins',Yii::t('static_costs','mass_req_ins')],
                ['mass_collision_insurance','mass_cls_ins',Yii::t('static_costs','mass_cls_ins')],
                ['mass_cmr_insurance','mass_cmr_ins',Yii::t('static_costs','mass_cmr_ins')],
                ['mass_accountable_insurance','mass_acc_ins',Yii::t('static_costs','mass_acc_ins')],
                ['adm_rental','adm_rntl',Yii::t('static_costs','adm_rntl')],
                ['adm_prev','adm_prev',Yii::t('static_costs','adm_prev')],
                ['adm_buy_technic','adm_buy_thnc',Yii::t('static_costs','adm_buy_thnc')],
                ['adm_disposal_rubbish','adm_disp_rbsh',Yii::t('static_costs','adm_disp_rbsh')],

            ],
            'driver' => [
                ['luncheon_voucher','lnch',Yii::t('static_costs','lnch')],
                ['wage_for_km','wgfr',Yii::t('static_costs','wgfr')],
                ['loadings','ldng',Yii::t('static_costs','ldng')],
                ['constant_salary','cslr',Yii::t('static_costs','cslr')] ,
                ['luncheon_voucher_dual','lnch_dual',Yii::t('static_costs','lnch_dual')],
                ['wage_for_km_dual','wgfr_dual',Yii::t('static_costs','wgfr_dual')],
                ['loadings_dual','ldng_dual',Yii::t('static_costs','ldng_dual')],

            ],
            'listings'  => ['services','clients'],
            ]   ,
    ]
];
