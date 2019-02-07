<?php
use yii\helpers\Url;

$sectionName = $this->context->id;

$portletTitle = isset($this->params['portlet']['title']) ? $this->params['portlet']['title'] : Yii::t('view/pages/index','Create {sectionName}', [
    'sectionName' => $sectionName
]);

?>

<div class="<?= $sectionName ?>-index">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <?php if (isset($this->blocks['customIndexHeadText']) ): ?>
                            <?= $this->blocks['customIndexHeadText'] ?>
                        <?php else: ?>
                            <?= Yii::t($sectionName,ucfirst($sectionName).' index') ?>
                        <?php endif; ?>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <?php if (isset($this->blocks['customNavItems']) ): ?>
                            <?= $this->blocks['customNavItems'] ?>
                        <?php else: ?>
                            <a href="<?= Url::toRoute($sectionName.'/create') ?>"
                               class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span><?= $portletTitle ?></span>
                            </span>
                            </a>
                        <?php endif; ?>

                    </li>

                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <?= $content ?>
        </div>
    </div>
</div>

