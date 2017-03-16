<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Karel Píč
 * Date: 22.02.2017
 * Time: 9:40
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateUserTable extends AbstractMigration
{
	private $tableName = "users";
	/**
	 * Migrate Up.
	 */
	public function up()
	{
		$users = $this->table($this->tableName); // id je automaticky generován
		$users->addColumn('username', 'string', array('limit' => 30))
			->addColumn('password', 'string')
			->addColumn('email', 'string', array('limit' => 100))
			->addColumn('first_name', 'string', array('limit' => 30))
			->addColumn('last_name', 'string', array('limit' => 30))
			->addColumn('birthday', 'date', array('null' => true))
			->addColumn('phone', 'string', array('limit' => 13, 'null' => true)) //+420 123 456 789
			->addColumn('role', 'string', array('limit' =>30))
			->addColumn('created', 'datetime')
			->addColumn('last_sign', 'datetime', array('null' => true))
			->addColumn('has_photo', 'boolean', array('default' => false))
			/* Pokud to chci řešit na straně databáze
			->addColumn('created_at', 'timestamp', array('default' => '0000-00-00 00:00:00', 'update' => ''))
			->addColumn('updated_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'))
			*/
			->addIndex(array('email'), array('unique' => true, 'name' => 'UNIQ_C3176774E7927C74'))
			->addIndex(array('username'), array('unique' => true, 'name' => 'UNIQ_C3176774F85E0677'))
			->save();

			//heslo je 123456
		$rows = [
			[
				'email'    => "superAdmin@admin.cz",
				'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
				'username' => "superAdmin",
				'first_name' => "Jméno",
				'last_name' => "Příjmení",
				'birthday' => "2000-01-01",
				'phone' => "+420123456789",
				'role' => "superAdmin",
				'created' => date("Y-m-d H:i:s"),
			],
			[
				'email'    => "admin@admin.cz",
				'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
				'username' => "admin",
				'first_name' => "Jméno",
				'last_name' => "Příjmení",
				'birthday' => "2000-01-01",
				'phone' => "+420123456789",
				'role' => "admin",
				'created' => date("Y-m-d H:i:s"),
			],
			[
				'email'    => "guest@guest.cz",
				'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
				'username' => "guest",
				'first_name' => "Jméno",
				'last_name' => "Příjmení",
				'birthday' => "2000-01-01",
				'phone' => "+420123456789",
				'role' => "guest",
				'created' => date("Y-m-d H:i:s"),
			]
		];
		$this->insert($this->tableName, $rows);
	}

	/**
	 * Migrate Down.
	 */
	public function down()
	{
		$this->dropTable($this->tableName);
	}
}