<?php

use yii\db\Migration;

/**
 * Class m181109_132535_AddCostNameToDynamicCosts
 */
class m181109_132535_AddCostNameToDynamicCosts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company_dynamic_costs','cost_name', $this->string('100')->after('id')->notNull());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company_dynamic_costs','cost_name');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181109_132535_AddCostNameToDynamicCosts cannot be reverted.\n";

        return false;
    }
    */
}
