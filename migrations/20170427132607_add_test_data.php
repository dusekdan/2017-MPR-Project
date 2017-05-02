<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddTestData extends AbstractMigration
{
    private $tableNameU = "users";
    private $tableNameRi = "risks";
    private $tableNameC = "clients";
    private $tableNamePh = "phases";
    private $tableNamePr = "projects";
    private $tableNameRT = "risk_types";
    private $tableNameUoPh = "users_on_phases";
    private $tableNameRo = "roles";
    private $tableNameUoPr = "users_on_projects";


	/**
	 * Migrate Up.
	 */
	public function up()
	{
        //Users heslo je 123456
        $rows = [
            [
                'email'    => "superAdmin@admin.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "superAdmin",
                'first_name' => "Jméno",
                'last_name' => "Příjmení",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "administrator",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'email'    => "admin@admin.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "admin",
                'first_name' => "Jméno",
                'last_name' => "Příjmení",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "projectManager",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'email'    => "guest@guest.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "guest",
                'first_name' => "Jméno",
                'last_name' => "Příjmení",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "user",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameU, $rows);

        //Risk type
        $rows = [
            [
                'name' => "Ohrozenie",
                'description' => "Sem pojde text o tomto type, pravdepodobne z prednasky.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Porucha",
                'description' => "Sem pojde text o tomto type, pravdepodobne z prednasky.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Kriza",
                'description' => "Sem pojde text o tomto type, pravdepodobne z prednasky.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Katastrofa",
                'description' => "Sem pojde text o tomto type, pravdepodobne z prednasky.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],[
                'name' => "Prilezitost",
                'description' => "Sem pojde text o tomto type, pravdepodobne z prednasky.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],[
                'name' => "Utok",
                'description' => "Sem pojde text o tomto type, pravdepodobne z prednasky.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],[
                'name' => "Ludska hlupost",
                'description' => "Sem pojde text o tomto type, pravdepodobne z prednasky.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameRT, $rows);

        //Client
        $rows = [
            [
                'name'    => "Dell",
                'description'  => "Zakaznik Dell vyuzivajuci nase sluzby.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Samsung",
                'description'  => "Zakaznik Samsung vyuzivajuci nase sluzby.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameC, $rows);

        //Project
        $rows = [
            [
                'name' => "Aplikacia smetiarov.",
                'description' => "Vyvoj aplikacie na bezpecny odvoz smeti.",
                'id_project_manager' => 1,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Projekt nasadenia mikrocipov do lekarskeho prostredia.",
                'description' => "Dlhodoby projekt nasadenia a pouzitia mikrocipov na liecebne ucely v ludskom tele.",
                'id_project_manager' => 1,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNamePr, $rows);

        //Phase
        $rows = [
            [
                'name' => "Navrh",
                'description' => "Pociatocna faza projektu.",
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Implementacia",
                'description' => "Implementacna faza projektu.",
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNamePh, $rows);

        //Risks
        $rows = [
            [
                'name'    => "Vazna choroba programatora.",
                'description'  => "Pocas najdolezitejsej fazy, kedy je prepocet na cloveko-hodinu by projekt dlhsia absencia programatora vazne ohrozila.",
                'probability' => 0.35,
                'money' => 10000, //korun??
                'time' => "3", //dni??tyzdne?? musime dohodnut
                'result' => "Posunutie datumu dokoncenia projektu, vacsie naklady.",
                'primary_cause' => "Ziadna zalozna sila.",
                'trigger' => "Choroba programatora.",
                'reaction' => "Najatie noveho programatora.",
                'severity' => 0.9,
                'id_risk_type' => 1,
                'id_phase' => 1,
                'id_resposibleFor' => 1,
                'id_creator' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Vazna choroba Project Managera.",
                'description'  => "Odchod project managera celeho projektu.",
                'probability' => 0.15,
                'money' => 10000, //korun??
                'time' => "3", //dni??tyzdne?? musime dohodnut
                'result' => "Posunutie datumu dokoncenia projektu, vacsie naklady.",
                'primary_cause' => "Ziadna zalozna sila.",
                'trigger' => "Choroba PM.",
                'reaction' => "Najatie noveho PM. Posunutie projektu.",
                'severity' => 0.9,
                'id_risk_type' => 1,
                'id_phase' => 1,
                'id_resposibleFor' => 1,
                'id_creator' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s"),
            ]
        ];
        $this->insert($this->tableNameRi, $rows);


        //Role
        $rows = [
            [
                'name' => "programator",
                'description' => "Tento clovek implementuje poziadavky na projekt. Znalosti c, c++, python.",
                'id_user' => 1,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "project manager",
                'description' => "Project manager, zodpovedny za projekt. V projekte predtym pracoval ako programator, postavil celu kostru.",
                'id_user' => 1,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameRo, $rows);

        //Users on phase
        $rows = [
            [
                'id_user' => 1,
                'id_phase' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 2,
                'id_phase' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameUoPh, $rows);

        //Users on Project
        $rows = [
            [
                'id_user' => 1,
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'id_user' => 1,
                'id_project' => 2,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'id_user' => 2,
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'id_user' => 2,
                'id_project' => 2,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameUoPr, $rows);



	}

	/**
	 * Migrate Down.
	 */
	public function down()
	{

        $this->execute("DELETE FROM $this->tableNameUoPr");
        $this->execute("DELETE FROM $this->tableNameUoPh");
        $this->execute("DELETE FROM $this->tableNameRo");
        $this->execute("DELETE FROM $this->tableNameRi");
        $this->execute("DELETE FROM $this->tableNamePh");
        $this->execute("DELETE FROM $this->tableNamePr");
        $this->execute("DELETE FROM $this->tableNameC");
        $this->execute("DELETE FROM $this->tableNameRT");
        $this->execute("DELETE FROM $this->tableNameU");
    }
}