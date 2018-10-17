<?php

use yii\db\Migration;

/**
 * Class m181017_113446_TransportDriverPropertiesTable
 */
class m181017_113446_TransportDriverPropertiesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transport_driver_properties', [
            'id'                => $this->primaryKey(),
            'transport__driver_id'     => $this->integer()->notNull(),
            'work_date_from'    => $this->date()->notNull(),
            'work_date_until'   => $this->date()->notNull(),
            'work_time_from'    => $this->time()->notNull(),
            'work_time_until'   => $this->time()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);

        $this->createIndex(
            'idx-transport_driver_properties-transport__driver_id',
            'transport_driver_properties',
            'transport__driver_id'
        );
        $this->addForeignKey(
            'fk-transport_driver_properties-transport__driver_id',
            'transport_driver_properties',
            'transport__driver_id',
            'transport__driver',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk-transport_driver_properties-transport__driver_id','transport_driver_properties');
        $this->dropIndex('idx-transport_driver_properties-transport__driver_id','transport_driver_properties');

        $this->dropTable('transport_driver_properties');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_113446_TransportDriverPropertiesTable cannot be reverted.\n";

        return false;
    }
    */
}
