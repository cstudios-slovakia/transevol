<?php

use yii\db\Migration;

/**
 * Class m181217_075339_add_common_attributes_to_profile
 */
class m181217_075339_add_common_attributes_to_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('profile', 'first_name','string');
        $this->addColumn('profile', 'last_name','string');
        $this->addColumn('profile', 'phone_number','string');
        $this->addColumn('profile', 'company_position','string');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('profile', 'first_name' );
        $this->dropColumn('profile', 'last_name' );
        $this->dropColumn('profile', 'phone_number' );
        $this->dropColumn('profile', 'company_position' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181217_075339_add_common_attributes_to_profile cannot be reverted.\n";

        return false;
    }
    */
}
