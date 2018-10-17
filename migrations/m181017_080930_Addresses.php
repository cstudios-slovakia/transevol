<?php

use yii\db\Migration;

/**
 * Class m181017_080930_Addresses
 */
class m181017_080930_Addresses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

         $this->createTable('addresses', [
             'id' => $this->primaryKey(),
             'city' => $this->string(100)->notNull(),
             'street' => $this->string()->notNull(),
             'zip' => $this->string(50)->notNull(),
             'countries_id' => $this->integer()->notNull(),
             'created_at' => $this->datetime()->notNull(),
             'updated_at' => $this->datetime(),
         ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('addresses');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_080930_Addresses cannot be reverted.\n";

        return false;
    }
    */
}
