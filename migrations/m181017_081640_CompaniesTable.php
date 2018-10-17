<?php

use yii\db\Migration;

/**
 * Class m181017_081640_CompaniesTable
 */
class m181017_081640_CompaniesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('companies', [
            'id' => $this->primaryKey(),
            'company_name' => $this->string(45)->notNull(),
            'email' => $this->string(100)->notNull(),
            'phone' => $this->string(20)->notNull(),
            'ico' => $this->string(50)->notNull(),
            'dic' => $this->string(50)->notNull(),
            'icdph' => $this->string(50)->notNull(),

            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('companies');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_081640_CompaniesTable cannot be reverted.\n";

        return false;
    }
    */
}
