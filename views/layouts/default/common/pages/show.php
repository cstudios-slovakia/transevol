<?php
use yii\helpers\Url;

/**
 * @var $sectionName string
 * @var $headText string
 * @var $editIdParam integer
 * @var $editRoute string
 */

$sectionName = $this->context->id;

$headText = isset($this->params['page']) && isset($this->params['page']['show']) ? $this->params['page']['show'] : $this->title;
$editIdParam = array_key_exists('id', $this->context->actionParams) ? (int) $this->context->actionParams['id'] : 0;


?>



<div class="m-portlet m-portlet--full-height ">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <?= Yii::t('view/pages/show','Details').': '. $headText ?>
                </h3>
            </div>
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
                <a href="<?= Url::toRoute($sectionName.'/index',true) ?>" class="btn m-btn--pill    btn-secondary"><?= Yii::t('view/pages/show','Cancel') ?></a>
            </div>
        </div>
    </div>
</div>
