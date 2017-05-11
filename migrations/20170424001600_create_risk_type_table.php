<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRiskTypeTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */

    private $tableName = "risk_types";
    public function up()
    {
        $risk_types = $this->table($this->tableName); // id je automaticky generován
        $risk_types
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('description', 'text')
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