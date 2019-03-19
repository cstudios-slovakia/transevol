$(document).ready(function () {

    var vehiclesSelector    = $('select[name=vehicles_id]');
    var dateRangeSelector   = $('#m_daterangepicker_2 .form-control');
    var dp;
    var timelineInterval = {
        setTimelineFrom : function setTimelineFrom(dateTime){
            this.timelineFrom = dateTime;
        },
        getTimelineFrom : function getTimelineFrom(){
            return this.timelineFrom;
        },
        setTimelineUntil: function setTimelineUntil(dateTime){
            this.timelineUntil = dateTime;
        },
        getTimelineUntil : function getTimelineUntil(){
            return this.timelineUntil;
        },


    };
    var dateTimePickerOptions = {
        buttonClasses   : 'm-btn btn',
        applyClass      : 'btn-primary',
        cancelClass     : 'btn-secondary',
        locale          : {
            format: 'DD.MM.YYYY'
        }
    };

    /*
    Timeline Builder
     */
    var timelineBuilder = {
        uri                 : modificatorUrl,
        timelineInterval    : null,
        timelineVehicleId   : null,
        setTimelineInterval : function setTimelineInterval(timelineInterval) {
            this.timelineInterval = timelineInterval;
        },
        getTimelineInterval : function getTimelineInterval() {
            return this.timelineInterval;
        },
        defineTimeline      : function defineTimeline() {
            var data = {
                _csrf : $('meta[name="csrf-token"]').attr("content")
            };

            data.vehicleId      = this.timelineVehicleId;
            data.timeLineFrom   = this.getTimelineInterval().getTimelineFrom();
            data.timeLineUntil  = this.getTimelineInterval().getTimelineUntil();

            // console.log('timelineBuilder sent data',data);

            $.post(this.uri,data, function (response) {

                console.log('timelineBuilder sent data',response);
                // window.location.reload(false);


            });
        }

    };


    /*
    Daterange selector
     */

    dateRangeSelector.val( timeLineFrom + ' - ' + timeLineUntil );

    // input group and left alignment setup
    dp =  dateRangeSelector.daterangepicker(dateTimePickerOptions, function(start, end, label) {
        dateRangeSelector.val( start.format('DD.MM.YYYY') + ' --- ' + end.format('DD.MM.YYYY'));
    });

    dp.on('apply.daterangepicker',function (e,picker) {
        timelineInterval.setTimelineFrom(picker.startDate.format('YYYY-MM-DD'));
        timelineInterval.setTimelineUntil(picker.endDate.format('YYYY-MM-DD'));

        timelineBuilder.defineTimeline();

        window.location.reload(false);

    });

    vehiclesSelector.on('change',function(){
        console.log('selector changed');
        var selected    = selectedVehicle();
        var vehicleId   = getSelectedVehicleId(selected);

        timelineBuilder.timelineVehicleId = vehicleId;
        timelineBuilder.defineTimeline();

        window.location.reload(false);
    });


    ////////////////
    ///////////////
    //////////////////////



    /*
    Defaults
     */
    timelineInterval.setTimelineFrom(dp.data('daterangepicker').startDate.format('YYYY-MM-DD'));
    timelineInterval.setTimelineUntil(dp.data('daterangepicker').endDate.format('YYYY-MM-DD'));


    timelineBuilder.setTimelineInterval(timelineInterval);
    timelineBuilder.timelineVehicleId = getSelectedVehicleId(selectedVehicle());
    timelineBuilder.defineTimeline();

    var x  = JSON.parse(driversData);


    // function transform(item){
    //
    //     return [
    //         item[0],
    //         item[1],
    //         item[2]
    //     ];
    // }
    var c = new Array();

    for(var i = 0; i < x .length; i++){
        // console.log(driversData);
        c.push(x);
    }
    console.log('x',x);

    var groups = [
        {
            id: 1,
            content: 'Výkony',
            className   : 'group--goings'
        },
        {
            id: 2,
            content: 'Prepravy',
            className   : 'group--transport'

        },
        {
            id: 3,
            content: 'Vozidlo',
            className   : 'group--vehicle'

        },
        {
            id: 4,
            content: 'Vodič',
            className   : 'group--driver'

            // Optional: a field 'className', 'style', 'order', [properties]
        },



    ];

    // DOM element where the Timeline will be attached
    var container = document.getElementById('visualization');

    var items = new vis.DataSet(x);

    var source   = document.getElementById("timeline-item-template").innerHTML;
    var itemTemplate = Handlebars.compile(source);

    // Configuration for the Timeline
    var options = {
        selectable              : false,
        zoomable                : false,
        // horizontalscroll        : false,
        moveable                : false,
        maxHeight : '800px',
        stack : true,
        stackSubgroups : true,
        start : timeLineNodeStart,
        end : timeLineNodeEnd,
        template : itemTemplate
    };

    // Create a Timeline
    var timeline = new vis.Timeline(container, items, options);
    timeline.setGroups(groups);

    $('#visualization').on('click','.item-inner--edit span',function () {
        var url  = $(this).data('href');
        var data = {
            _csrf : $('meta[name="csrf-token"]').attr("content")
        };

        $.get(url,data,function (response) {
            console.log('response from edit');

            $('#myModal').modal();
            $('#myModal .modal-body').html('');
            $('#myModal .modal-body').html(response);
        });

    });

    /*
    Helper Functions
     */

    function selectedVehicle() {
        return vehiclesSelector.find(':selected');
    }

    function getSelectedVehicleId(option) {
        return parseInt($(option).val());
    }

    // MODAL



});