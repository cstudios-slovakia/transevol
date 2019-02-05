<?php

use yii\db\Migration;

/**
 * Class m190129_143547_VehicleWithDriver
 */
class m190129_143547_VehicleWithDriver extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('timeline_driver__vehicle', [
            'timeline_driver_id'            => $this->integer()->notNull(),
            'vehicle_id'      => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
        ]);

        $this->createIndex(
            'idx-timeline_driver__vehicle-timeline_driver_id',
            'timeline_driver__vehicle',
            'timeline_driver_id'
        );
        $this->addForeignKey(
            'fk-timeline_driver__vehicle-timeline_driver_id',
            'timeline_driver__vehicle',
            'timeline_driver_id',
            'timeline_driver',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-timeline_driver__vehicle-vehicle_id',
            'timeline_driver__vehicle',
            'vehicle_id'
        );
        $this->addForeignKey(
            'fk-timeline_driver__vehicle-vehicle_id',
            'timeline_driver__vehicle',
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
        $this->dropForeignKey('fk-timeline_driver__vehicle-timeline_driver_id','timeline_driver__vehicle');
        $this->dropIndex('idx-timeline_driver__vehicle-timeline_driver_id','timeline_driver__vehicle');
        $this->dropForeignKey('fk-timeline_driver__vehicle-vehicle_id','timeline_driver__vehicle');
        $this->dropIndex('idx-timeline_driver__vehicle-vehicle_id','timeline_driver__vehicle');


        $this->dropTable('timeline_driver__vehicle');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190129_143547_VehicleWithDriver cannot be reverted.\n";

        return false;
    }
    */
}
