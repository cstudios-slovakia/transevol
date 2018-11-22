<?php
$dropDownOptions  = \app\support\FrequencyDataBuilder::makeType('time')->dropDownListOptions();

$selectedId = $record->id ? $record->frequency_datas_id : null;


?>
<?= $form->field($record, '['.$record->cost_name.']frequency_datas_id')->dropDownList($dropDownOptions, ['options'=>[$selectedId=>['Selected'=>true]]]) ?>