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

            ->addColumn('id_user', 'integer')
            //->addForeignKey('id_user', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
            ->addColumn('id_client', 'integer')
            //->addForeignKey('id_client', 'clients', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
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