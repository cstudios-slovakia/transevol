<?php

use yii\db\Migration;

/**
 * Class m181017_101409_VehiclesStaticCostsForeign
 */
class m181017_101409_VehiclesStaticCostsForeign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-vehicle_static_costs-static_costs_id',
            'vehicle_static_costs',
            'static_costs_id'
        );
        $this->addForeignKey(
            'fk-vehicle_static_costs-static_costs_id',
            'vehicle_static_costs',
            'static_costs_id',
            'static_costs',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-vehicle_static_costs-vehicles_id',
            'vehicle_static_costs',
            'vehicles_id'
        );
        $this->addForeignKey(
            'fk-vehicle_static_costs-vehicles_id',
            'vehicle_static_costs',
            'vehicles_id',
            'vehicles',
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
            'fk-vehicle_static_costs-static_costs_id',
            'vehicle_static_costs'
        );

        $this->dropIndex(
            'idx-vehicle_static_costs-static_costs_id',
            'vehicle_static_costs'
        );



        $this->dropForeignKey(
            'fk-vehicle_static_costs-vehicles_id',
            'vehicle_static_costs'
        );

        $this->dropIndex(
            'idx-vehicle_static_costs-vehicles_id',
            'vehicle_static_costs'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_101409_VehiclesStaticCostsForeign cannot be reverted.\n";

        return false;
    }
    */
}
