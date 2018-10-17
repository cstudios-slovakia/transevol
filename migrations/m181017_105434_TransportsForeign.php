<?php

use yii\db\Migration;

/**
 * Class m181017_105434_TransportsForeign
 */
class m181017_105434_TransportsForeign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // companies
        $this->createIndex(
            'idx-transports-companies_id',
            'transports',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-transports-companies_id',
            'transports',
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
            'fk-transports-companies_id',
            'transports'
        );
        $this->dropIndex(
            'idx-transports-companies_id',
            'transports'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_105434_TransportsForeign cannot be reverted.\n";

        return false;
    }
    */
}
