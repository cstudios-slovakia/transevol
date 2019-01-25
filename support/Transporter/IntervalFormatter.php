<?php

namespace app\support\Transporter;

use Carbon\Carbon;

class IntervalFormatter
{
    protected $localeFormat = 'd.m.Y';
    protected $processFormat = 'Y-m-d';

    public function formatter(Carbon $carbon) : string
    {
        return $carbon->format($this->getProcessFormat());
    }

    /**
     * @return string
     */
    public function getLocaleFormat(): string
    {
        return $this->localeFormat;
    }

    /**
     * @param string $localeFormat
     */
    public function setLocaleFormat(string $localeFormat)
    {
        $this->localeFormat = $localeFormat;
    }

    /**
     * @return string
     */
    public function getProcessFormat(): string
    {
        return $this->processFormat;
    }

    /**
     * @param string $processFormat
     */
    public function setProcessFormat(string $processFormat)
    {
        $this->processFormat = $processFormat;
    }




}