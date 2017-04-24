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
            /* Pokud to chci řešit na straně databáze
          ->addColumn('created_at', 'timestamp', array('default' => '0000-00-00 00:00:00', 'update' => ''))
          ->addColumn('updated_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'))
          */
//            ->addIndex(array('email'), array('unique' => true, 'name' => 'UNIQ_C3176774E7927C74'))
//            ->addIndex(array('username'), array('unique' => true, 'name' => 'UNIQ_C3176774F85E0677'))

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