<?php namespace app\support\Timeline\Units\Goings;


class InnerGoing extends GoingSectionPosition implements GoingPositionContract
{
    public function elapsed()
    {
        $start = self::carbonize($this->unit->going_from);

        $end   = self::carbonize($this->unit->going_until);

        return $start->diffInRealHours($end);
    }

    public function hoursUntilGoingStarts() : int
    {
        $start = self::carbonize($this->unit->calculationFrom);

        $end   = self::carbonize($this->unit->going_from);

        return $start->diffInRealHours($end);
    }
}