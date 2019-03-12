<?php

namespace app\support\Transporter;

use Carbon\Carbon;

class IntervalParts
{

    /** @var  Carbon */
    protected $start;

    /** @var  Carbon */
    protected $end;

    public function __construct()
    {
        $today      = Carbon::today();
        $yesterday  = Carbon::yesterday();

        $this->setStart($yesterday);
        $this->setEnd($today);
    }

    /**
     * @return Carbon
     */
    public function getStart(): Carbon
    {
        return $this->start;
    }

    /**
     * @param Carbon $start
     */
    public function setStart(Carbon $start)
    {
        $this->start = $start;
    }

    /**
     * @return Carbon
     */
    public function getEnd(): Carbon
    {
        return $this->end;
    }

    /**
     * @param Carbon $end
     */
    public function setEnd(Carbon $end)
    {
        $this->end = $end;
    }


}