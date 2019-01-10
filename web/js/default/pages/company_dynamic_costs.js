$(document).ready(function () {

    var addDynamicBtn = $('.add-dynamic-btn');
    var dynamicValue       = $('.dynamic-costs-value');
    var dynamicCostName    = $('.dynamic-costs-cost_name');
    var dynamicFrequencyDatasId    = $('.dynamic-costs-frequency_datas_id');
    var requestData = {
        cost_type   : null,
        value       : null,
        cost_name   : null,
        action      : 'create',
        frequency_datas_id : null
    };
    var currentValue;
    var currentCostName;

    addDynamicBtn.click(function(event) {
        event.preventDefault();

        var typeOfDynamics = $(this).data('dynamics-type');
        setInputsByType(typeOfDynamics);

        requestData = {
            cost_type       : typeOfDynamics,
            value           : currentValue.val(),
            cost_name   : currentCostName.val(),
            action   : 'create',
            frequency_datas_id : currentFrequencyDataId.val(),
            _csrf : $('meta[name="csrf-token"]').attr("content")
        };

        ajaxRequest();

    });

    function clearDynamicInputs(clearables) {
        $.each(clearables,function (i,clearableInput) {
            $(clearableInput).val('');
        });
    }

    function ajaxRequest() {
        console.log(ajaxUrl);
        $.ajax({
            url: ajaxUrl,
            type: 'post',
            dataType: 'text',
            data: requestData
        })
            .done(function(response) {
                $('.dynamic-costs-table--'+requestData.cost_type).html(response);
                console.log('.dynamic-costs-table--'+requestData.cost_type);
                console.log('requestData',requestData);
                clearDynamicInputs([currentValue,currentCostName]);
            })
            .fail(function() {
                alert('Not saved, or something wrong. Finish the error reporting.');
            });
    }

    $('.dynamic-costs-table').on('click','.btn-remove',function (e) {
        e.preventDefault();

        var recordIdent = $(this).parents('tr').data('dynamic-record-id');
        var typeOfDynamics = $(this).data('dynamics-type');
        requestData.action  = 'delete';
        requestData.id      = parseInt(recordIdent);
        requestData.cost_type       = typeOfDynamics;


        ajaxRequest();
    });

    $('.dynamic-cost-update--btn').click(function (e) {
        e.preventDefault();
        var typeOfDynamics = $(this).data('dynamics-type');
        var recordValue = $(currentValue).val();
        var recordCostName = $(currentCostName).val();
        var recordFrequencyDatasId = $(currentFrequencyDataId).val();
        requestData.action  = 'update';
        requestData.value      = recordValue;
        requestData.cost_name      = recordCostName;
        requestData.cost_type       = typeOfDynamics;
        requestData.frequency_datas_id       = recordFrequencyDatasId;
        ajaxRequest();
    });

    $('.dynamic-costs-table').on('click','.btn-edit',function (e) {
        e.preventDefault();

        var typeOfDynamics = $(this).data('dynamics-type');
        setInputsByType(typeOfDynamics);

        var record = $(this).parents('tr');
        var recordIdent = record.data('dynamic-record-id');
        var recordColumns = $(record).find('td');
        var recordValue = $(recordColumns).filter(function () {
            return $(this).data('dynamic-value')
        }).data('dynamic-value');
        var recordCostName = $(recordColumns).filter(function () {
            return $(this).data('dynamic-cost_name')
        }).data('dynamic-cost_name');
        var recordFrequencyDatasId = $(recordColumns).filter(function () {
            return $(this).data('dynamic-frequency_datas_id')
        }).data('dynamic-frequency_datas_id');

        requestData.id      = parseInt(recordIdent);


        $(currentValue).val(recordValue);
        $(currentCostName).val(recordCostName);
        $(currentFrequencyDataId).val(recordFrequencyDatasId);

    });

    function setInputsByType(type) {
        currentValue       = $(dynamicValue).filter('.dynamic-costs-value--'+type).first();
        currentCostName    = $(dynamicCostName).filter('.dynamic-costs-cost_name--'+type).first();
        currentFrequencyDataId    = $(dynamicFrequencyDatasId).filter('.dynamic-costs-frequency_datas_id--'+type).first();
    }
});