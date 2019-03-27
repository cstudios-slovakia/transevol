<?php namespace app\support\Timeline\Intervals;

use app\support\Timeline\TimeLineIntervalBuilder;

class SessionDefinedIntervals
{
    protected $session;

    public function __construct()
    {
        $this->session = \Yii::$app->session;
    }

    protected function check(string $key) : bool
    {
        return $this->session->has($key);
    }

    protected function getIntervalNode(string $key) : ?string
    {
        if ( ! $this->check($key)){
            return null;
        }

        return $this->session->get($key);
    }

    public function getIntervalNodeFrom(string $fromKey = TimeLineIntervalBuilder::TIMELINE_FROM_KEY) : ?string
    {
        return $this->getIntervalNode($fromKey);
    }

    public function getIntervalNodeTo(string $untilKey = TimeLineIntervalBuilder::TIMELINE_UNTIL_KEY) : ?string
    {
        return $this->getIntervalNode($untilKey);
    }

    public function setIntervalNode(string $timeLineNodeKey, string $value)
    {
        $this->session->set($timeLineNodeKey, $value);
    }
}