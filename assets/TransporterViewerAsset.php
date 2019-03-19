<?php

namespace app\assets;

use app\assets\AppAsset;

class TransporterViewerAsset extends AppAsset
{

    public $css = [
        'vendors/base/vendors.bundle.css',
        'demo/default/base/style.bundle.css',
        'demo/default/media/img/logo/favicon.ico',
        'vendors/plugins/timeline/vis.css',
        'css/timeline.css'
    ];

    public $js = [
        'vendors/base/vendors.bundle.js',
        'demo/default/base/scripts.bundle.js',
        'demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js',
        'js/default/pages/timeline_viewer.js',
        'https://www.gstatic.com/charts/loader.js',
        'js/default/pages/timeline_chart.js',
        'vendors/plugins/timeline/vis.js',
        'https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.1/handlebars.amd.min.js'
    ];
}