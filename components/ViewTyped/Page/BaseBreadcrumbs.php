<?php

namespace app\components\ViewTyped\Page;

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class BaseBreadcrumbs extends Breadcrumbs
{
    public $itemTemplate = "<li class=\"m-nav__separator\">-</li><li class=\"m-nav__item\">
                                {link}
                            </li>\n";

    public $options = ['class' => 'm-subheader__breadcrumbs m-nav m-nav--inline'];
    public $encodeLabels = false;
    public $homeLink = [
        'label' => '<i class="m-nav__link-icon la la-home"></i>',
        'url' => '/',
        'template' => '<li class="m-nav__item m-nav__item--home">
                            <a href="http://localhost/transevol/web/" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>'
    ];
    /** @inheritdoc */
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }
        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }

}