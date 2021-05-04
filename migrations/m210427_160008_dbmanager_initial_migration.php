<?php

use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m210427_160008_dbmanager_initial_migration
 */
class m210427_160008_dbmanager_initial_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = new dbManager();

        $manage_construction_sites = $auth->createPermission('manage_construction_sites');
        $manage_construction_sites->description = 'Manage construction sites';
        $auth->add($manage_construction_sites);

        $manage_users = $auth->createPermission('manage_users');
        $manage_users->description = 'Manage users';
        $auth->add($manage_users);

        $employee = $auth->createRole('employee');
        $auth->add($employee);

        $manager = $auth->createRole('manager');
        $auth->add($manager);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manage_construction_sites);
        $auth->addChild($admin, $manage_users);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = new dbManager();
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210427_160008_dbmanager_initial_migration cannot be reverted.\n";

        return false;
    }
    */
}
