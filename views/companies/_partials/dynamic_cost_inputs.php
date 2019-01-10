<?php

use yii\helpers\Html;

/** var string $dynamicCostBelongsTo */
/** var array $dropDownOptions */

?>

<div class="dynamic-costs-container dynamic-costs-container--<?= $dynamicCostBelongsTo ?>">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group">
                <?= Html::input('text', 'cost_name', null, ['class' => 'form-control m-input form-control m-input dynamic-costs-cost_name dynamic-costs-cost_name--' . $dynamicCostBelongsTo, 'placeholder' => Yii::t('company', 'Dynamic cost name')]) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group m-form__group">
                <?= Html::input('number', 'value', null, ['class' => 'form-control m-input dynamic-costs-value dynamic-costs-value--' . $dynamicCostBelongsTo, 'placeholder' => Yii::t('company', 'Dynamic cost value')]) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group m-form__group">
                <?= Html::dropDownList('frequency_datas_id', null, $dropDownOptions, ['class' => 'form-control m-input  dynamic-costs-frequency_datas_id dynamic-costs-frequency_datas_id--' . $dynamicCostBelongsTo]) ?>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group">

                <div class="btn-group m-btn-group" role="group" aria-label="...">
                    <button type="button"
                            class="btn btn-outline-metal m-btn m-btn--icon m-btn--outline-1x add-dynamic-btn add-dynamic-btn--<?= $dynamicCostBelongsTo ?>"
                            data-dynamics-type="<?= $dynamicCostBelongsTo ?>">
                        <span>
                            <i class="fa flaticon-add"></i>
                            <span>
                                <?= Yii::t('company', 'Add dynamic cost') ?>
                            </span>
                        </span>
                    </button>
                    <button type="button"
                            class="btn btn-outline-metal m-btn m-btn--icon m-btn--outline-1x dynamic-cost-update--btn "
                            data-dynamics-type="<?= $dynamicCostBelongsTo ?>">
                        <span>
                            <i class="fa flaticon-refresh"></i>
                            <span>
                                <?= Yii::t('company', 'Update') ?>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div><?= $content ?></div>

