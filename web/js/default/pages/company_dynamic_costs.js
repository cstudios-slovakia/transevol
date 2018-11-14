$(document).ready(function () {

    var addDynamicBtn = $('.add-dynamic-btn');
    var dynamicValue       = $('.dynamic-costs-value');
    var dynamicCostName    = $('.dynamic-costs-cost_name');

    addDynamicBtn.click(function(event) {
        event.preventDefault();

        var typeOfDynamics = $(this).data('dynamics-type');
        var  currentValue       = $(dynamicValue).filter('.dynamic-costs-value--'+typeOfDynamics).first();
        var  currentCostName    = $(dynamicCostName).filter('.dynamic-costs-cost_name--'+typeOfDynamics).first();

        $.ajax({
            url: ajaxUrl,
            type: 'post',
            dataType: 'text',
            data: {
                cost_type       : typeOfDynamics,
                value           : currentValue.val(),
                cost_name   : currentCostName.val(),
                is_update   : 1
            }
        })
        .done(function(response) {
            $('.dynamic-costs-table--'+typeOfDynamics+' table').prepend(response);

            clearDynamicInputs([currentValue,currentCostName]);
        })
        .fail(function() {
            alert('Not saved, or something wrong. Finish the error reporting.');
        });

    });

    function clearDynamicInputs(clearables) {
        $.each(clearables,function (i,clearableInput) {
            $(clearableInput).val('');
        });
    }



});