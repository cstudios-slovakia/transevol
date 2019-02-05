//== Class definition
var dp;
var BootstrapDaterangepicker = function () {
    
    //== Private functions
    var demos = function () {
        console.log('timelineUntil',timelineUntil);
        $('#m_daterangepicker_2 .form-control').val( timelineFrom + ' / ' + timelineUntil );

        // input group and left alignment setup
        dp =  $('#m_daterangepicker_2').daterangepicker({
            buttonClasses: 'm-btn btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            locale: {
                format: 'DD.MM.YYYY'
            }
        }, function(start, end, label) {
            $('#m_daterangepicker_2 .form-control').val( start.format('DD.MM.YYYY') + ' / ' + end.format('DD.MM.YYYY'));
        });



    };

    return {
        // public functions
        init: function() {
            demos(); 

        }
    };
}();

jQuery(document).ready(function() {    
    BootstrapDaterangepicker.init();
});