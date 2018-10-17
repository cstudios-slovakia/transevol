<?php

use yii\db\Migration;

/**
 * Class m181017_071124_place_types
 */
class m181017_071124_place_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('place_types', [
            'id' => $this->primaryKey(),
            'placetype_name' => $this->string()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('place_types');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_071124_place_types cannot be reverted.\n";

        return false;
    }
    */
}
