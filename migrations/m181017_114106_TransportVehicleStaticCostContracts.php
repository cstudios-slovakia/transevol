<?php

use yii\db\Migration;

/**
 * Class m181017_114106_TransportVehicleStaticCostContracts
 */
class m181017_114106_TransportVehicleStaticCostContracts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transport_vehicle_static_cost', [
            'id'                => $this->primaryKey(),
            'value'             => $this->decimal(10,6)->notNull(),
            'transport__vehicle_id'  => $this->integer()->notNull(),
            'static_costs_id'   => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);




    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('transport_vehicle_static_cost');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_114106_TransportVehicleStaticCostContracts cannot be reverted.\n";

        return false;
    }
    */
}
