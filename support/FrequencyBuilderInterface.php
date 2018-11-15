<?php

namespace app\support;

interface FrequencyBuilderInterface
{
    public function dropDownListOptions() : array ;
    public function frequencyDatasForType(string $typeName);
    public static function makeType(string $typeName) : self;
}