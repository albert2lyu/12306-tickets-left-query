<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Station;
use yii\console\Controller;
use app\models\Dirtydata;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($action)
    {
        echo "start\n";
        Dirtydata::loadAll();
        echo "end\n";
        return 0;
        if($action=='loaddirtydata'){
            Dirtydata::loadAll();
            return 0;
        }else if($action=='loadstationcode'){
            Station::loadStationCode();
            return 0;
        }else if($action=='loadstationstarttime'){
            Station::loadStationStartTime();
            return 0;
        }
        return 0;
    }
}
