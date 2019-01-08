<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Places */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Places', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title'] = $model->place_name;

?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
<div class="places-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'place_name',
            'position',
            ['attribute' => 'countries_id', 'value' => $model->countries->country_name],
            ['attribute' => 'addresses_id', 'value' => $model->addresses->getFullAddress()],
            ['attribute' => 'place_types_id', 'value' => Yii::t('place',$model->placeTypes->placetype_name)]
        ],
    ]) ?>

</div>
<?php $this->endContent(); ?>


