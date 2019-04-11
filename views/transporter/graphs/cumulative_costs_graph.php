<?php
use scotthuangzl\googlechart\GoogleChart;
?>
<?=

GoogleChart::widget(array('visualization' => 'LineChart',
    'data' => array(
        array('Year', 'Sales', 'Expenses'),
        array('2004', 1000, 400),
        array('2005', 1170, 460),
        array('2006', 660, 1120),
        array('2007', 1030, 540),
    ),
    'options' => array(
        'title' => 'My Company Performance2',
        'titleTextStyle' => array('color' => '#FF0000'),
        'vAxis' => array(
            'title' => 'Scott vAxis',
            'gridlines' => array(
                'color' => 'transparent'  //set grid line transparent
            )),
        'hAxis' => array('title' => 'Scott hAixs'),
        'curveType' => 'function', //smooth curve or not
        'legend' => array('position' => 'bottom'),
    )));

?>