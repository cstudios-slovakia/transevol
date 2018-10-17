<?php

use yii\db\Migration;

/**
 * Class m181017_112000_TransportPlacesTable
 */
class m181017_112000_TransportPlacesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transport__place', [
            'id'                => $this->primaryKey(),

            'place_date'        => $this->date()->notNull(),
            'place_time'        => $this->time()->notNull(),
            'transports_id'     => $this->integer()->notNull(),
            'places_id'         => $this->integer()->notNull(),
            'load_meter'        => $this->decimal(10,6)->notNull(),
            'load_weight'       => $this->decimal(10,6)->notNull(),
            'additional_cost'   => $this->decimal(10,6)->notNull(),

            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transport__place');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_112000_TransportPlacesTable cannot be reverted.\n";

        return false;
    }
    */
}
