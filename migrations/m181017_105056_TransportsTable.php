<?php

use yii\db\Migration;

/**
 * Class m181017_105056_TransportsTable
 */
class m181017_105056_TransportsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transports', [
            'id'                => $this->primaryKey(),
            'transport_price' => $this->decimal(10,6)->notNull(),
            'transport_additional_cost' => $this->decimal(10,6)->notNull(),
            'opened_date_from' => $this->date()->notNull(),
            'opened_date_until' => $this->date()->notNull(),
            'opened_time_from' => $this->time()->notNull(),
            'opened_time_until' => $this->time()->notNull(),
            'companies_id' => $this->integer()->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transports');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_105056_TransportsTable cannot be reverted.\n";

        return false;
    }
    */
}
