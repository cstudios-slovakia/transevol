
        var addDynamicBtn = $('.add-dynamic-btn');
        var dynamicsContainer = $('.dynamic-costs-container');
        addDynamicBtn.click(function(event) {
            event.preventDefault();
            var  $dynamicCostType = $('#companydynamiccostsform-cost_type');
            var  $dynamicValue = $('#companydynamiccostsform-value');
            var  $dynamicCostName = $('#companydynamiccostsform-cost_name');
            $.ajax({
                url: '<?= \yii\helpers\Url::toRoute(['companies/ajax']); ?>',
                type: 'post',
                dataType: 'text',
                data: {
                    cost_type : $dynamicCostType.val(),
                    value : $dynamicValue.val(),
                    cost_name : $dynamicCostName.val(),
                    is_update : false
                }
            })
                .done(function(response) {
   $('.dynamic-costs-table table').prepend(response);
                    console.log(response);
                })
                .fail(function() {
                    console.log("error");
                });

        });
