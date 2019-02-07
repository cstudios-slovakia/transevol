<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */

$this->title = $model->ecv;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['portlet']['title'] = Yii::t('vehicle', 'Details for {vehicleEcv}',[
    'vehicleEcv' => $model->ecv
]);
?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
    <div class="vehicles-view">


    </div>

<?php $this->endContent(); ?>