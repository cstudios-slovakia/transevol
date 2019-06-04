<?php namespace app\support\Timeline\Collectors;

use app\support\Timeline\TickerStep;

use Illuminate\Support\Collection;

class TickerCollector
{
    /** @var Collection */
    protected $tickers;

    /** @var float */
    protected $maxValue = 0;

    public function collectable() : Collection
    {

//        $byPosition = $this->groupByPosition($this->tickers);
//
//        dd($byPosition);
        return $this->tickers->groupBy(function(TickerStep $tickerStep){
            return $tickerStep->getKnot()->getPosition()->timestamp;
        })->map(function (Collection $collection){
//            dd($collection);



            $valueSum   = $collection->sum(function (TickerStep $ticker){
                return $ticker->getStepValue(true);
            });

            $ticker     = $collection->last();

            if ($valueSum > $this->maxValue){
                $this->maxValue     = $valueSum;
            }

            return $item =  [
                'id' => $ticker->getKnot()->getPosition()->timestamp,
                'content' => (string) $this->tickMoney($valueSum),
                'className' => 'item--tick',
                'start' => $ticker->getStepDate()->format('c'),
                'valueSum'  => $valueSum,
                'attributes'    => [
                    'position'  => $ticker->getPartPosition()
                ]
            ];
        })->values();

    }

    public function groupByPosition(Collection $tickers) : Collection
    {
        return $tickers->groupBy(function(TickerStep $tickerStep){
            return $tickerStep->getPartPosition();
        });
    }

    protected function tickMoney($value, string $currency = '€') : string
    {
        return sprintf('%s'.$currency,$value);
    }

    /**
     * Changes date by part position
     *
     * @param string $position
     * @return string
     */
    protected function tickDateIn(string $position) : string
    {
        $date   = 'Y-m-d';
        $time   = 'H';

        if ($position === 'left' || $position === 'right'){
            return $date. ' '.$time.':i';
        }

        return $date . ' '. $time;
    }

    public function mapToJson()
    {
        $drivers = $this->collectable();


        return $drivers->toJson();
    }

    /**
     * @param Collection $tickers
     * @return TickerCollector
     */
    public function setTickers(Collection $tickers)
    {
        $this->tickers = $tickers;

        return $this;
    }

    /**
     * @return float
     */
    public function getMaxValue(): float
    {
        return $this->maxValue;
    }


}