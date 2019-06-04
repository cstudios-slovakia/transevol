<?php namespace app\support\Timeline\Calculations;

trait StepHasDefinitions
{
    public $stepType;
    public $calculator;

    protected function defineStepType()
    {

        $this->stepType     = (new \ReflectionClass($this->calculator))->getName();
    }
}