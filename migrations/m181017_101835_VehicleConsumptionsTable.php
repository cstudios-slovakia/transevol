<?php

use yii\db\Migration;

/**
 * Class m181017_101835_VehicleConsumptionsTable
 */
class m181017_101835_VehicleConsumptionsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vehicle_consumptions', [
            'id' => $this->primaryKey(),
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
        $this->dropTable('vehicle_consumptions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_101835_VehicleConsumptionsTable cannot be reverted.\n";

        return false;
    }
    */
}
