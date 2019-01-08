<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Listings */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Listings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title'] = $model->place_name;


?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php',['cancelUrl' => Url::toRoute('/listings/index?type='.$model->placeTypes->placetype_name)] ); ?>

<div class="listings-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'place_name',
            'email',
            'phone',
            [
                'attribute' => 'countries_id',
                'value'     => $model->addresses->countries->country_name
            ],
            [
                'attribute' => 'addresses_id',
                'value'     => $model->addresses->getFullAddress()
            ]

        ],
    ]) ?>

</div>

<?php $this->endContent(); ?>
