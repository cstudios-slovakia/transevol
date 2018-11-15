<?php

use yii\db\Migration;

/**
 * Class m181115_090654_RemoveFrequencyFromStaticCosts
 */
class m181115_090654_RemoveFrequencyFromStaticCosts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-static_costs-frequency_datas_id',
            'static_costs'
        );

        $this->dropIndex(
            'idx-static_costs-frequency_datas_id',
            'static_costs'
        );

        $this->dropColumn('static_costs','frequency_datas_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('static_costs','frequency_datas_id', $this->integer()->notNull());


        $this->createIndex(
            'idx-static_costs-frequency_datas_id',
            'static_costs',
            'frequency_datas_id'
        );
        $this->addForeignKey(
            'fk-static_costs-frequency_datas_id',
            'static_costs',
            'frequency_datas_id',
            'frequency_datas',
            'id',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_090654_RemoveFrequencyFromStaticCosts cannot be reverted.\n";

        return false;
    }
    */
}
