<?php

use yii\db\Migration;

/**
 * Class m181017_101302_VehiclesStaticCostsTable
 */
class m181017_101302_VehiclesStaticCostsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vehicle_static_costs', [
            'id' => $this->primaryKey(),
            'value' => $this->decimal(10,6)->notNull(),
            'static_costs_id' => $this->integer()->notNull(),
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
        $this->dropTable('vehicle_static_costs');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_101302_VehiclesStaticCostsTable cannot be reverted.\n";

        return false;
    }
    */
}
