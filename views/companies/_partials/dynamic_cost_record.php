<?php
/* @var $this yii\web\View */
/* @var $model \app\models\CompanyDynamicCostsForm */
/* @var $dynamicCost \app\models\CompanyDynamicCosts */

?>
<tr data-dynamic-record-id="<?= $dynamicCost->id ?>">
    <td class="dynamic-cost_name" data-dynamic-cost_name="<?= $dynamicCost->cost_name ?>">
        <?= $dynamicCost->cost_name ?>
    </td>
    <td class="dynamic-value" data-dynamic-value="<?= $dynamicCost->value ?>">
        <?= $dynamicCost->value ?>
    </td>
    <td class="dynamic-frequency_datas_id" data-dynamic-frequency_datas_id="<?= $dynamicCost->frequencyDatas->id ?>">
       <?= $dynamicCost->frequencyDatas->frequency_name ?>
    </td>

    <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn-edit btn btn-secondary" data-dynamics-type="<?= $dynamicCost->cost_type ?>"><?= Yii::t('common','Edit') ?></button>
            <button type="button" class="btn-remove btn btn-secondary" data-dynamics-type="<?= $dynamicCost->cost_type ?>"><?= Yii::t('common','Delete') ?></button>
        </div>
    </td>
</tr>