<?php

use yii\db\Migration;

/**
 * Class m181017_095439_DriversStaticCostDatas
 */
class m181017_095439_DriversStaticCostDatas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('driver_cost_datas', [
            'id'                => $this->primaryKey(),
            'value'             => $this->decimal(10,6)->notNull(),
            'static_costs_id'   => $this->integer()->notNull(),
            'drivers_id'        => $this->integer()->notNull(),

            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('driver_cost_datas');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_095439_DriversStaticCostDatas cannot be reverted.\n";

        return false;
    }
    */
}
