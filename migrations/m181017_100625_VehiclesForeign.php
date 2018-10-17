<?php

use yii\db\Migration;

/**
 * Class m181017_100625_VehiclesForeign
 */
class m181017_100625_VehiclesForeign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // companies
        $this->createIndex(
            'idx-vehicles-companies_id',
            'vehicles',
            'companies_id'
        );
        $this->addForeignKey(
            'fk-vehicles-companies_id',
            'vehicles',
            'companies_id',
            'companies',
            'id',
            'CASCADE'
        );

        // vehicle_types
        $this->createIndex(
            'idx-vehicles-vehicle_types_id',
            'vehicles',
            'vehicle_types_id'
        );
        $this->addForeignKey(
            'fk-vehicles-vehicle_types_id',
            'vehicles',
            'vehicle_types_id',
            'vehicle_types',
            'id',
            'CASCADE'
        );

        // emission classes
        $this->createIndex(
            'idx-vehicles-emission_classes_id',
            'vehicles',
            'emission_classes_id'
        );
        $this->addForeignKey(
            'fk-vehicles-emission_classes_id',
            'vehicles',
            'emission_classes_id',
            'emission_classes',
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
            'fk-vehicles-companies_id',
            'vehicles'
        );
        $this->dropIndex(
            'idx-vehicles-companies_id',
            'vehicles'
        );


        $this->dropForeignKey(
            'fk-vehicles-vehicle_types_id',
            'vehicles'
        );
        $this->dropIndex(
            'idx-vehicles-vehicle_types_id',
            'vehicles'
        );


        $this->dropForeignKey(
            'fk-vehicles-emission_classes_id',
            'vehicles'
        );
        $this->dropIndex(
        'idx-vehicles-emission_classes_id',
        'vehicles'
    );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_100625_VehiclesForeign cannot be reverted.\n";

        return false;
    }
    */
}
