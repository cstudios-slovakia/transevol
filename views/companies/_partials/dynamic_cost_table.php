<?php
/* @var $this yii\web\View */
/* @var $dynamicCosts array */
?>
<?php
$form = isset($form) ? $form : \yii\widgets\ActiveForm::begin();
//dd($form);

?>
<table>
    <?php foreach ($dynamicCosts as $dynamicCost): ?>
        <?= $this->render('dynamic_cost_record',['dynamicCost' => $dynamicCost,'form' => $form]) ?>
    <?php endforeach; ?>
</table>
