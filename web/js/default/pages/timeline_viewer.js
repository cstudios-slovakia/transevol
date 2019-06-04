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
    var calculationView = $('#calculation-view');
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
        turnLoaderOn();
        timelineInterval.setTimelineFrom(picker.startDate.format('YYYY-MM-DD'));
        timelineInterval.setTimelineUntil(picker.endDate.format('YYYY-MM-DD'));

        timelineBuilder.defineTimeline();

        drawDataIntoTimeLine();
        // window.location.reload(false);

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

    /*
    Begin - Calculation Interval Selector
    */

    var calcRangeGenerator = {
        start   : moment(calculationFrom, 'YYYY-MM-DD HH:mm'),
        end     : moment(calculationUntil, 'YYYY-MM-DD HH:mm'),
        uri     : window.rangeCalculatorUrl
    };
    var calculationRange = $('#calculation_interval');

    // reuse some default options
    // and modify another for calculatorRangePicker
    dateTimePickerOptions.timePicker            = true;
    dateTimePickerOptions.showDropdowns         = true;
    dateTimePickerOptions.linkedCalendars       = false;
    dateTimePickerOptions.locale = {
        format: 'DD.MM.YYYY HH:mm'
    };
    dateTimePickerOptions.startDate             = calcRangeGenerator.start;
    dateTimePickerOptions.endDate               = calcRangeGenerator.end;
    dateTimePickerOptions.timePicker24Hour      = true;

    // init picker
    var calcRangeSelector  = calculationRange.daterangepicker(dateTimePickerOptions, function(start, end, label) {
        calculationRange.val( start.format('YYYY-MM-DD HH:mm') +  ' - ' + end.format('YYYY-MM-DD HH:mm'));
    });

    // when datetime changes on calculater, set on global object for storing
    calcRangeSelector.on('apply.daterangepicker',function (e,picker) {
        turnLoaderOn();
        calcRangeGenerator.start    = picker.startDate;
        calcRangeGenerator.end      = picker.endDate;

        var calcFrom        = calcRangeGenerator.start.format('YYYY-MM-DD HH:mm');
        var calcUntil       = calcRangeGenerator.end.format('YYYY-MM-DD HH:mm');
        var data = {
            _csrf : $('meta[name="csrf-token"]').attr("content")
        };

        // data which is sent for calculating
        data.vehicleId          = timelineBuilder.timelineVehicleId;
        data.calculationFrom           = calcFrom;
        data.calculationUntil          = calcUntil;

        $.post(calcRangeGenerator.uri,data, function (response) {

            console.log('calcRangeGenerator sent data',response);
           drawDataIntoTimeLine();


        });
    });

    var btnTimeLineCalculate    = $('#calculate-timeline-section-btn');

    var resContainer = document.getElementById('resultVisual');
    var resOptions = {
        selectable              : false,
        zoomable                : false,
        // horizontalscroll        : false,
        moveable                : false,
    };
    var resItems = new vis.DataSet(resOptions);

    btnTimeLineCalculate.on('click', function (e) {



        e.preventDefault();

        var calcFrom        = calcRangeGenerator.start.format('YYYY-MM-DD HH:mm');
        var calcUntil       = calcRangeGenerator.end.format('YYYY-MM-DD HH:mm');

        var data = {
            _csrf : $('meta[name="csrf-token"]').attr("content")
        };
        // data which is sent for calculating
        data.vehicleId          = timelineBuilder.timelineVehicleId;
        data.calculationFrom           = calcFrom;
        data.calculationUntil          = calcUntil;

        $.post(timeLineSectionCalculatorUrl,data, function (response) {
            hideTimeLine();
            //
            console.log('btnTimeLineCalculate sent data',response);



            // Create a DataSet (allows two way data-binding)
            // var resItems = new vis.DataSet(JSON.parse(response.calc.unusedVehiclesSchema));

            // Configuration for the Timeline
            resItems.clear();
            resItems.add(JSON.parse(response.calc.tickersData.timeLine));
            // Create a Timeline
            var resTimeline = new vis.Timeline(resContainer, resItems, resOptions);

            //
            // console.log('btnTimeLineCalculate sent data',response);
            //
            // cumulativeTableHtml     = cumulativeTableTemplate({rows: JSON.parse(response.calculations.cumulative.hourlyCosts)});
            // calculationView.find('.calculation-view--body').html(cumulativeTableHtml);
            //
            //
            // showCalculationView();
            //
            // drawChart(JSON.parse(response.calc.tickersData.chart),'myPieChart');
            // drawChart(JSON.parse(response.calc.tickersData.chart1),'myPieChart1');
            // drawChart(JSON.parse(response.calc.tickersData.chart2),'myPieChart2');
            // drawChart(JSON.parse(response.calc.tickersData.chart3),'myPieChart3');
            // canvasData.concat( JSON.parse(response.calc.tickersData.chart));


            drawCanvasChart(JSON.parse(response.calc.tickersData.chart));

        });

    });

    /*
    End - Calculation Interval Selector
    */

    //////////////////////

    /*
    Defaults
     */
    timelineInterval.setTimelineFrom(dp.data('daterangepicker').startDate.format('YYYY-MM-DD'));
    timelineInterval.setTimelineUntil(dp.data('daterangepicker').endDate.format('YYYY-MM-DD'));

    timelineBuilder.setTimelineInterval(timelineInterval);
    timelineBuilder.timelineVehicleId = getSelectedVehicleId(selectedVehicle());
    timelineBuilder.defineTimeline();

    // var x  = JSON.parse(driversData);
    // console.log('DataSet',x);

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
            content: 'Náves-Príves',
            className   : 'group--vehicle'

        },
        {
            id: 4,
            content: 'Vodič',
            className   : 'group--driver'

            // Optional: a field 'className', 'style', 'order', [properties]
        }
    ];

    // DOM element where the Timeline will be attached
    var container = document.getElementById('visualization');

    // var items;
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

    // var items;
    var items = new vis.DataSet(options);
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

    var timeLineData = {
        data : {
            _csrf : $('meta[name="csrf-token"]').attr("content")
        },
        getTimeLineData : function getTimeLineData() {
            return $.post(timeLineDataBuilderUrl,this.data,function (response) {

                // return response;
            });
        }
    };

    var loader = $('.loader');
    function drawDataIntoTimeLine() {
        return $.when(  timeLineData.getTimeLineData() ).then(function( data, textStatus, jqXHR ) {
            console.log('loaded data', data);
            if (jqXHR.status === 200){
                items.clear();
                console.log(JSON.parse(data.timelineData.groupped));
                items.add(JSON.parse(data.timelineData.groupped));
                console.log(items);
                timeline.setItems(items);
                timeline.redraw();

                turnLoaderOff();
            }
        });
    }

    drawDataIntoTimeLine();

    /*
    Calculations from timeline
     */

    var cumulativeTableLayoutSource   = document.getElementById("calculations--cumulative-table").innerHTML;
    var cumulativeTableTemplate = Handlebars.compile(cumulativeTableLayoutSource);

    /*
    Graphs
     */

    google.charts.load('current', {packages: ['corechart']});
    // google.charts.setOnLoadCallback(drawChart);

    var chartOptions = {
        // width: 900,
        // height: 500,
        legend: {position: 'none'},
        enableInteractivity: true,
        chartArea: {
            width: '95%'
        },
        animation:{
            duration: 1000,
            easing: 'out',
        },
        hAxis: {
            // viewWindow: {
            //     min: new Date(2014, 11, 31, 18),
            //     max: new Date(2015, 0, 3, 1)
            // },
            gridlines: {
                count: -1,
                units: {
                    days: {format: ['MMM dd']},
                    hours: {format: ['HH:mm', 'ha']},
                },
                color: '#333'
            },
            minorGridlines: {
                units: {
                    hours: {format: ['hh:mm:ss a', 'ha']},
                    minutes: {format: ['HH:mm a Z', ':mm']}
                }
            }
        }
    };

    function drawCanvasChart(data) {
        // chart.addTo('data',data);
        console.log(data);
        // canvasData = [];
        $.each(data, function(key, row){
            $.each(row.dataPoints, function(key, value){
                value.x     = new Date(value.x);


            });

            console.log(row);
            canvasData.push(row);
        });
        chart.render();
    }

    function drawChart(rows,element) {
        // Define the chart to be drawn.
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'dateTime');
        data.addColumn('number', 'total');
        data.addColumn('number', 'costPerVehicle');
        data.addColumn('number', 'vehicleStaticCostsCalculator');
        data.addColumn('number', 'unusedVehicleStaticCostsCalculator');

        $.each(rows,function (i, row) {
            data.addRow([
                new Date(row.dateTime),
                row.total,
                row.costPerVehicle,
                row.vehicleStaticCostsCalculator,
                row.unusedVehicleStaticCostsCalculator
            ]);
        });



        // Instantiate and draw the chart.
        var chart = new google.visualization.LineChart(document.getElementById(element));
        chart.draw(data, chartOptions);
    }

    var closeCalculationViewBtn = $('.close-btn');
    closeCalculationViewBtn.click(function () {
        closeCalcultionView();
        showTimeLine();
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

    function turnLoaderOn() {
        loader.removeClass('hide');
    }

    function turnLoaderOff() {
        loader.addClass('hide');
    }

    function hideTimeLine() {
        $('#visualization').slideUp();
    }

    function showTimeLine() {
        $('#visualization').slideDown();
    }

    function showCalculationView() {
        calculationView.slideDown(700);
    }

    function closeCalcultionView() {
        calculationView.hide();
    }
    var canvasData = [];

    var chart;


    chart = new CanvasJS.Chart("myPieChart3", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "Cost for vehicles"
        },
        axisX:{
            valueFormatString: "HH:mm",
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
        },
        axisY: {
            title: "Costs in €",
            crosshair: {
                enabled: true
            }
        },
        toolTip:{
            shared:true
        },
        legend:{
            cursor:"pointer",
            verticalAlign: "bottom",
            horizontalAlign: "left",
            dockInsidePlotArea: true,
            itemclick: toogleDataSeries
        },
        data : canvasData
        // data: [{
        //     type: "line",
        //     showInLegend: true,
        //     name: "Total Visit",
        //     markerType: "square",
        //     xValueFormatString: "DD MMM, YYYY",
        //     color: "#F08080",
        //     dataPoints: [
        //         { x: new Date(2017, 0, 3), y: 650 },
        //         { x: new Date(2017, 0, 4), y: 700 },
        //         { x: new Date(2017, 0, 5), y: 710 },
        //         { x: new Date(2017, 0, 6), y: 658 },
        //         { x: new Date(2017, 0, 7), y: 734 },
        //         { x: new Date(2017, 0, 8), y: 963 },
        //         { x: new Date(2017, 0, 9), y: 847 },
        //         { x: new Date(2017, 0, 10), y: 853 },
        //         { x: new Date(2017, 0, 11), y: 869 },
        //         { x: new Date(2017, 0, 12), y: 943 },
        //         { x: new Date(2017, 0, 13), y: 970 },
        //         { x: new Date(2017, 0, 14), y: 869 },
        //         { x: new Date(2017, 0, 15), y: 890 },
        //         { x: new Date(2017, 0, 16), y: 930 }
        //     ]
        // },
        //     {
        //         type: "line",
        //         showInLegend: true,
        //         name: "Unique Visit",
        //         lineDashType: "dash",
        //         dataPoints: [
        //             { x: new Date(2017, 0, 3), y: 510 },
        //             { x: new Date(2017, 0, 4), y: 560 },
        //             { x: new Date(2017, 0, 5), y: 540 },
        //             { x: new Date(2017, 0, 6), y: 558 },
        //             { x: new Date(2017, 0, 7), y: 544 },
        //             { x: new Date(2017, 0, 8), y: 693 },
        //             { x: new Date(2017, 0, 9), y: 657 },
        //             { x: new Date(2017, 0, 10), y: 663 },
        //             { x: new Date(2017, 0, 11), y: 639 },
        //             { x: new Date(2017, 0, 12), y: 673 },
        //             { x: new Date(2017, 0, 13), y: 660 },
        //             { x: new Date(2017, 0, 14), y: 562 },
        //             { x: new Date(2017, 0, 15), y: 643 },
        //             { x: new Date(2017, 0, 16), y: 570 }
        //         ]
        //     }]
        //
    });

    function toogleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else{
            e.dataSeries.visible = true;
        }
        chart.render();
    }
});

