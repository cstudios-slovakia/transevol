<?php

use yii\db\Migration;

/**
 * Class m181017_071956_settings
 */
class m181017_071956_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('units', [
            'id' => $this->primaryKey(),
            'unit_name' => $this->string(50)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        $this->createTable('frequency_groups', [
            'id' => $this->primaryKey(),
            'frequency_group_name' => $this->string(100)->notNull(),
            'sorting_number' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        $this->createTable('frequency_datas', [
            'id' => $this->primaryKey(),
            'frequency_name' => $this->string(100)->notNull(),
            'frequency_value' => $this->string()->notNull(),
            'frequency_groups_id' => $this->integer()->unsigned()->notNull(),
            'persec' => $this->string(100)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        $this->createIndex(
            'idx-frequency_datas-frequency_groups_id',
            'frequency_datas',
            'frequency_groups_id'
        );

        $this->addForeignKey(
            'fk-frequency_datas-frequency_groups_id',
            'frequency_datas',
            'frequency_groups_id',
            'frequency_groups',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-frequency_datas-frequency_groups_id',
            'frequency_datas'
        );
        $this->dropTable('units');
        $this->dropTable('frequency_groups');
        $this->dropTable('frequency_datas');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_071956_settings cannot be reverted.\n";

        return false;
    }
    */
}
