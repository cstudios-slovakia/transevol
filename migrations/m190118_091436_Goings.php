<?php

use yii\db\Migration;

/**
 * Class m190118_091436_Goings
 */
class m190118_091436_Goings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goings', [
            'id' => $this->primaryKey(),
            'going_from' => $this->dateTime()->notNull(),
            'going_until' => $this->dateTime()->notNull(),
            'companies_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        // companies
        $this->createIndex(
            'idx-goings-companies_id',
            'goings',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-goings-companies_id',
            'goings',
            'companies_id',
            'companies',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goings');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190118_091436_Goings cannot be reverted.\n";

        return false;
    }
    */
}
