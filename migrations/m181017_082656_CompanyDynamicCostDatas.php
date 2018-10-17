<?php

use yii\db\Migration;

/**
 * Class m181017_082656_CompanyDynamicCostDatas
 */
class m181017_082656_CompanyDynamicCostDatas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('company_dynamic_costs', [
            'id' => $this->primaryKey(),
            'value' => $this->decimal(10,6)->notNull(),
            'cost_type' => $this->string(5)->notNull(),
            'companies_id' => $this->integer()->notNull(),
            'frequency_datas_id' => $this->integer(5)->notNull(),
            'units_id' => $this->integer(5)->notNull(),

            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('company_dynamic_costs');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_082656_CompanyDynamicCostDatas cannot be reverted.\n";

        return false;
    }
    */
}
