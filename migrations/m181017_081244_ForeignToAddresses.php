<?php

use yii\db\Migration;

/**
 * Class m181017_081244_ForeignToAddresses
 */
class m181017_081244_ForeignToAddresses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-addresses-countries_id',
            'addresses',
            'countries_id'
        );
        $this->addForeignKey(
            'fk-addresses-countries_id',
            'addresses',
            'countries_id',
            'countries',
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
            'fk-addresses-countries_id',
            'addresses'
        );

        $this->dropIndex(
            'idx-addresses-countries_id',
            'addresses'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_081244_ForeignToAddresses cannot be reverted.\n";

        return false;
    }
    */
}
