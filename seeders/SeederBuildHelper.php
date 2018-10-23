<?php

namespace app\seeders;

class SeederBuildHelper
{
    /** @var  string */
    protected $resolvable;

    public function buildResolvablePath(string $resolvable) : string
    {
        $this->resolvable = \Yii::getAlias('@seeder').'\\'.$resolvable;

        return $this->resolvable;
    }

    public function makeSeeder(string $seeder) : Seeder
    {
        return new $seeder();
    }
}