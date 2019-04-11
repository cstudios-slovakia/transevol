<?php namespace app\support\Timeline\Units\Goings;

use app\models\Calculations\TimeLine\GoingSectionUnit;
use Carbon\Carbon;

class GoingSectionPosition
{
    /**
     * @var GoingSectionUnit
     */
    protected $unit;

    /** @var int */
    protected $elapsedSectionHours;

    /**
     * @var int
     */
    protected $elapsedUnitHours;

    public function __construct(GoingSectionUnit $unit)
    {
        $this->unit     = $unit;
    }

    protected static function carbonize(string $dateTime, string $format = 'Y-m-d H:i') : Carbon
    {
        return Carbon::createFromFormat($format, $dateTime);
    }

 }