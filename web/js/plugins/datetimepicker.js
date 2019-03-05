$(document).ready(function () {

    jQuery.datetimepicker.setLocale('sk');

    jQuery('.date-time-picker').datetimepicker({
        format:'Y-m-d H:i',
        inline:true
    });

});