<?php

use yii\db\Migration;

/**
 * Class m181017_082204_CompanyStaticCostDatasForeigns
 */
class m181017_082204_CompanyStaticCostDatasForeigns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-company_cost_datas-static_costs_id',
            'company_cost_datas',
            'static_costs_id'
        );
        $this->addForeignKey(
            'fk-company_cost_datas-static_costs_id',
            'company_cost_datas',
            'static_costs_id',
            'static_costs',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-company_cost_datas-companies_id',
            'company_cost_datas',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-company_cost_datas-companies_id',
            'company_cost_datas',
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

        $this->dropForeignKey(
            'fk-company_cost_datas-static_costs_id',
            'company_cost_datas'
        );

        $this->dropForeignKey(
            'fk-company_cost_datas-companies_id',
            'company_cost_datas'
        );


        $this->dropIndex(
            'idx-company_cost_datas-static_costs_id',
            'company_cost_datas'
        );
        $this->dropIndex(
            'idx-company_cost_datas-companies_id',
            'company_cost_datas'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_082204_CompanyStaticCostDatasForeigns cannot be reverted.\n";

        return false;
    }
    */
}
