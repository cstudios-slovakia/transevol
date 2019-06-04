<?php namespace app\support\Schemas\Charts;

use app\support\helpers\HasAttributes;
use Illuminate\Contracts\Support\Arrayable;

class CanvasDataPoint implements \ArrayAccess  {

    use HasAttributes;

    public function __construct(array $pointData)
    {
        foreach ($pointData as $key => $dataValue){
            $this->setAttribute($key, $dataValue);
        }
    }


    public function getAxisX()
    {
        return $this->getAttribute('x');
    }

    public function getAxisY()
    {
        return $this->getAttribute('y');
    }


}