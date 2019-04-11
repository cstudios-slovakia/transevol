<?php namespace app\support\Timeline\Calculations;

class CumulativeCalculation
{
    public $length;

    public $amount;

    public $result;

    public static function make($length, $amount) : self
    {
        $calculation = new self();

        $calculation->length = $length;
        $calculation->amount = $amount;

        return $calculation;
    }

    public function calculate()
    {
        $amount = $this->amount;
        for ($i = 1; $i <= $this->length; $i++){
            $this->result[]   = [
                'value' => $amount,
                'id'    => $i
            ];
            $amount += $this->amount;
        }

        return json_encode($this->result);
    }
}