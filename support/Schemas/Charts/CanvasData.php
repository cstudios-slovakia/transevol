<?php namespace app\support\Schemas\Charts;

use Illuminate\Support\Collection;

class CanvasData
{
    /** @var array */
    protected $options;

    /** @var Collection */
    protected $dataPoints;

    public function __construct()
    {
        $options        =  new CanvasDataOptions();
        $this->options  = get_object_vars($options);

        $this->dataPoints = collect([]);
    }

    public function addDataPoints(CanvasDataPoint $dataPoint) : self
    {
        $this->dataPoints->push($dataPoint);

        return $this;
    }

    public function getDataSchema()
    {
        $schema     = collect($this->options);
//        $schema->merge($this->options);
//
//        dd($this);

        $schema->put('dataPoints', $this->dataPoints->map(function (CanvasDataPoint $dataPoint){
            return ['x' => $dataPoint->getAxisX(), 'y' => $dataPoint->getAxisY()];
        })->toArray());
        return $schema;
    }

    public function schemaInArray()
    {
        if ($this->getDataSchema() instanceof Collection){
            return $this->getDataSchema()->toArray();
        }

        return $this->getDataSchema();
    }

    /**
     * @param CanvasDataOptions $options
     */
    public function setOptions(CanvasDataOptions $options)
    {
        $this->options  = get_object_vars($options);
    }


}