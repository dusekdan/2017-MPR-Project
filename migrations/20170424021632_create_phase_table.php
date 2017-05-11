<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreatePhaseTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */

    private $tableName = "phases";
	public function up()
    {
        $phases = $this->table($this->tableName); // id je automaticky generován
        $phases
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('description', 'text')
            ->addColumn('start_date', 'datetime',array('null' => true))
            ->addColumn('end_date', 'datetime',array('null' => true))
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