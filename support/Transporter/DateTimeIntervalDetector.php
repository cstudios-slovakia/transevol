<?php

namespace app\support\Transporter;

use Carbon\Carbon;
use Yii;
use yii\httpclient\Exception;

/**
 * Class DateTimeIntervalDetector
 * @package app\support\Transporter
 */
class DateTimeIntervalDetector
{
    CONST TIMELINE_FROM = 'tfrom';
    CONST TIMELINE_UNTIL = 'tuntil';
    /**
     * @var \yii\console\Request|\yii\web\Request
     */
    protected $request;
    /**
     * @var string
     */
    protected $method = 'get';

    /**
     * DateTimeIntervalDetector constructor.
     */
    public function __construct()
    {
        $this->request = Yii::$app->request;

        $this->formatter  = new IntervalFormatter();
    }


    /**
     * @param string $keyName
     * @return string
     */
    protected function getTimelineNode(string $keyName) : string
    {
//        $filteredRequestValue = $this->filterRequestByKey($keyName);

        if (empty($filteredRequestValue = $this->filterRequestByKey($keyName))){
            return $filteredRequestValue;
        }

        return $this->build($filteredRequestValue);
    }

    /**
     * @param string $keyName
     * @return string
     */
    public function getTimelineFrom(string $keyName = self::TIMELINE_FROM) : string
    {
        return $this->getTimelineNode($keyName);
    }

    /**
     * @param string $keyName
     * @return string
     */
    public function getTimelineUntil(string $keyName = self::TIMELINE_UNTIL) : string
    {
        return $this->getTimelineNode($keyName);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function build(string $value) : string
    {
        $format = $this->formatter->getLocaleFormat();

        $created  = Carbon::createFromFormat($format,$value);

        return $this->formatter->formatter($created);

    }

    /**
     * @return mixed
     */
    protected function requestData()
    {
        return $this->request->{$this->method}();
    }

    /**
     * @param string $key
     * @return string
     * @throws Exception
     */
    protected function filterRequestByKey(string $key) : string
    {
        $requestData = (array) $this->requestData();

        if (! array_key_exists($key, $requestData)){
            return '';
        }

        return $requestData[$key];
    }


    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = strtolower($method);
    }

    /**
     * @param IntervalFormatter $formatter
     */
    public function setFormatter(IntervalFormatter $formatter)
    {
        $this->formatter = $formatter;
    }


}