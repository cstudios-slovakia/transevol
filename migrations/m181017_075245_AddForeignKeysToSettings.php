<?php

use yii\db\Migration;

/**
 * Class m181017_075245_AddForeignKeysToSettings
 */
class m181017_075245_AddForeignKeysToSettings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-frequency_datas-frequency_groups_id',
            'frequency_datas',
            'frequency_groups_id'
        );
        $this->addForeignKey(
            'fk-frequency_datas-frequency_groups_id',
            'frequency_datas',
            'frequency_groups_id',
            'frequency_groups',
            'id',
            'CASCADE'
        );


        $this->createIndex(
            'idx-static_costs-frequency_datas_id',
            'static_costs',
            'frequency_datas_id'
        );
        $this->addForeignKey(
            'fk-static_costs-frequency_datas_id',
            'static_costs',
            'frequency_datas_id',
            'frequency_datas',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-static_costs-units_id',
            'static_costs',
            'units_id'
        );
        $this->addForeignKey(
            'fk-static_costs-units_id',
            'static_costs',
            'units_id',
            'units',
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
            'fk-frequency_datas-frequency_groups_id',
            'frequency_datas'
        );

        $this->dropForeignKey(
            'fk-static_costs-frequency_datas_id',
            'static_costs'
        );

        $this->dropIndex(
            'idx-frequency_datas-frequency_groups_id',
            'frequency_datas'
        );

        $this->dropIndex(
            'idx-static_costs-frequency_datas_id',
            'static_costs'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_075245_AddForeignKeysToSettings cannot be reverted.\n";

        return false;
    }
    */
}
