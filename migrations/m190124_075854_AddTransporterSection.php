<?php

use yii\db\Migration;

/**
 * Class m190124_075854_AddTransporterSection
 */
class m190124_075854_AddTransporterSection extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transporter', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'companies_id' => $this->integer()->notNull(),
            'transport_price' => $this->decimal(10,6)->notNull(),
            'transport_other_costs' => $this->decimal(10,6)->defaultValue(0),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        $this->createTable('transporter_parts', [
            'id' => $this->primaryKey(),
            'event_time' => $this->datetime()->notNull(),
            'load_meter' => $this->integer()->null(),
            'load_weight' => $this->integer()->null(),
            'part_other_cost' => $this->decimal(10,6)->defaultValue(0),
            'places_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        $this->createTable('transporter_contents', [
            'transporter_id'            => $this->integer()->notNull(),
            'transporter_parts_id'      => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
        ]);


        // companies
        $this->createIndex(
            'idx-transporter-companies_id',
            'transporter',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-transporter-companies_id',
            'transporter',
            'companies_id',
            'companies',
            'id',
            'CASCADE'
        );

        // customer_id
        $this->createIndex(
            'idx-transporter-customer_id',
            'transporter',
            'customer_id'
        );
        $this->addForeignKey(
            'fk-transporter-customer_id',
            'transporter',
            'customer_id',
            'listings',
            'id',
            'CASCADE'
        );

        // places_id
        $this->createIndex(
            'idx-transporter_parts-places_id',
            'transporter_parts',
            'places_id'
        );
        $this->addForeignKey(
            'fk-transporter_parts-places_id',
            'transporter_parts',
            'places_id',
            'places',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transporter_contents-transporter_id',
            'transporter_contents',
            'transporter_id'
        );
        $this->addForeignKey(
            'fk-transporter_contents-transporter_id',
            'transporter_contents',
            'transporter_id',
            'transporter',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transporter_contents-transporter_parts_id',
            'transporter_contents',
            'transporter_id'
        );
        $this->addForeignKey(
            'fk-transporter_contents-transporter_parts_id',
            'transporter_contents',
            'transporter_parts_id',
            'transporter_parts',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {


        $this->dropForeignKey('fk-transporter_contents-transporter_id','transporter_contents');
        $this->dropIndex('idx-transporter_contents-transporter_id','transporter_contents');
        $this->dropForeignKey('fk-transporter_contents-transporter_parts_id','transporter_contents');
        $this->dropIndex('idx-transporter_contents-transporter_parts_id','transporter_contents');

        $this->dropForeignKey(
            'fk-transporter_parts-places_id',
            'transporter_parts'
        );
        $this->dropIndex(
            'idx-transporter_parts-places_id',
            'transporter_parts'
        );

        $this->dropForeignKey(
            'fk-transporter-customer_id',
            'transporter'
        );
        $this->dropIndex(
            'idx-transporter-customer_id',
            'transporter'
        );

        $this->dropForeignKey(
            'fk-transporter-companies_id',
            'transporter'
        );
        $this->dropIndex(
            'idx-transporter-companies_id',
            'transporter'
        );

        $this->dropTable('transporter_contents');
        $this->dropTable('transporter_parts');
        $this->dropTable('transporter');
    }



}
