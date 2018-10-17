<?php

use yii\db\Migration;

/**
 * Class m181017_094043_PlacesTable
 */
class m181017_094043_PlacesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('places', [
            'id' => $this->primaryKey(),
            'place_name' => $this->string()->notNull(),
            'position' => $this->string()->notNull(),
            'companies_id' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'countries_id' => $this->integer()->notNull(),
            'addresses_id' => $this->integer()->notNull(),
            'place_types_id' => $this->integer()->notNull(),

            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('places');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_094043_PlacesTable cannot be reverted.\n";

        return false;
    }
    */
}
