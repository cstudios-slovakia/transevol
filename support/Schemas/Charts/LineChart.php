<?php namespace app\support\Schemas\Charts;


class LineChart
{
    public $datetime;
    public $data;

    public function getSchema() : array
    {


        $schema     = ['dateTime' => $this->datetime];
        foreach ($this->data as $data){
            $schema = $schema + $data;
        }

        return $schema;

        return [$this->datetime, $this->value];
    }

    public function __construct(string $dateTime, $data)
    {
        $this->datetime     = $dateTime;


        $this->data        = $data;
//        dd($data);
    }

    public static function data(string $dateTime, ...$data)
    {
        return new self($dateTime, $data);
    }
}