<?php

use yii\db\Migration;

/**
 * Class m181017_095923_VehicleTypesTable
 */
class m181017_095923_VehicleTypesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vehicle_types', [
            'id'                => $this->primaryKey(),
            'vehicle_type_name' => $this->string(50)->notNull(),
            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vehicle_types');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_095923_VehicleTypesTable cannot be reverted.\n";

        return false;
    }
    */
}
