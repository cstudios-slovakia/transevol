
var BootstrapDatepicker = function () {

    var arrows = {
        leftArrow   : '<i class="la la-angle-left"></i>',
        rightArrow  : '<i class="la la-angle-right"></i>'
    };

    //== Private functions
    var datepicker = function () {

        // input group layout
        $('.work-days-input').datepicker({
            weekStart: 1,
            todayBtn: true,
            language: "sk",
            orientation: "bottom right",
            zIndexOffset: 100,
            multidate: true,
            forceParse: false,
            // daysOfWeekDisabled: "06",
            rtl: false,
            todayHighlight: true,
            templates: arrows,
            startView : 'month',
            multidateSeparator: "|"
        });

    };

    return {
        // public functions
        init: function() {
            datepicker();
        }
    };
}();

jQuery(document).ready(function() {
    BootstrapDatepicker.init();

});