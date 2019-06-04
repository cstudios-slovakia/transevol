<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

use Illuminate\Support\Collection;

class IntervalTickersBuilder implements IntervalPartsBuilderContract
{
    use IntervalEndpointsFinder;
    use IntervalHasParts;

    /** @var Collection */
    protected $intervalParts;

    public function __construct(Carbon $intervalStarts, Carbon $intervalEnds)
    {
        $this->setIntervalStarts($intervalStarts);
        $this->setIntervalEnds($intervalEnds);
        $this->intervalParts = collect([]);
        $this->hourToStart();
        $this->hourToEnd();

        $this->makeIntervalParts();
    }


}