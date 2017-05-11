<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddForeignKey extends AbstractMigration
{
    private $tableUser = "users";
    private $tableRisk = "risks";
    private $tableClient = "clients";
    private $tablePhase = "phases";
    private $tableProject = "projects";
    private $tableRiskT = "risk_types";
    private $tableUtoPhase = "users_on_phases";
    private $tableRole = "roles";
    private $tableUtoProject = "users_on_projects";


	/**
	 * Migrate Up.
	 */
	public function up()
	{
		$projects = $this->table($this->tableProject); // id je automaticky generován
		$projects
			->addColumn('project_manager_id', 'integer')
			//->addForeignKey('id_project_manager', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('client_id', 'integer')
			//->addForeignKey('id_client', 'clients', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->save();

		$this->execute("ALTER TABLE $this->tableProject ADD FOREIGN KEY (project_manager_id) REFERENCES $this->tableUser(id) ON DELETE CASCADE");
		$this->execute("ALTER TABLE $this->tableProject ADD FOREIGN KEY (client_id) REFERENCES $this->tableClient(id) ON DELETE CASCADE");

		$projects = $this->table($this->tablePhase); // id je automaticky generován
		$projects
			->addColumn('project_id', 'integer')
			//->addForeignKey('id_project', 'projects', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->save();
		$this->execute("ALTER TABLE $this->tablePhase ADD FOREIGN KEY (project_id) REFERENCES $this->tableProject (id)  ON DELETE CASCADE");

		$projects = $this->table($this->tableRisk); // id je automaticky generován
		$projects
			->addColumn('risk_type_id', 'integer')
			//->addForeignKey('id_risk_type', 'risk_types', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('phase_id', 'integer')
			//->addForeignKey('id_phase', 'phases', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('resposibleFor_id', 'integer')
			//->addForeignKey('id_resposibleFor', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('creator_id', 'integer')
			//->addForeignKey('id_creator', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->save();
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (risk_type_id) REFERENCES $this->tableRiskT (id)  ON DELETE CASCADE");
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (phase_id) REFERENCES $this->tablePhase (id)  ON DELETE CASCADE");
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (resposibleFor_id) REFERENCES $this->tableUser (id)  ON DELETE CASCADE");
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (creator_id) REFERENCES $this->tableUser (id)  ON DELETE CASCADE");

		$projects = $this->table($this->tableRole); // id je automaticky generován
		$projects
		->addColumn('user_id', 'integer')
		//->addForeignKey('id_user', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		->addColumn('client_id', 'integer')
		//->addForeignKey('id_client', 'clients', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		->save();
		$this->execute("ALTER TABLE $this->tableRole ADD FOREIGN KEY (user_id) REFERENCES $this->tableUser (id)  ON DELETE CASCADE");
		$this->execute("ALTER TABLE $this->tableRole ADD FOREIGN KEY (client_id) REFERENCES $this->tableClient (id)  ON DELETE CASCADE");

		//->addForeignKey('id_user', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		//->addForeignKey('id_phase', 'phases', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		$this->execute("ALTER TABLE $this->tableUtoPhase ADD FOREIGN KEY (user_id) REFERENCES $this->tableUser (id)  ON DELETE CASCADE");
		$this->execute("ALTER TABLE $this->tableUtoPhase ADD FOREIGN KEY (phase_id) REFERENCES $this->tablePhase (id)  ON DELETE CASCADE");

        //->addForeignKey('id_user', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
        //->addForeignKey('id_project', 'projects', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		$this->execute("ALTER TABLE $this->tableUtoProject ADD FOREIGN KEY (user_id) REFERENCES $this->tableUser (id)  ON DELETE CASCADE");
		$this->execute("ALTER TABLE $this->tableUtoProject ADD FOREIGN KEY (project_id) REFERENCES $this->tableProject (id)  ON DELETE CASCADE");
	}

	/**
	 * Migrate Down.
	 */
	public function down()
	{
    }
}