<?php namespace app\support\Timeline\Units\Goings;


class EnderGoing extends GoingSectionPosition implements GoingPositionContract
{
    public function elapsed()
    {
        $start = self::carbonize($this->unit->calculationFrom);

        $end   = self::carbonize($this->unit->going_until);

        return $start->diffInRealHours($end);
    }
}