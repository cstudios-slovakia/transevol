<?php namespace app\support\Timeline\Units\Goings;


class ThrougherGoing extends GoingSectionPosition implements GoingPositionContract
{
    public function elapsed()
    {
        $start = self::carbonize($this->unit->calculationFrom);

        $end   = self::carbonize($this->unit->calculationUntil);

        return $start->diffInRealHours($end);
    }
}