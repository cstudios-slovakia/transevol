<?php
/* @var $this yii\web\View */
/* @var $model \app\models\CompanyDynamicCostsForm */
/* @var $companyDynamicCost \app\models\CompanyDynamicCosts */
?>
<tr>
    <td>
        <?= $companyDynamicCost->cost_name ?>
    </td>
    <td>
        <?= $companyDynamicCost->value ?>
    </td>
    <td>
        <?= $companyDynamicCost->frequencyDatas->frequency_name ?>
    </td>
    <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn-edit btn btn-secondary">EDIT</button>
            <button type="button" class="btn-remove btn btn-secondary">REMOVE</button>
        </div>
    </td>
</tr>