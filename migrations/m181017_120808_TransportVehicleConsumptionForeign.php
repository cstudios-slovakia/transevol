<?php

use yii\db\Migration;

/**
 * Class m181017_120808_TransportVehicleConsumptionForeign
 */
class m181017_120808_TransportVehicleConsumptionForeign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-transport_vehicle_consumption-transport__vehicle_id',
            'transport_vehicle_consumption',
            'transport__vehicle_id'
        );
        $this->addForeignKey(
            'fk-transport_vehicle_consumption-transport__vehicle_id',
            'transport_vehicle_consumption',
            'transport__vehicle_id',
            'transport__vehicle',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-transport_vehicle_consumption-transport__vehicle_id','transport_vehicle_consumption');
        $this->dropIndex('idx-transport_vehicle_consumption-transport__vehicle_id','transport_vehicle_consumption');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_120808_TransportVehicleConsumptionForeign cannot be reverted.\n";

        return false;
    }
    */
}
