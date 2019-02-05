<?php

use yii\db\Migration;

/**
 * Class m190129_092440_GoingsWithVehicle
 */
class m190129_092440_GoingsWithVehicle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('going__vehicle', [
            'going_id'            => $this->integer()->notNull(),
            'vehicle_id'      => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
        ]);

        $this->createIndex(
            'idx-going__vehicle-going_id',
            'going__vehicle',
            'going_id'
        );
        $this->addForeignKey(
            'fk-going__vehicle-going_id',
            'going__vehicle',
            'going_id',
            'goings',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-going__vehicle-vehicle_id',
            'going__vehicle',
            'vehicle_id'
        );
        $this->addForeignKey(
            'fk-going__vehicle-vehicle_id',
            'going__vehicle',
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
        $this->dropForeignKey('fk-going__vehicle-going_id','going__vehicle');
        $this->dropIndex('idx-going__vehicle-going_id','going__vehicle');
        $this->dropForeignKey('fk-going__vehicle-vehicle_id','going__vehicle');
        $this->dropIndex('idx-going__vehicle-vehicle_id','going__vehicle');


        $this->dropTable('going__vehicle');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190129_092440_GoingsWithVehicle cannot be reverted.\n";

        return false;
    }
    */
}
