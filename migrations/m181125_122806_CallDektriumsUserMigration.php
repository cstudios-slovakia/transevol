<?php

use yii\db\Migration;

/**
 * Class m181227_122806_CallDektriumsUserMigration
 */
class m181125_122806_CallDektriumsUserMigration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->runAction('migrate/up',['migrationPath'=>'@vendor/dektrium/yii2-user/migrations','interactive'=> 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181227_122806_CallDektriumsUserMigration cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181227_122806_CallDektriumsUserMigration cannot be reverted.\n";

        return false;
    }
    */
}
