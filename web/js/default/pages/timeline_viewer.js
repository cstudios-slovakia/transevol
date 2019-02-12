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
//         formatToDate : function formatToDate(format) {
//             var date = new Date(this.getTimelineFrom()).toLocaleDateString('sk-SK', {
//                 day : 'numeric',
//                 month : 'numeric',
//                 year : 'numeric'
//             });
// console.log(date);
//             return new Date(date.year,date.month, date.day)
//         }

    };

    // function redirectViewer(href) {
    //     const modificator = new URLSearchParams(url);
    //
    //     var location    = window.location;
    //     if (!href) href = location.href;
    //     var baseUri     = locationBuilder()+'?';
    //     var url         = href.replace(baseUri,'');
    //     var parameterized;
    //
    //     /**
    //      * build query parameters
    //      */
    //     modificator.set('tfrom',timelineInterval.getTimelineFrom());
    //     modificator.set('tuntil',timelineInterval.getTimelineUntil());
    //
    //     parameterized = modificator.toString();
    //
    //     return addVehicleParameterToUrl(baseUri + parameterized);
    // }



    // function addVehicleParameterToUrl(href,vehicleId) {
    //     var parameterized;
    //     var location = window.location;
    //     if (!href) href = location.href;
    //     var baseUri = locationBuilder()+'?';
    //     var url = href.replace(baseUri,'');
    //
    //     const modificator = new URLSearchParams(url);
    //
    //     if(!vehicleId){
    //         vehicleId = getSelectedVehicleId(selectedVehicle());
    //     }
    //     modificator.set('vehicleId', vehicleId);
    //     parameterized = modificator.toString();
    //
    //     redirector(baseUri+parameterized);
    //
    // }

    // function locationBuilder() {
    //     var location = window.location;
    //     return location.origin + location.pathname;
    // }
    //
    // function redirector(toUri) {
    //     window.location.href = toUri;
    // }

    // function defineVehicleId(vehicleId) {
    //     var uri = modificatorUrl;
    //     if(!vehicleId){
    //         vehicleId = getSelectedVehicleId(selectedVehicle());
    //     }
    //     $.post(uri,{vehicleId : vehicleId,_csrf : $('meta[name="csrf-token"]').attr("content")});
    // }

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
            data.timelineFrom   = this.getTimelineInterval().getTimelineFrom();
            data.timelineUntil  = this.getTimelineInterval().getTimelineUntil();

            console.log('timelineBuilder sent data',data);

            $.post(this.uri,data);
        }

    };


    /*
    Daterange selector
     */
    var tFrom = new Date(timelineFrom);
    console.log(tFrom,tFrom.toLocaleDateString('sk-SK'));
    dateRangeSelector.val( timelineFrom + ' --- ' + timelineUntil );

    // input group and left alignment setup
    dp =  dateRangeSelector.daterangepicker({
        buttonClasses: 'm-btn btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',
        locale: {
            format: 'DD.MM.YYYY'
        }
    }, function(start, end, label) {
        dateRangeSelector.val( start.format('DD.MM.YYYY') + ' --- ' + end.format('DD.MM.YYYY'));
    });

    dp.on('apply.daterangepicker',function (e,picker) {
        timelineInterval.setTimelineFrom(picker.startDate.format('YYYY-MM-DD'));
        timelineInterval.setTimelineUntil(picker.endDate.format('YYYY-MM-DD'));

        timelineBuilder.defineTimeline();

        window.location.reload(false);

    });

    vehiclesSelector.on('change',function(){
        var selected    = selectedVehicle();
        var vehicleId   = getSelectedVehicleId(selected);

        timelineBuilder.timelineVehicleId = vehicleId;
        timelineBuilder.defineTimeline();
        // defineVehicleId(vehicleId);

        // addVehicleParameterToUrl('',vehicleId);

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
    console.log('timelineBuilder',timelineBuilder);
    var x  = JSON.parse(driversData);


    function transform(item){

        return [
            item[0],
            item[1],
            item[2]
        ];
    }
    var c = new Array();

    for(var i = 0; i < x .length; i++){
        // console.log(driversData);
        c.push(x);
    }
    console.log('x',x);

    var groups = [
        {
            id: 1,
            content: 'Vodic'
            // Optional: a field 'className', 'style', 'order', [properties]
        },
        {
            id: 2,
            content: 'Vozidlo'
        }
    ];

    // DOM element where the Timeline will be attached
    var container = document.getElementById('visualization');

    var items = new vis.DataSet(x);


    // Create a DataSet (allows two way data-binding)
    // var items = new vis.DataSet([
    //     {id: 1, content: 'item 1', start: '2014-04-20'},
    //     {id: 2, content: 'item 2', start: '2014-04-14'},
    //     {id: 3, content: 'item 3', start: '2014-04-18'},
    //     {id: 4, content: 'item 4', start: '2014-04-16', end: '2014-04-19'},
    //     {id: 5, content: 'item 5', start: '2014-04-25'},
    //     {id: 6, content: 'item 6', start: '2014-04-27', type: 'point'}
    // ]);


    // Configuration for the Timeline
    var options = {
        selectable              : false,
        zoomable                : false,
        // horizontalscroll        : false,
        moveable                : false
    };
    console.log('items',items);
    // Create a Timeline
    var timeline = new vis.Timeline(container, items, options);
    timeline.setGroups(groups);

    /*
    Helper Functions
     */

    function selectedVehicle() {
        return vehiclesSelector.find(':selected');
    }

    function getSelectedVehicleId(option) {
        return parseInt($(option).val());
    }

});