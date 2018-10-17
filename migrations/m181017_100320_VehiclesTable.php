<?php

use yii\db\Migration;

/**
 * Class m181017_100320_VehiclesTable
 */
class m181017_100320_VehiclesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vehicles', [
            'id'                => $this->primaryKey(),
            'ecv'               => $this->string(100)->notNull(),
            'companies_id'      => $this->integer()->notNull(),
            'vehicle_types_id'  => $this->integer()->notNull(),
            'emission_classes_id'   => $this->integer()->notNull(),
            'weight'            => $this->integer()->unsigned()->notNull(),
            'shaft'             => $this->integer()->unsigned()->notNull(),

            'created_at'        => $this->datetime()->notNull(),
            'updated_at'        => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vehicles');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_100320_VehiclesTable cannot be reverted.\n";

        return false;
    }
    */
}
