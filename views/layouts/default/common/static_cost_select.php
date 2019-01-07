<?= $form
    ->field($record, '['.$record->short_name.']frequency_datas_id')
    ->dropDownList($dropDownOptions, ['options'=>[$selectedId=>['Selected'=>true]]])
    ->label(false)
?>