<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\seeders\SeederBuildHelper;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{

    public $resolvable;

    public function options($actionID)
    {
        return ['resolvable'];
    }

    public function optionAliases()
    {
        return ['class' => 'resolvable'];
    }

    /**
     * This command echoes what you have entered as the message.
     * @return int Exit code
     */
    public function actionMake()
    {

        $seederBuildHelper  = new SeederBuildHelper();
        $resolvable = $seederBuildHelper->buildResolvablePath($this->resolvable);

        if (class_exists($resolvable)) {
            $seeder     = $seederBuildHelper->makeSeeder($resolvable);

            $seeder->seeding();

            return ExitCode::OK;
        }

        return ExitCode::DATAERR;
    }

}
