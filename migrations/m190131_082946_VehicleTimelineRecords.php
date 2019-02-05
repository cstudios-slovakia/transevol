<?php

use yii\db\Migration;

/**
 * Class m190131_082946_VehicleTimelineRecords
 */
class m190131_082946_VehicleTimelineRecords extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('timeline_vehicle', [
            'id'                    => $this->primaryKey(),
            'vehicle_record_from'    => $this->dateTime()->notNull(),
            'vehicle_record_until'   => $this->dateTime()->null(),
            'companies_id'          => $this->integer()->notNull(),
            'vehicle_id'           => $this->integer()->notNull(),
            'created_at'            => $this->datetime()->notNull(),
            'updated_at'            => $this->datetime(),
        ]);

        // companies
        $this->createIndex(
            'idx-timeline_vehicle-companies_id',
            'timeline_vehicle',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-timeline_vehicle-companies_id',
            'timeline_vehicle',
            'companies_id',
            'companies',
            'id',
            'CASCADE'
        );

            // vehicle_id
            // vehicle_id
        $this->createIndex(
            'idx-timeline_vehicle-vehicle_id',
            'timeline_vehicle',
            'vehicle_id'
        );
        $this->addForeignKey(
            'fk-timeline_vehicle-vehicle_id',
            'timeline_vehicle',
            'vehicle_id',
            'vehicles',
            'id',
            'CASCADE'
        );

        $this->createTable('timeline_vehicle__vehicle', [
            'timeline_vehicle_id'            => $this->integer()->notNull(),
            'vehicle_id'      => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
        ]);

        $this->createIndex(
            'idx-timeline_vehicle__vehicle-timeline_vehicle_id',
            'timeline_vehicle__vehicle',
            'timeline_vehicle_id'
        );
        $this->addForeignKey(
            'fk-timeline_vehicle__vehicle-timeline_vehicle_id',
            'timeline_vehicle__vehicle',
            'timeline_vehicle_id',
            'timeline_vehicle',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-timeline_vehicle__vehicle-vehicle_id',
            'timeline_vehicle__vehicle',
            'vehicle_id'
        );
        $this->addForeignKey(
            'fk-timeline_vehicle__vehicle-vehicle_id',
            'timeline_vehicle__vehicle',
            'vehicle_id',
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

        $this->dropForeignKey('fk-timeline_vehicle__vehicle-timeline_vehicle_id','timeline_vehicle__vehicle');
        $this->dropIndex('idx-timeline_vehicle__vehicle-timeline_vehicle_id','timeline_vehicle__vehicle');
        $this->dropForeignKey('fk-timeline_vehicle__vehicle-vehicle_id','timeline_vehicle__vehicle');
        $this->dropIndex('idx-timeline_vehicle__vehicle-vehicle_id','timeline_vehicle__vehicle');


        $this->dropTable('timeline_vehicle__vehicle');

        $this->dropForeignKey('fk-timeline_vehicle-companies_id','timeline_vehicle');
        $this->dropIndex('idx-timeline_vehicle-companies_id','timeline_vehicle');


        $this->dropForeignKey('fk-timeline_vehicle-vehicle_id','timeline_vehicle');
        $this->dropIndex('idx-timeline_vehicle-vehicle_id','timeline_vehicle');

        $this->dropTable('timeline_vehicle');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190131_082946_VehicleTimelineRecords cannot be reverted.\n";

        return false;
    }
    */
}
