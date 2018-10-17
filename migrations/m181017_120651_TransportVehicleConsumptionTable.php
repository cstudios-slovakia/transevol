<?php

use yii\db\Migration;

/**
 * Class m181017_120651_TransportVehicleConsumptionTable
 */
class m181017_120651_TransportVehicleConsumptionTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transport_vehicle_consumption', [
            'id' => $this->primaryKey(),
            'transport__vehicle_id'  => $this->integer()->notNull(),
            'empty_semi' => $this->decimal(10,6)->notNull(),
            'empty_solo' => $this->decimal(10,6)->notNull(),
            'empty_with_trailer' => $this->decimal(10,6)->notNull(),
            'by_tons' => $this->decimal(10,6)->notNull(),
            'adblue_percent' => $this->integer(3)->notNull(),
            'adblue_unit_price' => $this->decimal(10,6)->notNull(),
            'fromdatetime'  => $this->dateTime(),
            'vehicles_id' => $this->integer()->notNull(),

            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transport_vehicle_consumption');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_120651_TransportVehicleConsumptionTable cannot be reverted.\n";

        return false;
    }
    */
}
