<?php

use yii\db\Migration;

/**
 * Class m181017_112251_TransportPlacesForeign
 */
class m181017_112251_TransportPlacesForeign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-transport__place-transports_id',
            'transport__place',
            'transports_id'
        );
        $this->addForeignKey(
            'fk-transport__place-transports_id',
            'transport__place',
            'transports_id',
            'transports',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transport__place-places_id',
            'transport__place',
            'places_id'
        );
        $this->addForeignKey(
            'fk-transport__place-places_id',
            'transport__place',
            'places_id',
            'places',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-transport__place-transports_id','transport__place');
        $this->dropIndex('idx-transport__place-transports_id','transport__place');
        $this->dropForeignKey('fk-transport__place-places_id','transport__place');
        $this->dropIndex('idx-transport__place-places_id','transport__place');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181017_112251_TransportPlacesForeign cannot be reverted.\n";

        return false;
    }
    */
}
