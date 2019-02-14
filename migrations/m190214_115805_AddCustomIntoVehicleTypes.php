<?php

use yii\db\Migration;

/**
 * Class m190214_115805_AddCustomIntoVehicleTypes
 */
class m190214_115805_AddCustomIntoVehicleTypes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vehicle_types', 'type_shortly','string');

        $vehicleTypes   = \app\models\VehicleTypes::find()->all();
        foreach ($vehicleTypes as $vehicleType){
            $vehicleType->type_shortly = str_slug($vehicleType->vehicle_type_name);
            $vehicleType->save(false);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vehicle_types', 'type_shortly' );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190214_115805_AddCustomIntoVehicleTypes cannot be reverted.\n";

        return false;
    }
    */
}
