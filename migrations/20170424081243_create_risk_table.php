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
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime')
            ->addColumn('enabled', 'boolean', array('default' => true))
            ->addColumn('probability', 'float',array('null' => true))
            ->addColumn('money', 'integer',array('null' => true))
            ->addColumn('time', 'integer',array('null' => true))
            ->addColumn('result', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('primary_cause', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('trigger', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('reaction', 'string',array('null' => true, 'limit' => 100))
            ->addColumn('severity', 'float',array('null' => true))
            ->addColumn('id_risk_type', 'integer')
            ->addForeignKey('id_risk_type', 'risk_types', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
            ->addColumn('id_phase', 'integer')
            ->addForeignKey('id_phase', 'phases', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
            ->addColumn('id_resposibleFor', 'integer')
            ->addForeignKey('id_resposibleFor', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
            ->addColumn('id_creator', 'integer')
            ->addForeignKey('id_creator', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))

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