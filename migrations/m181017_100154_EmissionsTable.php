<?php

use yii\db\Migration;

/**
 * Class m181017_100154_EmissionsTable
 */
class m181017_100154_EmissionsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('emission_classes', [
            'id'                => $this->primaryKey(),
            'emission_name' => $this->string(50)->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('emission_classes');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_100154_EmissionsTable cannot be reverted.\n";

        return false;
    }
    */
}
