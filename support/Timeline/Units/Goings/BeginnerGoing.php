<?php namespace app\support\Timeline\Units\Goings;


class BeginnerGoing extends GoingSectionPosition implements GoingPositionContract
{
    public function elapsed()
    {
        $start = self::carbonize($this->unit->going_from);

        $end   = self::carbonize($this->unit->calculationUntil);

        return $start->diffInRealHours($end);
    }
}