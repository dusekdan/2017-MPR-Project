<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRiskTable extends AbstractMigration
{
	/**
	 * Migrate Up.
	 */

    private $tableName = "risks";
	public function up()
	{
        $risks = $this->table($this->tableName); // id je automaticky generován
        $risks
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('description', 'text')
            ->addColumn('probability', 'float',array('null' => true))
            ->addColumn('money', 'integer',array('null' => true))
            ->addColumn('time', 'integer',array('null' => true))
            ->addColumn('result', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('primary_cause', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('trigger', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('reaction', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('severity', 'float',array('null' => true))
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