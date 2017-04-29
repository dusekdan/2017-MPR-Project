<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRoleTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */

    private $tableName = "roles";
    public function up()
    {
        $roles = $this->table($this->tableName); // id je automaticky generován
        $roles
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('description', 'text',array('null' => true))
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