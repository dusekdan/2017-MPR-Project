<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateProjectTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */

    private $tableName = "projects";
    public function up()
    {
        $projects = $this->table($this->tableName); // id je automaticky generován
        $projects

            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('description', 'text')
            ->addColumn('start_date', 'datetime',array('null' => true))
            ->addColumn('end_date', 'datetime',array('null' => true))
            ->addColumn('id_project_manager', 'integer')
            //->addForeignKey('id_project_manager', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
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