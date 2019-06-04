<?php
/**
 * Created by PhpStorm.
 * User: Eugen Juhos
 * Date: 09/05/2019
 * Time: 14:35
 */
namespace app\support\Timeline\Intervals;

use Carbon\Carbon;
use Carbon\CarbonInterval;

interface TickerContract
{
    public function intervalDifference() : CarbonInterval;

    /**
     * @return Carbon
     */
    public function getIntervalStarts() : Carbon;

    /**
     * @param Carbon $intervalStarts
     */
    public function setIntervalStarts(Carbon $intervalStarts);

    /**
     * @return Carbon
     */
    public function getIntervalEnds() : Carbon;

    /**
     * @param Carbon $intervalEnds
     */
    public function setIntervalEnds(Carbon $intervalEnds);
}