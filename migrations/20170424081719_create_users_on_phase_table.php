<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateUsersOnPhaseTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */

    private $tableName = "users_on_phases";
    public function up()
    {
        $users_on_phases = $this->table($this->tableName); // id je automaticky generován
        $users_on_phases
            ->addColumn('user_id', 'integer')
            ->addColumn('phase_id', 'integer')
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime')
            ->addColumn('enabled', 'boolean', array('default' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}