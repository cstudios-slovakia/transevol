<?php

use yii\db\Migration;

/**
 * Class m181023_111223_AddPlaceTypeSection
 */
class m181023_111223_AddPlaceTypeSection extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('place_types','place_section', $this->string('20')->after('placetype_name')->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('place_types','place_section');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181023_111223_AddPlaceTypeSection cannot be reverted.\n";

        return false;
    }
    */
}
