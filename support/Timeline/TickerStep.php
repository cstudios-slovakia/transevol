<?php namespace app\support\Timeline;

use app\support\Timeline\Intervals\Knot;
use Carbon\Carbon;

class TickerStep{

    /** @var Carbon */
    protected $stepDate;

    /** @var float */
    protected $stepValue;

    /** @var string */
    protected $partPosition;

    /** @var Knot */
    protected $knot;

    /** @var string */
    public $stepType;

    public function __construct(Knot $knot, string $partPosition = 'middle')
    {
        $this->knot             = $knot;
        $this->partPosition     = $partPosition;

        $this->stepValue        = $knot->getValue();
        $this->stepDate         = $knot->getPosition();
        $this->stepType         = $knot->type;
    }

    public function getPositionInFormat(string $format = 'Y-m-d') : string
    {
        return $this->stepDate->format($format);
    }

    /**
     * @param bool $formatted
     * @return float
     */
    public function getStepValue(bool $formatted = false): float
    {
        if( ! $formatted){
            return $this->stepValue;
        }

        return $this->formatValue($this->stepValue);
    }

    protected function formatValue(float $value) : string
    {
        return number_format($value, 2,'.','');

    }

    /**
     * @return string
     */
    public function getPartPosition(): string
    {
        return $this->partPosition;
    }

    /**
     * @return Knot
     */
    public function getKnot(): Knot
    {
        return $this->knot;
    }

    /**
     * @return Carbon
     */
    public function getStepDate(): Carbon
    {
        return $this->stepDate;
    }


}