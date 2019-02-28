$("document").ready(function(){
    $('.vehicles-index').on('click','#costs-calculation',function(){
        calculateCosts();
    });


    $('.vehicles-index').on('change','.work-days-input',function(){
        $(this).datepicker().on('hide', function(e) {
            $('#define-month').val('');
            calculateCosts();
        });
    });


    $('#define-month').on('change',function (e) {
        $(this).datepicker().on('hide',function (e) {
            calculateCosts();
        });
    });





    function getPickerDefiniatorDate() {
        return definedDate = $('#define-month').val();
    }

    function calculateCosts() {
        var workDays            = $('.work-days-input');
        var mainVehicleGrid     = $('#main-vehicle-table');
        var notMainVehicleGrid  = $('#not-main-vehicle-table');
        var companyDataGrid     = $('#company-data-table');
        var recalculatedMainVehicleGrid = $('#recalculated-main-vehicle-table');
        var inputs  = [];
        var url     = statisticsUrl;
        var data    = {
            input   : inputs,
            definedDate   : getPickerDefiniatorDate(),
            _csrf   : $('meta[name="csrf-token"]').attr("content")
        };

        $.each(workDays,function (k,workDay) {

            var record = {
                'identification'    : $(workDay).prop('name'),
                'workDates'         : $(workDay).val()
            };

            inputs.push(record);
        });

        blockManipulation();


        $.post(url,data,function (response) {
            var tables = response.data;

            mainVehicleGrid.html(tables.mainVehicleDataProvider);
            notMainVehicleGrid.html(tables.notMainVehicleDataProvider);
            companyDataGrid.html(tables.companyDataProvider);
            recalculatedMainVehicleGrid.html(tables.reCalculatedMainVehicleDataProvider);

            BootstrapDatepicker.init();

            unBlockManipulation();
        });
    }

    function blockManipulation() {
        mApp.block(".vehicles-index", {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "Počkajte..."
        });
    }

    function unBlockManipulation() {
        mApp.unblock(".vehicles-index");

    }

});