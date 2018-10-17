<?php

use yii\db\Migration;

/**
 * Class m181017_105729_TransportDriverStaticCostContractTable
 */
class m181017_105729_TransportDriverStaticCostContractTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('transport__driver', [
            'id'                => $this->primaryKey(),
            'transports_id'     => $this->integer()->notNull(),
            'drivers_id'        => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);

        $this->createTable('transport_driver_static_cost_contracts', [
            'id'                => $this->primaryKey(),
            'transport__driver_id'  => $this->integer()->notNull(),
            'value'             => $this->decimal(10,6)->notNull(),
            'static_costs_id'   => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);

        $this->createIndex(
            'idx-transport__driver-transports_id',
            'transport__driver',
            'transports_id'
        );
        $this->addForeignKey(
            'fk-transport__driver-transports_id',
            'transport__driver',
            'transports_id',
            'transports',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transport__driver-drivers_id',
            'transport__driver',
            'drivers_id'
        );
        $this->addForeignKey(
            'fk-transport__driver-drivers_id',
            'transport__driver',
            'drivers_id',
            'drivers',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transport_driver_static_cost_contracts-transport__driver_id',
            'transport_driver_static_cost_contracts',
            'transport__driver_id'
        );
        $this->addForeignKey(
            'fk-transport_driver_static_cost_contracts-transport__driver_id',
            'transport_driver_static_cost_contracts',
            'transport__driver_id',
            'transport__driver',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transport_driver_static_cost_contracts-static_costs_id',
            'transport_driver_static_cost_contracts',
            'static_costs_id'
        );
        $this->addForeignKey(
            'fk-transport_driver_static_cost_contracts-static_costs_id',
            'transport_driver_static_cost_contracts',
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
        $this->dropForeignKey('fk-transport__driver-transports_id','transport__driver');
        $this->dropForeignKey('fk-transport__driver-drivers_id','transport__driver');
        $this->dropForeignKey('fk-transport_driver_static_cost_contracts-transport__driver_id','transport_driver_static_cost_contracts');
        $this->dropForeignKey('fk-transport_driver_static_cost_contracts-static_costs_id','transport_driver_static_cost_contracts');

        $this->dropIndex('idx-transport__driver-transports_id','transport__driver');
        $this->dropIndex('idx-transport__driver-drivers_id','transport__driver');
        $this->dropIndex('idx-transport_driver_static_cost_contracts-transport__driver_id','transport_driver_static_cost_contracts');
        $this->dropIndex('idx-transport_driver_static_cost_contracts-static_costs_id','transport_driver_static_cost_contracts');

        $this->dropTable('transport_driver_static_cost_contracts');
        $this->dropTable('transport__driver');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_105729_TransportDriverStaticCostContractTable cannot be reverted.\n";

        return false;
    }
    */
}
