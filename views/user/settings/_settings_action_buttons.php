<?php
use yii\helpers\Url;
?>

<?php $this->beginBlock('action_btn_dropdown')?>
<?= $this->render('@app/views/layouts/default/common/pages/_action_btn_dropdown_item.php',['linkUrl' => Url::toRoute('/user/settings/profile'),'linkIconClass' => 'flaticon-user','linkText' => Yii::t('user', 'Profile')]) ?>
<?= $this->render('@app/views/layouts/default/common/pages/_action_btn_dropdown_item.php',['linkUrl' => Url::toRoute('/user/settings/account'),'linkIconClass' => 'flaticon-user-settings','linkText' => Yii::t('user', 'Account')]) ?>
<?php $this->endBlock() ?>