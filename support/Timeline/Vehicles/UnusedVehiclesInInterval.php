<?php namespace app\support\Timeline\Vehicles;

use app\models\Vehicles;
use app\support\Timeline\Intervals\IntervalBuilderContract;
use app\support\Timeline\Intervals\IntervalTickersBuilder;
use app\support\Timeline\Intervals\TimeLineElementOverInterval;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;
use yii\db\Query;


class UnusedVehiclesInInterval
{

    /**
     * @var Collection
     */
    protected $elementsOverInterval;

    /** @var Collection */
    protected $unUsedData;

    public function __construct(Collection $elementsOverInterval)
    {
        $this->elementsOverInterval     = $elementsOverInterval;

        $this->unUsedData = collect([]);
    }
    
    public function unUsedIntervals() : Collection
    {
         $this->elementsOverInterval->each(function (TimeLineElementOverInterval $elementOverInterval){
            $usedInterval   = $elementOverInterval->getOverElementInterval();

            $unUsedPeriod = Period::make($usedInterval->getIntervalStarts(), $usedInterval->getIntervalEnds(), Precision::MINUTE);
            $mainInterval = Period::make($elementOverInterval->getInterval()->getIntervalStarts(), $elementOverInterval->getInterval()->getIntervalEnds(), Precision::MINUTE);
            $notUsedPeriods = $mainInterval->diff($unUsedPeriod);

             $periodTickers     = [];

             foreach ($notUsedPeriods as $notUsedPeriod){
                 $periodTickers[] = new IntervalTickersBuilder(Carbon::createFromTimestamp($notUsedPeriod->getStart()->getTimestamp()), Carbon::createFromTimestamp($notUsedPeriod->getEnd()->getTimestamp()));

             }

             $data  = [
                 'checkedVehicle'   => $element = $elementOverInterval->getElement(),
                 'checkedOnInterval'    => $elementOverInterval->getInterval(),
                 'unUsedPeriods'    => $notUsedPeriods,
                 'tickers'  => $periodTickers
             ];

             $this->unUsedData->put($element->vehicle_id, $data);
        });

        return $this->unUsedData;
    }
    
    
}