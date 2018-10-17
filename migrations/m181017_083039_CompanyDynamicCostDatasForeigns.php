<?php

use yii\db\Migration;

/**
 * Class m181017_083039_CompanyDynamicCostDatasForeigns
 */
class m181017_083039_CompanyDynamicCostDatasForeigns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-company_dynamic_costs-frequency_datas_id',
            'company_dynamic_costs',
            'frequency_datas_id'
        );
        $this->addForeignKey(
            'fk-company_dynamic_costs-frequency_datas_id',
            'company_dynamic_costs',
            'frequency_datas_id',
            'frequency_datas',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-company_dynamic_costs-companies_id',
            'company_dynamic_costs',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-company_dynamic_costs-companies_id',
            'company_dynamic_costs',
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
            'fk-company_dynamic_costs-companies_id',
            'company_dynamic_costs'
        );
        $this->dropIndex(
            'idx-company_dynamic_costs-companies_id',
            'company_dynamic_costs'
        );


        $this->dropForeignKey(
            'fk-company_dynamic_costs-frequency_datas_id',
            'company_dynamic_costs'
        );
        $this->dropIndex(
            'idx-company_dynamic_costs-frequency_datas_id',
            'company_dynamic_costs'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_083039_CompanyDynamicCostDatasForeigns cannot be reverted.\n";

        return false;
    }
    */
}
