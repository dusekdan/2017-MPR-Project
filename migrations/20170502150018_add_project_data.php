<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Zuzana Benickova
 * Date:
 * Time:
 */

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

define("VNITRNI_R", 1);
define("VNEJSI_R", 2);
define("TECHNICKA_R", 3);
define("RIZENI_R", 4);
define("ORGANIZACNI_R", 5);
define("EXTERNI_R", 6);

define("ORGANIZACE_E", 1);
define("SPECIFIKACE_E", 2);
define("NAVRH_E", 3);
define("PLANOVANI_E", 4);
define("REALIZACE_E", 5);

class AddProjectData extends AbstractMigration
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
                'email'    => "admin@admin.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "admin",
                'first_name' => "John",
                'last_name' => "Black",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "administrator",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'email'    => "projectManager@projectManager.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "admin2",
                'first_name' => "Jane",
                'last_name' => "Bone",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "projectManager",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'email'    => "owner@owner.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "owner",
                'first_name' => "Fanda",
                'last_name' => "Kollar",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "owner",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'email'    => "programmer@user.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "programmer",
                'first_name' => "Gustav",
                'last_name' => "Kolka",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "user",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'email'    => "analytic@user.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "analytic",
                'first_name' => "Bill",
                'last_name' => "Herris",
                'birthday' => "2000-01-01",
                'phone' => "+420123456789",
                'role' => "user",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'email'    => "dbspecialist@user.cz",
                'password'  => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
                'username' => "dbspecialist",
                'first_name' => "Mia",
                'last_name' => "Jones",
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
                'name' => "Vnitrni rizika",
                'description' => "Rizika, ktera mohou byt ovlivnovanana manazerem projektu nebo projektovym tymem.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Vnejsi rizika",
                'description' => "Rizika, ktera nejsou nijak ovlivnena osobami zapojenych do vyvoje.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Technicka rizika",
                'description' => "Rizika ohrozujici kvalitu nebo provedeni projektu, ktera jsou zapricinena pouzitim neoverene nebo nove technologie, co jeji zmeny behem vyvoje.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Rizika rizeni projektu",
                'description' => "Rizika spojena s casem, nekvalitnim planem projektu ci spatnym pouzitim postupu pro vyvoj projektu.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Organizacni rizika",
                'description' => "Rizika pramenici z nekonzistence case, ceny a vecneho rozsahu vyvoje projektu.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Externi rizika",
                'description' => "Rizika zpusobena zmenami nebo udalostmi mimo samotne deni projektu.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameRT, $rows);

        //Client
        $rows = [
            [
                'name'    => "Dell",
                'description'  => "Zakaznik Dell vyuzivajici nase sluzby.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Samsung",
                'description'  => "Zakaznik Samsung vyuzivajici nase sluzby.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNameC, $rows);

        //Project
        $rows = [
            [
                'name' => "Programova podpora rizeni rizik v IT projektech.",
                'description' => "Vyvoj webove aplikace pro podporu posuzovani rizik v projektech IT.",
                'id_project_manager' => 2,
                'id_client' => 1,
                'start_date' => "2017-03-02 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];
        $this->insert($this->tableNamePr, $rows);

        //Phase
        $rows = [
            [
                'name' => "Pocatecni organizacni zalezitosti",
                'description' => "Rizika, ktera mohla vzniknout pri organizaci projektu.",
                'id_project' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-03 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Analyza a specifikace pozadavku, navrh",
                'description' => "Rizika, ktera mohla vzniknout pri analyze a specifikaci pozadavku.",
                'id_project' => 1,
                'start_date' => "2017-02-03 08:00:0",
                'end_date' => "2017-02-15 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Navrh",
                'description' => "Rizika, ktera mohla vzniknout behem navrhu aplikace.",
                'id_project' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-03-01 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Planovani projektu",
                'description' => "Rizika, ktera mohla vzniknout pri planovani projektu.",
                'id_project' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-03-15 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Technicka realizace",
                'description' => "Rizika, ktera mohla vzniknout behem technicke realizace projektu.",
                'id_project' => 1,
                'start_date' => "2017-03-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]

        ];
        $this->insert($this->tableNamePh, $rows);

        //Risks
        // result == dopad
        // reaction == řešení / prevence /opatření

        $rows = [

            // organizace a komunikace
            [
                'name'    => "Absence urcitych schopnosti nektereho clena tymu.",
                'description'  => "Byla predpokladana znalost.",
                'probability' => 0.2,
                'money' => 20000,
                'time' => 20,
                'result' => "Zpomaleni praci ci jejich uplne zastaveni.",
                'primary_cause' => "Nedostatecne provereni znalosti a schopnosti clenu tymu.",
                'trigger' => "",
                'reaction' => "Provedeni pruzkumu schopnosti a znalosti jednotlivych clenu tymu a tomu odpovidajici rozdeleni zodpovednosti.",
                'severity' => 0.8,
                'id_risk_type' => VNITRNI_R,
                'id_phase' => ORGANIZACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Spatna komunikace v tymu",
                'description'  => "V tymu jsou lide, kteri spolu nedokazou spolupracovat",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Zpomaleni postupu na projektu, chybejici predani informaci.",
                'primary_cause' => "Clenove tymu se navzajem neznaji, jsou nekomunikativni.",
                'trigger' => "",
                'reaction' => "Usporadani teambuildingove akce, vyvarovani se nespolecenskych a nekomunikativnich lidi v tymu.",
                'severity' => 0.8,
                'id_risk_type' => VNITRNI_R,
                'id_phase' => ORGANIZACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "¨Momentalni indispozice nektereho clena tymu.",
                'description'  => "Nemoc, uraz.",
                'probability' => 0.2,
                'money' => 40000,
                'time' => 40,
                'result' => "Zpomaleni ci zastaveni nektere casti projektu.",
                'primary_cause' => "Absence zastupce.",
                'trigger' => "",
                'reaction' => "Mit co nejflexibilnejsi cleny v tymu, nebo nejake lidi mimo tym jako zalozni.",
                'severity' => 0.6,
                'id_risk_type' => VNITRNI_R,
                'id_phase' => ORGANIZACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Opusteni clena tymu.",
                'description'  => "Clen odchazi do jineho zamestnani.",
                'probability' => 0.2,
                'money' => 50000,
                'time' => 50,
                'result' => "Zpomaleni ci zastaveni nektere casti projektu.",
                'primary_cause' => "Absence zastupce.",
                'trigger' => "",
                'reaction' => "Mit v zaloze lidi, ktere je mozno prijmout do tymu, mit v smlouve vypovedni dobu.",
                'severity' => 0.7,
                'id_risk_type' => VNITRNI_R,
                'id_phase' => ORGANIZACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Docasna indispozice vedouciho.",
                'description'  => "Nemoc nebo uraz projekt manazera.",
                'probability' => 0.1,
                'money' => 50000,
                'time' => 50,
                'result' => "Chaoticke rizeni projektu.",
                'primary_cause' => "Absence zastupce vedouciho projektu.",
                'trigger' => "",
                'reaction' => "Vytvoreni postu zastupce vedouciho pro vhodneho jedince.",
                'severity' => 0.8,
                'id_risk_type' => VNITRNI_R,
                'id_phase' => ORGANIZACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Nerovnomerne rozdeleni praci na projektu.",
                'description'  => "Nekteri clenove tymu nemaji co delat, ostatni nestihaji.",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Stagnace urcitych clenu tymu.",
                'primary_cause' => "Nedusledne rozdeleni prace a plan postupu na projektu.",
                'trigger' => "",
                'reaction' => "Dusledne promysleni a casove odhadnuti prace na jednotlivych castech projektu. Dusledny odhad efektivity pracovniku.",
                'severity' => 0.8,
                'id_risk_type' => VNEJSI_R,
                'id_phase' => ORGANIZACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],


            // specifikace a navrh
            [
                'name'    => "Nepochopeni potreb zakaznika.",
                'description'  => "Na shuzce se zakaznikem nebylo probrano vse do detailu, zustaly otevrene otazky na celkove pouziti aplikace.",
                'probability' => 0.5,
                'money' => 30000,
                'time' => 100,
                'result' => "Nemoznost shodnout se se zakaznikem",
                'primary_cause' => "Nedostatecny rozbor zakaznikovych potreb.",
                'trigger' => "",
                'reaction' => "Neformalni schuzka se zakaznikem a rozbor jeho potreb.",
                'severity' => 0.95,
                'id_risk_type' => ORGANIZACNI_R,
                'id_phase' => SPECIFIKACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Chybna specifikace.",
                'description'  => "Typy jednani nejsou specifikovany spravne",
                'probability' => 0.35,
                'money' => 15000,
                'time' => 50,
                'result' => "Rozkol mezi predstavou zakaznika a vyslednou funkcnosti produktu.",
                'primary_cause' => "Nedostatecne detailne pospsana specifikace pozadavku.",
                'trigger' => "",
                'reaction' => "Dusledna analyza jednotlivych jednani a jejich krajnich pripadu, zaznamenani do specifikace pozadavku.",
                'severity' => 0.7,
                'id_risk_type' => ORGANIZACNI_R,
                'id_phase' => SPECIFIKACE_E,
                'id_resposibleFor' => 5,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Neuplna specifikace.",
                'description'  => "Chybi nejaky typ jednani.",
                'probability' => 0.6,
                'money' => 6000,
                'time' => 20,
                'result' => "Aplikace postrada nejakou funkcnost.",
                'primary_cause' => "Nedostatecna kontrola ci konzultace se zakaznikem o specifikaci pozadavku.",
                'trigger' => "",
                'reaction' => "Predlozit zakaznikovi specifikaci ke schvaleni a vytvorit schvalovaci dokument.",
                'severity' => 0.8,
                'id_risk_type' => ORGANIZACNI_R,
                'id_phase' => SPECIFIKACE_E,
                'id_resposibleFor' => 5,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Nevhodny navrh databaze.",
                'description'  => "Databaze ma chybne navrzenou strukturu, nelze provadet nektere operace ze specifikace pozadavku.",
                'probability' => 0.5,
                'money' => 9000,
                'time' => 30,
                'result' => "Aplikace neni schopna vykonat nektere ze specifikovanych jednani.",
                'primary_cause' => "Nedostatecna analyza navrhu database vzhledem k funkcnosti aplikace.",
                'trigger' => "",
                'reaction' => "Udelat dukladnou analyzu navrhu databaze vzhledem k funknosti aplikace",
                'severity' => 0.6,
                'id_risk_type' => ORGANIZACNI_R,
                'id_phase' => NAVRH_E,
                'id_resposibleFor' => 6,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Zmena zadani zakaznikem.",
                'description'  => "Zakaznik zapomel nebo chybne predlozil jeho pozadavky.",
                'probability' => 0.35,
                'money' => 6000,
                'time' => 20,
                'result' => "Kompletni zpomaleni a zdrazeni produktu.",
                'primary_cause' => "Zakaznik si neujasnil dostatecne svoje pozadavky.",
                'trigger' => "",
                'reaction' => "Zmeny musi byt schvaleny tymem a musi byt dohodnuto pripadne navyseni rozpoctu a posunuti ukonceni projektu.",
                'severity' => 0.8,
                'id_risk_type' => VNEJSI_R,
                'id_phase' => NAVRH_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Prilis rozsahla specifikace, presahujici poteby zakaznika.",
                'description'  => "Specifikace se zabyva dedulezitymi detaily, ktere nemaji vliv na spravne uchopeni potreb zakaznika",
                'probability' => 0.35,
                'money' => 6000,
                'time' => 20,
                'result' => "Vyrazne zpozdeni a presahnuti rozpoctu.",
                'primary_cause' => "Zabyvani se prilis velkymy detaily, ktere nemaji vliv na konecnou spravnou funkci aplikace.",
                'trigger' => "",
                'reaction' => "Hlavnim vstupem pro specifikaci je zakaznik, nepridavat tam nic navic.",
                'severity' => 0.8,
                'id_risk_type' => ORGANIZACNI_R,
                'id_phase' => SPECIFIKACE_E,
                'id_resposibleFor' => 5,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Spatne navrzene rozhrani jednotlivych casti.",
                'description'  => "Casti na sebe nelze jednoduse napojit.",
                'probability' => 0.35,
                'money' => 9000,
                'time' => 30,
                'result' => "Casti na sebe nelze napojit - nespravne fungujici system.",
                'primary_cause' => "Nedostatecne overeni vystupu jednotlivych casti tak, aby odpovidali vstupum do casti jinych.",
                'trigger' => "",
                'reaction' => "Dukladna domluva a sepsani toho, jak maji jednotliva rozhrani vypadat, dodrzovani tohoto vzhledu.",
                'severity' => 0.6,
                'id_risk_type' => VNITRNI_R,
                'id_phase' => NAVRH_E,
                'id_resposibleFor' => 4,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Nevhodny design.",
                'description'  => "Zakaznik neni spokojen se vzhledem aplikace",
                'probability' => 0.2,
                'money' => 3000,
                'time' => 10,
                'result' => "Nespokojenost zakaznika.",
                'primary_cause' => "Neprobrani vzhledu aplikace pred jeho aplikaci.",
                'trigger' => "",
                'reaction' => "Zmena vzhledu.",
                'severity' => 0.5,
                'id_risk_type' => VNITRNI_R,
                'id_phase' => NAVRH_E,
                'id_resposibleFor' => 4,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Platforma nevyhovujici zakaznikovi.",
                'description'  => "",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Neprijaty produkt.",
                'primary_cause' => "Neodstatecna konzultace na tema cilove platformy.",
                'trigger' => "",
                'reaction' => "Odsouhlaseni platformy zakaznikem.",
                'severity' => 0.9,
                'id_risk_type' => TECHNICKA_R,
                'id_phase' => SPECIFIKACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],

            // planovani
            [
                'name'    => "Chybejici cinnost v planu.",
                'description'  => "Nezohledneni nezbytne cinnosti v casovem a rozpoctovem lanu projektu.",
                'probability' => 0.1,
                'money' => 60000,
                'time' => 60,
                'result' => "Zpozdeni realizace.",
                'primary_cause' => "Nedusledna analyza planu projektu." ,
                'trigger' => "",
                'reaction' => "Tvoreni planu v celem tymu a zahrnuti kazdeho jeho detailu, myslet dopredu.",
                'severity' => 0.6,
                'id_risk_type' => RIZENI_R,
                'id_phase' => PLANOVANI_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Nedodrzovani terminu",
                'description'  => "Behem vyvoje aplikace se nestiha dokoncovat v terminech to, co ma.",
                'probability' => 0.5,
                'money' => 70000,
                'time' => 70,
                'result' => "Retezovy efekt zpomaleni navazujicich ukolu.",
                'primary_cause' => "Spatne odhadnute doby trvani nekterych ukolu." ,
                'trigger' => "",
                'reaction' => "Pravidelna kontrola stavu a pripadne reseni zpozdeni co nejdrive.",
                'severity' => 0.7,
                'id_risk_type' => RIZENI_R,
                'id_phase' => PLANOVANI_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Spatne naplanovana posloupnost praci.",
                'description'  => "Neni hotova cinnost, ktera je potreba byt hotova pro zapoceti cinnosti jine.",
                'probability' => 0.4,
                'money' => 30000,
                'time' => 30,
                'result' => "Casti tymu musi cekat, zpozdeni.",
                'primary_cause' => "Nepromysleni nezbytnych vstupu pro jednotlive cinnosti.",
                'trigger' => "",
                'reaction' => "Konzultace navaznosti jednotlivych casti v ramci celeho tymu. Spravny odhad trvani casti.",
                'severity' => 0.8,
                'id_risk_type' => RIZENI_R,
                'id_phase' => PLANOVANI_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Nedodrzeni finalniho deadlinu projektu.",
                'description'  => "Dokonceni projektu ma zpozdeni.",
                'probability' => 0.35,
                'money' => 80000,
                'time' => 80,
                'result' => "Nedodani produktu vcas = nespokojenost zakaznika.",
                'primary_cause' => "Chybny odhad delky trvani prace na projektu, neodhaleni moznych zdrzeni." ,
                'trigger' => "",
                'reaction' => "Zapocitat do odhadu i mozna zpozdeni, pokud nastane problem, resit jej vcas zmenovym rizenim.",
                'severity' => 0.9,
                'id_risk_type' => RIZENI_R,
                'id_phase' => PLANOVANI_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],

            // technicka realizace
            [
                'name'    => "Problemy pri instalaci nebo behu vyvojovych prostredi.",
                'description'  => "Pracovnik neni schopen pracovat na projektu, protoze mu nefunguje vyvojove prostredi.",
                'probability' => 0.2,
                'money' => 40000,
                'time' => 40,
                'result' => "Nemoznost prace nekterych clenu, zdrzeni.",
                'primary_cause' => "Nedostatecne provereni implementacnich prostredku, aktualizace atd." ,
                'trigger' => "",
                'reaction' => "Vyhrazeni nektereho clena tymu, ktery se bude zabyvat problemy s vyvojovymi prostredky, pravidelne aktualizace.",
                'severity' => 0.9,
                'id_risk_type' => TECHNICKA_R,
                'id_phase' => REALIZACE_E,
                'id_resposibleFor' => 1,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Pouziti neoverenych knihoven",
                'description'  => "",
                'probability' => 0.1,
                'money' => 60000,
                'time' => 60,
                'result' => "Neni zarucen spravny vysledek prace.",
                'primary_cause' => "Nenalezeni jinych vhodnych, overenych knihoven." ,
                'trigger' => "",
                'reaction' => "Pouziti pouze overenych knihoven.",
                'severity' => 0.3,
                'id_risk_type' => TECHNICKA_R,
                'id_phase' => REALIZACE_E,
                'id_resposibleFor' => 4,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Nekomplatibilnost knihoven jednotlivych clenu.",
                'description'  => "",
                'probability' => 0.4,
                'money' => 20000,
                'time' => 20,
                'result' => "Casti produktu nelze pospojovat.",
                'primary_cause' => "Spatna komunikace ohledne pouzivanych knihoven." ,
                'trigger' => "",
                'reaction' => "Dopredna domluva na uzitych knihovnach",
                'severity' => 0.2,
                'id_risk_type' => TECHNICKA_R,
                'id_phase' => REALIZACE_E,
                'id_resposibleFor' => 4,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Premazani master branche na verzovacim systemu.",
                'description'  => "Programator resil konflikty pri aktualizaci jeho kodu a neudelal to peclive.",
                'probability' => 0.1,
                'money' => 90000,
                'time' => 90,
                'result' => "Ztrata funkcnich kodu.",
                'primary_cause' => "Nepozornost pracovnika, chybejici zaloha." ,
                'trigger' => "",
                'reaction' => "Zalohovat co nejcasteji master branch.",
                'severity' => 0.9,
                'id_risk_type' => TECHNICKA_R,
                'id_phase' => REALIZACE_E,
                'id_resposibleFor' => 4,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],

            // externi udalosti
            [
                'name'    => "Poskozeni pracovnich stroju prirodnim zivlem.",
                'description'  => "",
                'probability' => 0.05,
                'money' => 100000,
                'time' => 10,
                'result' => "Hmotna skoda a mozna ztrata dat.",
                'primary_cause' => "Nepojisteny majetek, nezalohovana data." ,
                'trigger' => "",
                'reaction' => "Zalohovat data a mit pojisteny hmotny majetek firmy.",
                'severity' => 0.8,
                'id_risk_type' => EXTERNI_R,
                'id_phase' => REALIZACE_E,
                'id_resposibleFor' => 2,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Zakaznik prerusi smlouvu",
                'description'  => "Zakaznik odstupuje od dohodnute smlouvy.",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Financni ztrata.",
                'primary_cause' => "Prilis optimisticka a nedusledna smlouva se zakaznikem." ,
                'trigger' => "",
                'reaction' => "Mit ve smlouve se zakaznikem zahrnuty storno poplatky, ktere by pripadne kompenzovaly financni ztratu.",
                'severity' => 0.9,
                'id_risk_type' => EXTERNI_R,
                'id_phase' => REALIZACE_E,
                'id_resposibleFor' => 3,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name'    => "Nezkuseni uzivatele koncoveho systemu.",
                'description'  => "Uzivatele neumi pracovat s produktem, pretrvavaji opakujici se dotazy na jeho spravne pouzivani.",
                'probability' => 0.3,
                'money' => 40000,
                'time' => 50,
                'result' => "Prodluzujici se podpora nasazeni produktu do provozu.",
                'primary_cause' => "Chybejici domluva na zaskoleni." ,
                'trigger' => "",
                'reaction' => "Vypracovani kvalitni prirucky a provedeni zaskoleni na urovni koncovych uzivatelu.",
                'severity' => 0.4,
                'id_risk_type' => EXTERNI_R,
                'id_phase' => REALIZACE_E,
                'id_resposibleFor' => 3,
                'id_creator' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],


        ];
        $this->insert($this->tableNameRi, $rows);


        //Role
        $rows = [
            [
                'name' => "Administrator",
                'description' => "Administrator se stara o spravu aplikace.",
                'id_user' => 1,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Project manager",
                'description' => "Project manager ridi jednotlive etapy projektu, kontroluje vystupy kazde z nich a je zodpovedny za dodani celeho projektu.",
                'id_user' => 2,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Majitel",
                'description' => "Vlastnik aplikace.",
                'id_user' => 3,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Bezny uzivate",
                'description' => "Bezny uzivatel aplikace.",
                'id_user' => 4,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Bezny uzivate",
                'description' => "Bezny uzivatel aplikace.",
                'id_user' => 5,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Bezny uzivate",
                'description' => "Bezny uzivatel aplikace.",
                'id_user' => 5,
                'id_client' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Bezny uzivate",
                'description' => "Bezny uzivatel aplikace.",
                'id_user' => 6,
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
                'id_user' => 1,
                'id_phase' => 2,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 1,
                'id_phase' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 1,
                'id_phase' => 4,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 2,
                'id_phase' => 2,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 3,
                'id_phase' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 3,
                'id_phase' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 6,
                'id_phase' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 5,
                'id_phase' => 5,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            [
                'id_user' => 6,
                'id_phase' => 5,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")

            ],
            // TODO: doplnit lidi k tem castem projektu
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
                'id_user' => 2,
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'id_user' => 3,
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'id_user' => 4,
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'id_user' => 5,
                'id_project' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'id_user' => 6,
                'id_project' => 1,
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
        $this->execute("DELETE FROM $this->tableNameUoPh");
        $this->execute("DELETE FROM $this->tableNameUoPr");
        $this->execute("DELETE FROM $this->tableNameRo");
        $this->execute("DELETE FROM $this->tableNameRi");
        $this->execute("DELETE FROM $this->tableNamePh");
        $this->execute("DELETE FROM $this->tableNamePr");
        $this->execute("DELETE FROM $this->tableNameC");
        $this->execute("DELETE FROM $this->tableNameRT");
        $this->execute("DELETE FROM $this->tableNameU");
    }
}