<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

class Knot
{

    /** @var Carbon */
    private $position;

    private $value;

    protected $previousKnot;

    /** @var string */
    public $type;

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param Carbon $position
     */
    public function setPosition(Carbon $position)
    {
        $this->position = $position;
    }

    /**
     * @param mixed $previousKnot
     */
    public function setPreviousKnot($previousKnot)
    {
        $this->previousKnot = $previousKnot;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Carbon
     */
    public function getPosition(): Carbon
    {
        return $this->position;
    }


}