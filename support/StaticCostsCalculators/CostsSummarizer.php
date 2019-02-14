<?php

namespace app\support\StaticCostsCalculators;

use Illuminate\Support\Collection;

class CostsSummarizer
{
    protected $countables;
    protected $costsSum = null;

    protected function count() : self
    {
        if (is_array($this->countables)){
            $this->countables = collect($this->countables);
        }

        $this->costsSum = 0;

        $this->countables->each(function($countable){

            if(! $countable instanceof StaticCostCalculator){
                throw new \Exception('Cost is not correctly prepared for calculation.');
            }

            $this->costsSum += $countable->costResult();
        });

        return $this;
    }

    public function sum() : float
    {
        $this->count();

        if(!is_null($sum = $this->costsSum)){
            return $sum;
        }

        $this->reset();

    }

    protected function reset() : self
    {
        $this->costsSum = null;

        return $this;
    }

    /**
     * @param array|Collection $countables
     */
    public function setCountables($countables)
    {
        $this->countables = $countables;
    }


}