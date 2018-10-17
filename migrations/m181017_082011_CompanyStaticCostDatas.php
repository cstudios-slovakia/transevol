<?php

use yii\db\Migration;

/**
 * Class m181017_082011_CompanyStaticCostDatas
 */
class m181017_082011_CompanyStaticCostDatas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('company_cost_datas', [
            'id' => $this->primaryKey(),
            'value' => $this->decimal(10,6)->notNull(),
            'static_costs_id' => $this->integer()->notNull(),
            'companies_id' => $this->integer()->notNull(),

            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('company_cost_datas');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_082011_CompanyStaticCostDatas cannot be reverted.\n";

        return false;
    }
    */
}
