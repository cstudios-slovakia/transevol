<?php
$cancelUrlText = isset($cancelUrlText) && !empty($cancelUrlText) ? $cancelUrlText : Yii::t('view/pages/create','Cancel');
?>
<div class="m-form__actions m-form__actions">
    <button type="submit" class="btn btn-primary"><?= Yii::t('view/pages/create','Save') ?></button>
    <a class="btn btn-secondary" href="<?= $cancelUrl ?>"><?= $cancelUrlText ?></a>
</div>