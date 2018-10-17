<?php

use yii\db\Migration;

/**
 * Class m181017_115212_TransportVehicleStaticCostContractsForeign
 */
class m181017_115212_TransportVehicleStaticCostContractsForeign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-transport_vehicle_static_cost-transport__vehicle_id',
            'transport_vehicle_static_cost',
            'transport__vehicle_id'
        );
        $this->addForeignKey(
            'fk-transport_vehicle_static_cost-transport__vehicle_id',
            'transport_vehicle_static_cost',
            'transport__vehicle_id',
            'transport__vehicle',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transport_vehicle_static_cost-static_costs_id',
            'transport_vehicle_static_cost',
            'static_costs_id'
        );
        $this->addForeignKey(
            'fk-transport_vehicle_static_cost-static_costs_id',
            'transport_vehicle_static_cost',
            'static_costs_id',
            'static_costs',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-transport_vehicle_static_cost-transport__vehicle_id','transport_vehicle_static_cost');
        $this->dropForeignKey('fk-transport_vehicle_static_cost-static_costs_id','transport_vehicle_static_cost');

        $this->dropIndex('idx-transport_vehicle_static_cost-transport__vehicle_id','transport_vehicle_static_cost');
        $this->dropIndex('idx-transport_vehicle_static_cost-static_costs_id','transport_vehicle_static_cost');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_115212_TransportVehicleStaticCostContractsForeign cannot be reverted.\n";

        return false;
    }
    */
}
