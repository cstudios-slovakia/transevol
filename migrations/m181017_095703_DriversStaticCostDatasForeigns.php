<?php

use yii\db\Migration;

/**
 * Class m181017_095703_DriversStaticCostDatasForeigns
 */
class m181017_095703_DriversStaticCostDatasForeigns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // static costs
        $this->createIndex(
            'idx-driver_cost_datas-static_costs_id',
            'driver_cost_datas',
            'static_costs_id'
        );
        $this->addForeignKey(
            'fk-driver_cost_datas-static_costs_id',
            'driver_cost_datas',
            'static_costs_id',
            'static_costs',
            'id',
            'CASCADE'
        );

        // drivers
        $this->createIndex(
            'idx-driver_cost_datas-drivers_id',
            'driver_cost_datas',
            'drivers_id'
        );
        $this->addForeignKey(
            'fk-driver_cost_datas-drivers_id',
            'driver_cost_datas',
            'drivers_id',
            'drivers',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {


        $this->dropForeignKey(
            'fk-driver_cost_datas-static_costs_id',
            'driver_cost_datas'
        );
        $this->dropIndex(
            'idx-driver_cost_datas-static_costs_id',
            'driver_cost_datas'
        );


        $this->dropForeignKey(
            'fk-driver_cost_datas-drivers_id',
            'driver_cost_datas'
        );
        $this->dropIndex(
            'idx-driver_cost_datas-drivers_id',
            'driver_cost_datas'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_095703_DriversStaticCostDatasForeigns cannot be reverted.\n";

        return false;
    }
    */
}
