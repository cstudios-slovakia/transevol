<?php

use yii\db\Migration;

/**
 * Class m181017_102341_VehicleConsumptionsForeign
 */
class m181017_102341_VehicleConsumptionsForeign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-vehicle_consumptions-vehicles_id',
            'vehicle_consumptions',
            'vehicles_id'
        );
        $this->addForeignKey(
            'fk-vehicle_consumptions-vehicles_id',
            'vehicle_consumptions',
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
            'fk-vehicle_consumptions-vehicles_id',
            'vehicle_consumptions'
        );
        $this->dropIndex(
            'idx-vehicle_consumptions-vehicles_id',
            'vehicle_consumptions'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_102341_VehicleConsumptionsForeign cannot be reverted.\n";

        return false;
    }
    */
}
