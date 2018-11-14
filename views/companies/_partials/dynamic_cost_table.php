<?php
/* @var $this yii\web\View */
/* @var $dynamicCosts array */
?>

<table>
    <?php foreach ($dynamicCosts as $dynamicCost): ?>
        <?= $this->render('dynamic_cost_record',['dynamicCost' => $dynamicCost]) ?>
    <?php endforeach; ?>
</table>
