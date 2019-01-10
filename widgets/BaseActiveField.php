<?php

namespace app\widgets;

use yii\widgets\ActiveField;

class BaseActiveField extends ActiveField
{
    public $inputOptions    = ['class' => 'form-control m-input'];
    public $errorOptions    = ['class' => 'm-form__help'];
    public $options         = ['class' => 'form-group m-form__group'];
}