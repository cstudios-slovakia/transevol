<?php
use yii\helpers\Url;

/**
 * @var $sectionName string
 * @var $headText string
 * @var $editIdParam integer
 * @var $editRoute string
 */

$sectionName = $this->context->id;

$headText = isset($this->params['page']) && isset($this->params['page']['show']) ? $this->params['page']['show']['portlet_title'] : $this->title;
$editIdParam = array_key_exists('id', $this->context->actionParams) ? (int) $this->context->actionParams['id'] : 0;

$portletTitle = isset($this->params['portlet']['title']) ? Yii::t('view/pages/show','Details for&nbsp;<strong>{sectionName}</strong>', [
    'sectionName' => $this->params['portlet']['title']
]) : Yii::t('view/pages/show','Details for {sectionName}', [
    'sectionName' => $sectionName
]);

$cancelUrl  = isset($cancelUrl) ? $cancelUrl : Url::toRoute('/'.$sectionName.'/index');

?>

<div class="m-portlet m-portlet--full-height ">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text text-uppercase">
                    <?=$portletTitle ?>
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <?php if (isset($this->blocks['headActions']) ): ?>
                <?= $this->blocks['headActions'] ?>
            <?php endif; ?>

        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-widget13">
            <?= $content ?>

            <div class="m-widget13__action m--align-right">
                <?php if (isset($this->blocks['editButton']) || $editIdParam < 1): ?>
                    <?= $this->blocks['editButton'] ?>
                <?php else: ?>
                    <?= $this->render('@app/views/layouts/default/common/buttons/detail_edit_btn.php',['url' => Url::toRoute([$sectionName.'/update','id' => $editIdParam],true)]) ?>
                <?php endif; ?>

                <?php if (isset($this->blocks['cancelButton'])): ?>
                    <?= $this->blocks['cancelButton'] ?>
                <?php else: ?>
                    <?= $this->render('@app/views/layouts/default/common/buttons/detail_cancel_btn.php',['cancelUrl' => $cancelUrl]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
