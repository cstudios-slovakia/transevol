<?php

use yii\db\Migration;

/**
 * Class m181017_095017_DriversTable
 */
class m181017_095017_DriversTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('drivers', [
            'id' => $this->primaryKey(),
            'driver_name' => $this->string(100)->notNull(),
            'companies_id' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string(20)->notNull(),

            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('drivers');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_095017_DriversTable cannot be reverted.\n";

        return false;
    }
    */
}
