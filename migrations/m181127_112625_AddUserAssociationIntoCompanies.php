<?php

use yii\db\Migration;

/**
 * Class m181127_112625_AddUserAssociationIntoCompanies
 */
class m181127_112625_AddUserAssociationIntoCompanies extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','companies_id', $this->integer());
        $this->createIndex(
            'idx-user-companies_id',
            'user',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-user-companies_id',
            'user',
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
            'fk-user-companies_id',
            'user'
        );
        $this->dropIndex(
            'idx-user-companies_id',
            'user'
        );

        $this->dropColumn('user','companies_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181127_112625_AddUserAssociationIntoCompanies cannot be reverted.\n";

        return false;
    }
    */
}
