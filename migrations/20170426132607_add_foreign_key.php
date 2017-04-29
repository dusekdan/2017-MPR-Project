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
			->addColumn('id_project_manager', 'integer')
			//->addForeignKey('id_project_manager', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('id_client', 'integer')
			//->addForeignKey('id_client', 'clients', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->save();

		$this->execute("ALTER TABLE $this->tableProject ADD FOREIGN KEY (id_project_manager) REFERENCES $this->tableUser(id)");
		$this->execute("ALTER TABLE $this->tableProject ADD FOREIGN KEY (id_client) REFERENCES $this->tableClient(id)");

		$projects = $this->table($this->tablePhase); // id je automaticky generován
		$projects
			->addColumn('id_project', 'integer')
			//->addForeignKey('id_project', 'projects', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->save();
		$this->execute("ALTER TABLE $this->tablePhase ADD FOREIGN KEY (id_project) REFERENCES $this->tableProject (id)");

		$projects = $this->table($this->tableRisk); // id je automaticky generován
		$projects
			->addColumn('id_risk_type', 'integer')
			//->addForeignKey('id_risk_type', 'risk_types', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('id_phase', 'integer')
			//->addForeignKey('id_phase', 'phases', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('id_resposibleFor', 'integer')
			//->addForeignKey('id_resposibleFor', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->addColumn('id_creator', 'integer')
			//->addForeignKey('id_creator', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
			->save();
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (id_risk_type) REFERENCES $this->tableRiskT (id)");
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (id_phase) REFERENCES $this->tablePhase (id)");
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (id_resposibleFor) REFERENCES $this->tableUser (id)");
		$this->execute("ALTER TABLE $this->tableRisk ADD FOREIGN KEY (id_creator) REFERENCES $this->tableUser (id)");

		$projects = $this->table($this->tableRole); // id je automaticky generován
		$projects
		->addColumn('id_user', 'integer')
		//->addForeignKey('id_user', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		->addColumn('id_client', 'integer')
		//->addForeignKey('id_client', 'clients', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		->save();
		$this->execute("ALTER TABLE $this->tableRole ADD FOREIGN KEY (id_user) REFERENCES $this->tableUser (id)");
		$this->execute("ALTER TABLE $this->tableRole ADD FOREIGN KEY (id_client) REFERENCES $this->tableClient (id)");

		//->addForeignKey('id_user', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		//->addForeignKey('id_phase', 'phases', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		$this->execute("ALTER TABLE $this->tableUtoPhase ADD FOREIGN KEY (id_user) REFERENCES $this->tableUser (id)");
		$this->execute("ALTER TABLE $this->tableUtoPhase ADD FOREIGN KEY (id_phase) REFERENCES $this->tablePhase (id)");

        //->addForeignKey('id_user', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
        //->addForeignKey('id_project', 'projects', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
		$this->execute("ALTER TABLE $this->tableUtoProject ADD FOREIGN KEY (id_user) REFERENCES $this->tableUser (id)");
		$this->execute("ALTER TABLE $this->tableUtoProject ADD FOREIGN KEY (id_project) REFERENCES $this->tableProject (id)");
	}

	/**
	 * Migrate Down.
	 */
	public function down()
	{
    }
}