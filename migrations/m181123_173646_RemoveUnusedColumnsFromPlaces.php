<?php

use yii\db\Migration;

/**
 * Class m181123_173646_RemoveUnusedColumnsFromPlaces
 */
class m181123_173646_RemoveUnusedColumnsFromPlaces extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('places','email');
        $this->dropColumn('places','phone');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('places','email',$this->string()->notNull());
        $this->addColumn('places','phone',$this->string(20)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_173646_RemoveUnusedColumnsFromPlaces cannot be reverted.\n";

        return false;
    }
    */
}
