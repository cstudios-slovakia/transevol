<?php

use yii\db\Migration;

/**
 * Class m181115_091121_AddFrequencyToCostDatas
 */
class m181115_091121_AddFrequencyToCostDatas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company_cost_datas','frequency_datas_id', $this->integer());
//        $this->addColumn('company_cost_datas','frequency_datas_id', $this->integer()->notNull());
        $this->createIndex(
            'idx-company_cost_datas-frequency_datas_id',
            'company_cost_datas',
            'frequency_datas_id'
        );
        $this->addForeignKey(
            'fk-company_cost_datas-frequency_datas_id',
            'company_cost_datas',
            'frequency_datas_id',
            'frequency_datas',
            'id',
            'CASCADE'
        );


        $this->addColumn('driver_cost_datas','frequency_datas_id', $this->integer());
//        $this->addColumn('driver_cost_datas','frequency_datas_id', $this->integer()->notNull());
        $this->createIndex(
            'idx-driver_cost_datas-frequency_datas_id',
            'driver_cost_datas',
            'frequency_datas_id'
        );
        $this->addForeignKey(
            'fk-driver_cost_datas-frequency_datas_id',
            'driver_cost_datas',
            'frequency_datas_id',
            'frequency_datas',
            'id',
            'CASCADE'
        );


        $this->addColumn('vehicle_static_costs','frequency_datas_id', $this->integer());
//        $this->addColumn('vehicle_static_costs','frequency_datas_id', $this->integer()->notNull());
        $this->createIndex(
            'idx-vehicle_static_costs-frequency_datas_id',
            'vehicle_static_costs',
            'frequency_datas_id'
        );
        $this->addForeignKey(
            'fk-vehicle_static_costs-frequency_datas_id',
            'vehicle_static_costs',
            'frequency_datas_id',
            'frequency_datas',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181115_091121_AddFrequencyToCostDatas cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_091121_AddFrequencyToCostDatas cannot be reverted.\n";

        return false;
    }
    */
}
