<?php

use yii\db\Migration;

/**
 * Class m181017_095307_DriversForeigns
 */
class m181017_095307_DriversForeigns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // companies
        $this->createIndex(
            'idx-drivers-companies_id',
            'drivers',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-drivers-companies_id',
            'drivers',
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
            'fk-drivers-companies_id',
            'driver_cost_datas'
        );
        $this->dropIndex(
            'idx-drivers-companies_id',
            'driver_cost_datas'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_095307_DriversForeigns cannot be reverted.\n";

        return false;
    }
    */
}
