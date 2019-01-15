<?php

namespace app\components\ViewTyped\Page\Index;

use yii\grid\GridView;

class BaseGridView extends GridView
{
    public $tableOptions = [
        'class' => 'table table-striped- table-bordered table-hover table-checkable',
        'id' => 'm_table_1'
    ];
}