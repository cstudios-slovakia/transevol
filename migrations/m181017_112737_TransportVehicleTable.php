<?php

use yii\db\Migration;

/**
 * Class m181017_112737_TransportVehicleTable
 */
class m181017_112737_TransportVehicleTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transport__vehicle', [
            'id'                => $this->primaryKey(),
            'transports_id'     => $this->integer()->notNull(),
            'vehicles_id'       => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);

        $this->createIndex(
            'idx-transport__vehicle-transports_id',
            'transport__vehicle',
            'transports_id'
        );
        $this->addForeignKey(
            'fk-transport__vehicle-transports_id',
            'transport__vehicle',
            'transports_id',
            'transports',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transport__vehicle-vehicles_id',
            'transport__vehicle',
            'vehicles_id'
        );
        $this->addForeignKey(
            'fk-transport__vehicle-vehicles_id',
            'transport__vehicle',
            'vehicles_id',
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
        $this->dropForeignKey('fk-transport__vehicle-transports_id','transport__vehicle');
        $this->dropForeignKey('fk-transport__vehicle-vehicles_id','transport__vehicle');
        $this->dropIndex('idx-transport__vehicle-transports_id','transport__vehicle');
        $this->dropIndex('idx-transport__vehicle-vehicles_id','transport__vehicle');

        $this->dropTable('transport__vehicle');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_112737_TransportVehicleTable cannot be reverted.\n";

        return false;
    }
    */
}
