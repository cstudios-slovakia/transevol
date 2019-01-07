<?php

namespace app\support\LayoutSupporters\Grid;

use yii\helpers\Html;
use Yii;

class DefaultActionColumn
{

    /**
     * Supported actions on column.
     * @var array
     */
    public $buttons = ['view','update','delete'];

    /**
     * @var array
     */
    protected $actionColumnSettings = ['class' => 'yii\grid\ActionColumn'];

    public $additionalOptions = [];
    public $buttonOptions = [];

    /**
     * Icon is wrapped into button.
     * @var array
     */
    public $icons = [
        'update'    => 'la la-edit',
        'view'      => 'la la-folder-open-o',
        'delete'    => 'la la-trash-o',
    ];

    /**
     * Define button translations.
     * @var array
     */
    public $buttonTitle = [
        'update'    => ['common/pages/index','Edit record'],
        'view'      => ['common/pages/index','Show record'],
        'delete'    => ['common/pages/index','Delete record'],
    ];


    /**
     * Rendering action columns. Columns have predefined buttons and options.
     * @return array
     */
    public static function renderActionsColumns() : array
    {
        $instance   = new self();

        $instance->composeActionButtons();

        return array_merge($instance->actionColumnSettings,[
            'buttons'   => $instance->buttons
        ]);
    }

    protected function composeActionButtons() : self
    {
        foreach ($this->buttons as $index => $action){
            unset($this->buttons[$index]);
            $this->buttons[$action] = $this->renderSpecificButton($action);
        }

        return $this;
    }


    /**
     * Rendering action specific button.
     * @param string $actionType
     * @return callable
     */
    protected function renderSpecificButton(string $actionType) : callable
    {
        return function ($url, $model, $key) use ($actionType)  {

            $icon = $this->composeButtonIcon($actionType);

            $aTitle  = $this->translateForButton($actionType);

            $options = array_merge($this->commonButtonOptions(), [
                'title' => $aTitle,
                'aria-label' => $aTitle,
            ]);

            return Html::a($icon, $url, $options);
        };
    }

    /**
     * Generates icon inside button.
     * @param string $forAction Define button action is needed.
     * @return string
     */
    protected function composeButtonIcon(string $forAction) : string
    {
        return Html::tag('i', '', ['class' => $this->icons[$forAction]]);
    }

    /**
     * @param string $forAction
     * @return string
     */
    protected function translateForButton(string $forAction) : string
    {
        $actionToTranslate = $this->buttonTitle[$forAction];

        return Yii::t($actionToTranslate[0],$actionToTranslate[1]);
    }

    /**
     * Commonly defined buttonOptions are here.
     * @return array
     */
    protected function commonButtonOptions() : array
    {
        $options = array_merge([
            'class' => 'm-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill',
            'data-pjax' => '0',
        ], $this->additionalOptions, $this->buttonOptions);

        return $options;
    }

}