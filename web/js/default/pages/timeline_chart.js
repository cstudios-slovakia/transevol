google.charts.load('current', {'packages':['timeline']});
google.charts.setOnLoadCallback(drawChart);

var x  = JSON.parse(driversData);
// var x  = driversData;

function drawChart() {
    var container = document.getElementById('timeline');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();

    dataTable.addColumn({ type: 'string', id: 'President' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });





    var c = new Array();

    for(var i = 0; i < x .length; i++){
        // console.log(driversData);
        c.push(transform(x[i]));
    }
    dataTable.addRows(c);

    var options = {
        hAxis: {
            minValue: new Date(2019, 0, 4),
            maxValue: new Date(2019, 0, 25)
        }
    };
    chart.draw(dataTable,options);

    // console.log(x,c);
}

function transform(item){

    return [
        item[0],
        new Date(item[1]),
        new Date(item[2])
    ];
}