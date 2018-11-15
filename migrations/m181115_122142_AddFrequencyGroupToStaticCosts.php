<?php

use yii\db\Migration;

/**
 * Class m181115_122142_AddFrequencyGroupToStaticCosts
 */
class m181115_122142_AddFrequencyGroupToStaticCosts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('static_costs','frequency_groups_id', $this->integer());
//        $this->addColumn('company_cost_datas','frequency_datas_id', $this->integer()->notNull());
        $this->createIndex(
            'idx-static_costs-frequency_groups_id',
            'static_costs',
            'frequency_groups_id'
        );
        $this->addForeignKey(
            'fk-static_costs-frequency_groups_id',
            'static_costs',
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
            'fk-static_costs-frequency_groups_id',
            'static_costs'
        );

        $this->dropIndex(
            'idx-static_costs-frequency_groups_id',
            'static_costs'
        );

        $this->dropColumn('static_costs','frequency_groups_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_122142_AddFrequencyGroupToStaticCosts cannot be reverted.\n";

        return false;
    }
    */
}
