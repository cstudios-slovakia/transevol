var elDatePicker    = $('input[name="work_days"]');
var BootstrapDatepicker = function () {

    var arrows;
    if (mUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }

    //== Private functions
    var datepicker = function () {


        // input group layout
        elDatePicker.datepicker({
            weekStart: 0,
            todayBtn: true,
            language: "sk",
            orientation: "bottom right",
            zIndexOffset: 100,
            multidate: true,
            forceParse: false,
            daysOfWeekDisabled: "6",
            rtl: mUtil.isRTL(),
            todayHighlight: true,
            templates: arrows,
            container : '.container--datepicker',
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

    $('#btn-calendar').click(function (e) {
        elDatePicker.datepicker('show');

    });
});