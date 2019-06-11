<?php namespace app\support\Timeline\Units;

interface TimeLineElementContract
{
    public function startAttribute() : string ;
    public function endAttribute() : string ;
}