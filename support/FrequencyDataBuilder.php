<?php

namespace app\support;

use app\models\FrequencyData;
use yii\db\Query;

class FrequencyDataBuilder implements FrequencyBuilderInterface
{
    protected $frequencyType;


    public function dropDownListOptions() : array
    {
        return collect($this->frequencyDatasForType($this->getFrequencyType()))
            ->pluck('frequency_name','frequency_datas_id')
            ->toArray();
    }

    public function frequencyDatasForType(string $typeName)
    {
        $query = $this->queryBuilder()
            ->where('frequency_group_name=:frequency_group_name', [':frequency_group_name' => $typeName])
            ->all();
;
        return $query;
    }

    public static function makeType(string $typeName) : FrequencyBuilderInterface
    {
        $self = new static();
        $self->setFrequencyType($typeName);

        return $self;
    }

    protected function queryBuilder()
    {
        $query = (new Query())
            ->from('frequency_datas')
            ->select(['frequency_datas.id AS frequency_datas_id','frequency_datas.frequency_name','frequency_groups.id AS frequency_groups_id','frequency_groups.frequency_group_name'])
            ->join('RIGHT JOIN','frequency_groups','frequency_groups.id = frequency_datas.frequency_groups_id');
        return $query;
    }

    /**
     * @return mixed
     */
    public function getFrequencyType()
    {
        if(!$this->frequencyType){
            throw new \Exception('Type is not set.');
        }
        return $this->frequencyType;
    }

    /**
     * @param mixed $frequencyType
     */
    public function setFrequencyType($frequencyType)
    {
        $this->frequencyType = $frequencyType;
    }

}