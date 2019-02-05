<?php

use yii\db\Migration;

/**
 * Class m190129_135449_DriverTimelineRecord
 */
class m190129_135449_DriverTimelineRecord extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('timeline_driver', [
            'id'                    => $this->primaryKey(),
            'driver_record_from'    => $this->dateTime()->notNull(),
            'driver_record_until'   => $this->dateTime()->notNull(),
            'companies_id'          => $this->integer()->notNull(),
            'drivers_id'           => $this->integer()->notNull(),
            'created_at'            => $this->datetime()->notNull(),
            'updated_at'            => $this->datetime(),
        ]);

        // companies
        $this->createIndex(
            'idx-timeline_driver-companies_id',
            'timeline_driver',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-timeline_driver-companies_id',
            'timeline_driver',
            'companies_id',
            'companies',
            'id',
            'CASCADE'
        );

// companies
        $this->createIndex(
            'idx-timeline_driver-drivers_id',
            'timeline_driver',
            'drivers_id'
        );
        $this->addForeignKey(
            'fk-timeline_driver-drivers_id',
            'timeline_driver',
            'drivers_id',
            'drivers',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-timeline_driver-companies_id','timeline_driver');
        $this->dropIndex('idx-timeline_driver-companies_id','timeline_driver');


        $this->dropForeignKey('fk-timeline_driver-drivers_id','timeline_driver');
        $this->dropIndex('idx-timeline_driver-drivers_id','timeline_driver');

        $this->dropTable('timeline_driver');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190129_135449_DriverTimelineRecord cannot be reverted.\n";

        return false;
    }
    */
}
