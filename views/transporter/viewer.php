<?php
use yii\helpers\Url;

/* @var $this yii\web\View */


?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>

<div class="m-stack m-stack--ver m-stack--general ">
    <div class="m-stack__item m-stack__item--left">
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <a href="<?= Url::toRoute('/api/v1/goings/create')?>" class="btn btn-secondary">Zacat vykon</a>
            <a href="<?= Url::toRoute('/api/v1/goings/ending') ?>" class="btn btn-secondary">Ukoncit vykon</a>
        </div>
    </div>
    <div class="m-stack__item m-stack__item--center">
        <button type="button" class="btn btn-secondary">Pridat prepravu</button>

    </div>
    <div class="m-stack__item m-stack__item--right">
        <span>Naves/Prives</span>
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-brand">Pridat</button>
            <button type="button" class="btn btn-brand">Odobrat</button>
        </div>

        <span>Vodic</span>
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-metal">Pridat</button>
            <button type="button" class="btn btn-metal">Odobrat</button>
        </div>

    </div>
</div>






<?php $this->endContent(); ?>
