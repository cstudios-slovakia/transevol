<?php namespace app\support\Timeline\Filter;


use app\models\TransporterParts;
use yii\db\ActiveQuery;

class TimeLineTrasporterParts
{
    /** @var string */
    protected $timeLineFrom;

    /** @var string */
    protected $timeLineUntil;

    protected function query()
    {
        return TransporterParts::find()
            ->joinWith('transporter')
            ->joinWith([
                'places' => function (ActiveQuery $query) {
                    $query->joinWith('placeTypes');
                    $query->where(['placetype_name' => 'loading']);
                    $query->orWhere(['placetype_name' => 'unloading']);
                },
            ])
            ->with('placeTypes')
            ->with('places')
            ->andWhere(['between','event_time', $this->timeLineFrom .' 00:00:00', $this->timeLineUntil.' 23:59:59'])
            ->orderBy('event_time')
//            ->groupBy(['transporter.id','transporter_parts.id'])
            ;
    }

    public function getTransporterRecords()
    {
        return $this->query()->all();
    }

    /**
     * @param string $timeLineFrom
     */
    public function setTimeLineFrom(string $timeLineFrom)
    {
        $this->timeLineFrom = $timeLineFrom;
    }

    /**
     * @param string $timeLineUntil
     */
    public function setTimeLineUntil(string $timeLineUntil)
    {
        $this->timeLineUntil = $timeLineUntil;
    }
}