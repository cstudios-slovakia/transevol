<?php

use yii\db\Migration;

/**
 * Class m181017_094511_PlacesForeigns
 */
class m181017_094511_PlacesForeigns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // companies
        $this->createIndex(
            'idx-places-companies_id',
            'places',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-places-companies_id',
            'places',
            'companies_id',
            'companies',
            'id',
            'CASCADE'
        );

        // countries
        $this->createIndex(
            'idx-places-countries_id',
            'places',
            'countries_id'
        );
        $this->addForeignKey(
            'fk-places-countries_id',
            'places',
            'countries_id',
            'countries',
            'id',
            'CASCADE'
        );

        // addresses
        $this->createIndex(
            'idx-places-addresses_id',
            'places',
            'addresses_id'
        );
        $this->addForeignKey(
            'fk-places-addresses_id',
            'places',
            'addresses_id',
            'addresses',
            'id',
            'CASCADE'
        );

        // place_types
        $this->createIndex(
            'idx-places-place_types_id',
            'places',
            'place_types_id'
        );
        $this->addForeignKey(
            'fk-places-place_types_id',
            'places',
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
            'fk-places-companies_id',
            'places'
        );
        $this->dropIndex(
            'idx-places-companies_id',
            'places'
        );


        $this->dropForeignKey(
            'fk-places-countries_id',
            'places'
        );
        $this->dropIndex(
            'idx-places-countries_id',
            'places'
        );

        $this->dropForeignKey(
            'fk-places-addresses_id',
            'places'
        );
        $this->dropIndex(
            'idx-places-addresses_id',
            'places'
        );



        $this->dropForeignKey(
            'fk-places-place_types_id',
            'places'
        );
        $this->dropIndex(
            'idx-places-place_types_id',
            'places'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_094511_PlacesForeigns cannot be reverted.\n";

        return false;
    }
    */
}
