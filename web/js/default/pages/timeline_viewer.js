$(document).ready(function () {

    var vehiclesSelector = $('select[name=vehicles_id]');

    var timelineInterval = {
        setTimelineFrom :  function setTimelineFrom(dateTime){
            this.timelineFrom = dateTime;
        },
        getTimelineFrom :  function getTimelineFrom(){
            return this.timelineFrom;
        },
        setTimelineUntil: function setTimelineUntil(dateTime){
            this.timelineUntil = dateTime;
        },
        getTimelineUntil : function getTimelineUntil(){
            return this.timelineUntil;
        },
        formatToDate : function formatToDate(format) {
            var date = new Date(this.getTimelineFrom()).toLocaleDateString('sk-SK', {
                day : 'numeric',
                month : 'numeric',
                year : 'numeric'
            });
console.log(date);
            return new Date(date.year,date.month, date.day)
        }

    };

    function redirectViewer(href) {
        const modificator = new URLSearchParams(url);

        var location    = window.location;
        if (!href) href = location.href;
        var baseUri     = locationBuilder()+'?';
        var url         = href.replace(baseUri,'');
        var parameterized;

        /**
         * build query parameters
         */
        modificator.set('tfrom',timelineInterval.getTimelineFrom());
        modificator.set('tuntil',timelineInterval.getTimelineUntil());

        parameterized = modificator.toString();

        return addVehicleParameterToUrl(baseUri + parameterized);
    }

    function selectedVehicle() {
        return vehiclesSelector.find(':selected');
    }

    function getSelectedVehicleId(option) {
        return parseInt($(option).val());
    }

    function addVehicleParameterToUrl(href,vehicleId) {
        var parameterized;
        var location = window.location;
        if (!href) href = location.href;
        var baseUri = locationBuilder()+'?';
        var url = href.replace(baseUri,'');

        const modificator = new URLSearchParams(url);

        if(!vehicleId){
            vehicleId = getSelectedVehicleId(selectedVehicle());
        }
        modificator.set('vehicleId', vehicleId);
        parameterized = modificator.toString();

        redirector(baseUri+parameterized);

    }

    function locationBuilder() {
        var location = window.location;
        return location.origin + location.pathname;
    }

    function redirector(toUri) {
        window.location.href = toUri;
    }

    function defineVehicleId(vehicleId) {
        var uri = vehicleDefiniatorUrl;
        if(!vehicleId){
            vehicleId = getSelectedVehicleId(selectedVehicle());
        }
        $.post(uri,{vehicleId : vehicleId,_csrf : $('meta[name="csrf-token"]').attr("content")});
    }



    dp.on('apply.daterangepicker',function (e,picker) {
        timelineInterval.setTimelineFrom(picker.startDate.format('DD.MM.YYYY'));

        timelineInterval.setTimelineUntil(picker.endDate.format('DD.MM.YYYY'));

        redirectViewer();
    });

    vehiclesSelector.on('change',function(){
        var selected    = selectedVehicle();
        var vehicleId   = getSelectedVehicleId(selected);

        defineVehicleId(vehicleId);

        addVehicleParameterToUrl('',vehicleId);

        window.location.reload(false);
    });

    timelineInterval.setTimelineFrom(dp.data('daterangepicker').startDate.format('DD.MM.YYYY'));

    timelineInterval.setTimelineUntil(dp.data('daterangepicker').endDate.format('DD.MM.YYYY'));

    console.log(timelineInterval.formatToDate('YYYY'));
});