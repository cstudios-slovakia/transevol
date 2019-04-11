<?php namespace app\models\Calculations\TimeLine;

use app\support\Timeline\CalculationIntervalBuilder;
use app\support\Timeline\Units\Goings\BeginnerGoing;
use app\support\Timeline\Units\Goings\EnderGoing;
use app\support\Timeline\Units\Goings\InnerGoing;
use app\support\Timeline\Units\Goings\ThrougherGoing;
use yii\base\Model;

class GoingSectionUnit extends Model
{
    public $going_from;
    public $going_until;
    public $sectionPosition;
    public $calculationFrom;
    public $calculationUntil;
    public $intervalMinutes;
    public $id;
    /** @var  CalculationIntervalBuilder */
    public $sectionIntervalBuilder;

    public function rules()
    {
        return [
            [['going_from', 'going_until','sectionPosition','calculationFrom','calculationUntil','intervalMinutes','id','sectionIntervalBuilder'], 'safe'],
        ];
    }

    public function elapsedGoingTimeInHours() : int
    {

        return CalculationIntervalBuilder::intervalInHours($this->going_from, $this->going_until);
    }

    public function elapsedSectionTimeInHours() : int
    {
        return $this->sectionIntervalBuilder->getIntervalIn('hours');
    }

    public function buildHourlyIndexedElapsedTime() : array
    {
        $elapsed = [];

        switch ($this->sectionPosition){
            case 'beginners' :

                $beginnerGoing  = new BeginnerGoing($this);

                $begins = $this->elapsedSectionTimeInHours() - $beginnerGoing->elapsed();

                for ($i = 1; $i <= $this->elapsedSectionTimeInHours(); $i++) {
                    $elapsed[$i]    = 0;
                    if($i >= $begins){
                        $elapsed[$i]    = null;
                    }
                }

                break;
            case 'enders' :
                $enderGoing = new EnderGoing($this);

                $ends = $enderGoing->elapsed();

                for ($i = 1; $i <= $this->elapsedSectionTimeInHours(); $i++){
                    $elapsed[$i]    = 0;
                    if ($i <= $ends){
                        $elapsed[$i]    = null;
                    }
                }

                break;
            case 'inners' :
                $innerGoing     = new InnerGoing($this);
                $innerElapsed   = $innerGoing->elapsed();
                $innerStartsAtHour = $innerGoing->hoursUntilGoingStarts();
                $innerEndsAtHour = $innerStartsAtHour + $innerElapsed;

                for ($i = 1; $i <= $this->elapsedSectionTimeInHours(); $i++){
                    $elapsed[$i]    = 0;
                    if ($i >= $innerStartsAtHour && $i <= $innerEndsAtHour){
                        $elapsed[$i]    = null;
                    }
                }

                break;

            case 'throughers' :
                $througherGoing = new ThrougherGoing($this);

                for ($i = 1; $i <= $this->elapsedSectionTimeInHours(); $i++){
                    $elapsed[$i]    = null;
                }
                break;

        }

        return $elapsed;
    }


}