<?php
/**
 * Created by PhpStorm.
 * User: Eugen Juhos
 * Date: 27/03/2019
 * Time: 13:04
 */
namespace app\support\Timeline;


/**
 * Class TimeLineIntervalBuilder
 * @package app\support\Timeline
 */
interface IntervalBuilderInterface
{

    public function buildIntervalStart() : self ;


    public function buildIntervalEnd() : self ;
}