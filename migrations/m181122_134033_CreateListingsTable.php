<?php

use yii\db\Migration;

/**
 * Class m181122_134033_CreateListingsTable
 */
class m181122_134033_CreateListingsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('listings', [
            'id' => $this->primaryKey(),
            'place_name' => $this->string()->notNull(),
            'companies_id' => $this->integer()->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(20),
            'countries_id' => $this->integer()->notNull(),
            'addresses_id' => $this->integer()->notNull(),
            'place_types_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        // companies
        $this->createIndex(
            'idx-listings-companies_id',
            'listings',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-listings-companies_id',
            'listings',
            'companies_id',
            'companies',
            'id',
            'CASCADE'
        );

        // countries
        $this->createIndex(
            'idx-listings-countries_id',
            'listings',
            'countries_id'
        );
        $this->addForeignKey(
            'fk-listings-countries_id',
            'listings',
            'countries_id',
            'countries',
            'id',
            'CASCADE'
        );

        // addresses
        $this->createIndex(
            'idx-listings-addresses_id',
            'listings',
            'addresses_id'
        );
        $this->addForeignKey(
            'fk-listings-addresses_id',
            'listings',
            'addresses_id',
            'addresses',
            'id',
            'CASCADE'
        );

        // place_types
        $this->createIndex(
            'idx-listings-place_types_id',
            'listings',
            'place_types_id'
        );
        $this->addForeignKey(
            'fk-listings-place_types_id',
            'listings',
            'place_types_id',
            'place_types',
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
            'fk-listings-companies_id',
            'listings'
        );
        $this->dropIndex(
            'idx-listings-companies_id',
            'listings'
        );


        $this->dropForeignKey(
            'fk-listings-countries_id',
            'listings'
        );
        $this->dropIndex(
            'idx-listings-countries_id',
            'listings'
        );

        $this->dropForeignKey(
            'fk-listings-addresses_id',
            'listings'
        );
        $this->dropIndex(
            'idx-listings-addresses_id',
            'listings'
        );



        $this->dropForeignKey(
            'fk-listings-place_types_id',
            'listings'
        );
        $this->dropIndex(
            'idx-listings-place_types_id',
            'listings'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181122_134033_CreateListingsTable cannot be reverted.\n";

        return false;
    }
    */
}
