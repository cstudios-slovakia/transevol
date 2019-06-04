<?php
/** @var \app\support\Timeline\TimeLineTickerSchema $tickerSchema */
?>
<table>
    <tr>
        <th>TIME</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($perVehicleSchema as $date => $ticker): ?>
        <?php
        /** @var \app\support\Timeline\TickerStep $ticker */
        ?>

        <tr>
            <td>
                <?= $date ?>
            </td>
            <td>
                <?= $ticker ?>
            </td>
            <td></td>
            <td></td>
        </tr>

    <?php endforeach; ?>
</table>

<table>
    <tr>
        <th>TIME</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($vehicleSchema as $date => $ticker): ?>
        <?php
        /** @var \app\support\Timeline\TickerStep $ticker */


        ?>

        <tr>
            <td>
                <?= $date ?>
            </td>
            <td>
                <?= $ticker ?>
            </td>
            <td></td>
            <td></td>
        </tr>

    <?php endforeach; ?>
</table>

<!--<table>-->
<!--    <tr>-->
<!--        <th>TIME</th>-->
<!--        <th></th>-->
<!--        <th></th>-->
<!--        <th></th>-->
<!--    </tr>-->
<!--    --><?php //foreach ($unusedVehicleSchema as $date => $ticker): ?>
<!--        --><?php
//        /** @var \app\support\Timeline\TickerStep $ticker */
//
//
//        ?>
<!---->
<!--        <tr>-->
<!--            <td>-->
<!--                --><?//= $date ?>
<!--            </td>-->
<!--            <td>-->
<!--                --><?//= $ticker ?>
<!--            </td>-->
<!--            <td></td>-->
<!--            <td></td>-->
<!--        </tr>-->
<!---->
<!--    --><?php //endforeach; ?>
<!--</table>-->