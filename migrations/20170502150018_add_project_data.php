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
                'email' => "admin@admin.cz",
                'password' => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
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
                'email' => "projectManager@projectManager.cz",
                'password' => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
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
                'email' => "owner@owner.cz",
                'password' => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
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
                'email' => "programmer@user.cz",
                'password' => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
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
                'email' => "analytic@user.cz",
                'password' => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
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
                'email' => "dbspecialist@user.cz",
                'password' => '$2y$10$.kckarxUiumF2QkqHWx6DuTu6JHU/ChWMd3AsiRFiRtEUBjZiKA12',
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
                'name' => "Vnitřní rizika",
                'description' => "Rizika, která mohou být ovlivnovanana manažerem projektu nebo projektovým týmem.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Vnější rizika",
                'description' => "Rizika, která nejsou nijak ovlivněna osobami zapojených do vývoje.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Technická rizika",
                'description' => "Rizika ohrožující kvalitu nebo provedení projektu, která jsou zapříčiněna použitím neověřené nebo nové technologie, co její změny během vývoje.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Rizika řízení projektu",
                'description' => "Rizika spojena s časem, nekvalitním plánem projektu či špatným použitím postupu pro vývoj projektu.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Organizační rizika",
                'description' => "Rizika pramenící z nekonzistence čase, ceny a věčného rozsahu vývoje projektu.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Externí rizika",
                'description' => "Rizika způsobena změnami nebo událostmi mimo samotné dění projektu.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];

        $this->insert($this->tableNameRT, $rows);

        //Client

        $rows = [
            [
                'name' => "Dell",
                'description' => "Zákazník Dell využívající naše služby.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Samsung",
                'description' => "Zákazník Samsung využívající naše služby.",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];

        $this->insert($this->tableNameC, $rows);

        //Project

        $rows = [
            [
                'name' => "Programová podpora řízení rizik v IT projektech.",
                'description' => "Vývoj webove aplikace pro podporu posuzování rizik v projektech IT.",
                'project_manager_id' => 2,
                'client_id' => 1,
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
                'name' => "Počáteční organizační záležitosti",
                'description' => "Rizika, která mohla vzniknout při organizací projektu.",
                'project_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-07-03 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Analýza a specifikace požadavků, návrh",
                'description' => "Rizika, která mohla vzniknout při analýze a specifikaci požadavků.",
                'project_id' => 1,
                'start_date' => "2017-02-03 08:00:0",
                'end_date' => "2017-02-15 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Návrh",
                'description' => "Rizika, která mohla vzniknout během návrhu aplikace.",
                'project_id' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-03-01 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Plánování projektu",
                'description' => "Rizika, která mohla vzniknout při plánování projektu.",
                'project_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-03-15 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Technická realizace",
                'description' => "Rizika, která mohla vzniknout během technické realizace projektu.",
                'project_id' => 1,
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
                'name' => "Absence určitých schopnosti některého člena týmu.",
                'description' => "Byla předpokládaná znalost.",
                'probability' => 0.2,
                'money' => 20000,
                'time' => 20,
                'result' => "Zpomalení práci či jejich úplně zastavení.",
                'primary_cause' => "Nedostatečné prověření znalosti a schopnosti členů týmu.",
                'trigger' => "",
                'reaction' => "Provedení průzkumu schopnosti a znalosti jednotlivých členů týmu a tomu odpovídající rozdělení zodpovědnosti.",
                'severity' => 0.8,
                'risk_type_id' => VNITRNI_R,
                'phase_id' => ORGANIZACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-03-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Špatná komunikace v týmu",
                'description' => "V týmu jsou lidé, kteří spolu nedokážou spolupracovat",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Zpomalení postupu na projektu, chybějící předání informací.",
                'primary_cause' => "Členové týmu se navzájem neznají, jsou nekomunikativní.",
                'trigger' => "",
                'reaction' => "Uspořádání teambuildingove akce, vyvařování se nespolečenských a nekomunikativních lidí v týmu.",
                'severity' => 0.8,
                'risk_type_id' => VNITRNI_R,
                'phase_id' => ORGANIZACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Momentální indispozice některého člena týmu.",
                'description' => "Nemoc, úraz.",
                'probability' => 0.2,
                'money' => 40000,
                'time' => 40,
                'result' => "Zpomalení či zastavení některé části projektu.",
                'primary_cause' => "Absence zástupce.",
                'trigger' => "",
                'reaction' => "Mít co nejflexibilnější členy v týmu, nebo nějaké lidí mimo tým jako záložní.",
                'severity' => 0.6,
                'risk_type_id' => VNITRNI_R,
                'phase_id' => ORGANIZACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Opuštění člena týmu.",
                'description' => "Člen odchází do jiného zaměstnání.",
                'probability' => 0.2,
                'money' => 50000,
                'time' => 50,
                'result' => "Zpomalení či zastavení některé části projektu.",
                'primary_cause' => "Absence zástupce.",
                'trigger' => "",
                'reaction' => "Mít v záloze lidí, které je možno přijmout do týmu, mít v smlouvě výpovědní dobu.",
                'severity' => 0.7,
                'risk_type_id' => VNITRNI_R,
                'phase_id' => ORGANIZACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Dočasná indispozice vedoucího.",
                'description' => "Nemoc nebo úraz projekt manažera.",
                'probability' => 0.1,
                'money' => 50000,
                'time' => 50,
                'result' => "Chaotické řízení projektu.",
                'primary_cause' => "Absence zástupce vedoucího projektu.",
                'trigger' => "",
                'reaction' => "Vytvoření postu zástupce vedoucího pro vhodného jedince.",
                'severity' => 0.8,
                'risk_type_id' => VNITRNI_R,
                'phase_id' => ORGANIZACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Nerovnoměrně rozdělení práci na projektu.",
                'description' => "Někteří členové týmu nemají co dělat, ostatní nestíhají.",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Stagnace určitých členů týmu.",
                'primary_cause' => "Nedůsledně rozdělení práce a plán postupu na projektu.",
                'trigger' => "",
                'reaction' => "Důsledně promýšlení a časově odhadnutí práce na jednotlivých částech projektu. Důsledný odhad efektivity pracovníků.",
                'severity' => 0.8,
                'risk_type_id' => VNEJSI_R,
                'phase_id' => ORGANIZACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-05 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],

            // specifikace a návrh

            [
                'name' => "Nepochopení potřeb zákazníka.",
                'description' => "Na shuzce se zákazníkem nebylo probráno vše do detailů, zůstaly otevřené otázky na celkové použití aplikace.",
                'probability' => 0.5,
                'money' => 30000,
                'time' => 100,
                'result' => "Nemožnost shodnout se se zákazníkem",
                'primary_cause' => "Nedostatečný rozbor zákazníkových potřeb.",
                'trigger' => "",
                'reaction' => "Neformální schůzka se zákazníkem a rozbor jeho potřeb.",
                'severity' => 0.95,
                'risk_type_id' => ORGANIZACNI_R,
                'phase_id' => SPECIFIKACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Chybná specifikace.",
                'description' => "Typy jednání nejsou specifikovány správné",
                'probability' => 0.35,
                'money' => 15000,
                'time' => 50,
                'result' => "Rozkol mezi představou zákazníka a výslednou funkčnosti produktů.",
                'primary_cause' => "Nedostatečné detailně pospsana specifikace požadavků.",
                'trigger' => "",
                'reaction' => "Důsledná analýza jednotlivých jednání a jejich krajních případů, zaznamenání do specifikace požadavků.",
                'severity' => 0.7,
                'risk_type_id' => ORGANIZACNI_R,
                'phase_id' => SPECIFIKACE_E,
                'resposibleFor_id' => 5,
                'creator_id' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Neúplná specifikace.",
                'description' => "Chybí nějaký typ jednání.",
                'probability' => 0.6,
                'money' => 6000,
                'time' => 20,
                'result' => "Aplikace postrádá nějakou funkčnost.",
                'primary_cause' => "Nedostatečná kontrola či konzultace se zákazníkem o specifikaci požadavků.",
                'trigger' => "",
                'reaction' => "Předložit zákazníkovi specifikaci ke schválení a vytvořit schvalovací dokument.",
                'severity' => 0.8,
                'risk_type_id' => ORGANIZACNI_R,
                'phase_id' => SPECIFIKACE_E,
                'resposibleFor_id' => 5,
                'creator_id' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Nevhodný návrh databáze.",
                'description' => "Databáze má chybné navrženou strukturu, nelze provádět některé operace že specifikace požadavků.",
                'probability' => 0.5,
                'money' => 9000,
                'time' => 30,
                'result' => "Aplikace není schopna vykonat některé že specifikovaných jednání.",
                'primary_cause' => "Nedostatečná analýza návrhu database vzhledem k funkčnosti aplikace.",
                'trigger' => "",
                'reaction' => "Udělat důkladnou analýzu návrhu databáze vzhledem k funknosti aplikace",
                'severity' => 0.6,
                'risk_type_id' => ORGANIZACNI_R,
                'phase_id' => NAVRH_E,
                'resposibleFor_id' => 6,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Změna zadání zákazníkem.",
                'description' => "Zákazník zapomel nebo chybné předložil jeho požadavky.",
                'probability' => 0.35,
                'money' => 6000,
                'time' => 20,
                'result' => "Kompletní zpomalení a zdražení produktů.",
                'primary_cause' => "Zákazník si neujasnil dostatečně svoje požadavky.",
                'trigger' => "",
                'reaction' => "Změny musí být schválený týmem a musí být dohodnuto případně navýšení rozpočtu a posunutí ukončení projektu.",
                'severity' => 0.8,
                'risk_type_id' => VNEJSI_R,
                'phase_id' => NAVRH_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Příliš rozsáhlá specifikace, přesahující poteby zákazníka.",
                'description' => "Specifikace se zabývá dedulezitymi detaily, které nemají vliv na správné uchopení potřeb zákazníka",
                'probability' => 0.35,
                'money' => 6000,
                'time' => 20,
                'result' => "Výrazně zpoždění a přesáhnutí rozpočtu.",
                'primary_cause' => "Zabývání se příliš velkymy detaily, které nemají vliv na konečnou správnou funkci aplikace.",
                'trigger' => "",
                'reaction' => "Hlavním vstupem pro specifikaci je zákazník, nepřidávat tam nic navíc.",
                'severity' => 0.8,
                'risk_type_id' => ORGANIZACNI_R,
                'phase_id' => SPECIFIKACE_E,
                'resposibleFor_id' => 5,
                'creator_id' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Špatně navržené rozhraní jednotlivých části.",
                'description' => "Části na sebe nelze jednoduše napojit.",
                'probability' => 0.35,
                'money' => 9000,
                'time' => 30,
                'result' => "Části na sebe nelze napojit - nesprávné fungující systém.",
                'primary_cause' => "Nedostatečné ověření výstupu jednotlivých části tak, aby odpovídali vstupům do části jiných.",
                'trigger' => "",
                'reaction' => "Důkladná domluva a sepsání toho, jak mají jednotlivá rozhraní vypadat, dodržování tohoto vzhledu.",
                'severity' => 0.6,
                'risk_type_id' => VNITRNI_R,
                'phase_id' => NAVRH_E,
                'resposibleFor_id' => 4,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Nevhodný design.",
                'description' => "Zákazník není spokojen se vzhledem aplikace",
                'probability' => 0.2,
                'money' => 3000,
                'time' => 10,
                'result' => "Nespokojenost zákazníka.",
                'primary_cause' => "Neprobrani vzhledu aplikace před jeho aplikaci.",
                'trigger' => "",
                'reaction' => "Změna vzhledu.",
                'severity' => 0.5,
                'risk_type_id' => VNITRNI_R,
                'phase_id' => NAVRH_E,
                'resposibleFor_id' => 4,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Platforma nevyhovující zákazníkovi.",
                'description' => "",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Nepřijatý produkt.",
                'primary_cause' => "Neodstatecna konzultace na téma cílové platformy.",
                'trigger' => "",
                'reaction' => "Odsouhlasení platformy zákazníkem.",
                'severity' => 0.9,
                'risk_type_id' => TECHNICKA_R,
                'phase_id' => SPECIFIKACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],

            // plánování

            [
                'name' => "Chybějící činnost v plánu.",
                'description' => "Nezohlednění nezbytné činnosti v časovém a rozpočtovém lánu projektu.",
                'probability' => 0.1,
                'money' => 60000,
                'time' => 60,
                'result' => "Zpoždění realizace.",
                'primary_cause' => "Nedůsledná analýza plánu projektu." ,
                'trigger' => "",
                'reaction' => "Tvoření plánu v celém týmu a zahrnutí každého jeho detailů, myslet dopředu.",
                'severity' => 0.6,
                'risk_type_id' => RIZENI_R,
                'phase_id' => PLANOVANI_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Nedodržování termínu",
                'description' => "Během vývoje aplikace se nestíhá dokončovat v termínech to, co má.",
                'probability' => 0.5,
                'money' => 70000,
                'time' => 70,
                'result' => "Řetězový efekt zpomalení navazujících úkolů.",
                'primary_cause' => "Špatně odhadnuté doby trvání některých úkolů." ,
                'trigger' => "",
                'reaction' => "Pravidelná kontrola stavu a případně řešení zpoždění co nejdříve.",
                'severity' => 0.7,
                'risk_type_id' => RIZENI_R,
                'phase_id' => PLANOVANI_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-05 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Špatně naplánována posloupnost práci.",
                'description' => "Není hotová činnost, která je potřeba být hotová pro započetí činnosti jiné.",
                'probability' => 0.4,
                'money' => 30000,
                'time' => 30,
                'result' => "Části týmu musí čekat, zpoždění.",
                'primary_cause' => "Nepromyšleni nezbytných vstupu pro jednotlivé činnosti.",
                'trigger' => "",
                'reaction' => "Konzultace návaznosti jednotlivých části v rámci celého týmu. Správný odhad trvání části.",
                'severity' => 0.8,
                'risk_type_id' => RIZENI_R,
                'phase_id' => PLANOVANI_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Nedodržení finálního deadlinu projektu.",
                'description' => "Dokončení projektu má zpoždění.",
                'probability' => 0.35,
                'money' => 80000,
                'time' => 80,
                'result' => "Nedodání produktů včas = nespokojenost zákazníka.",
                'primary_cause' => "Chybný odhad délky trvání práce na projektu, neodhaleni možných zdržení." ,
                'trigger' => "",
                'reaction' => "Započítat do odhadů i možná zpoždění, pokud nastane problém, řešit jej včas změnovým řízením.",
                'severity' => 0.9,
                'risk_type_id' => RIZENI_R,
                'phase_id' => PLANOVANI_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],

            // technická realizace

            [
                'name' => "Problémy při instalaci nebo běhu vývojových prostředí.",
                'description' => "Pracovník není schopen pracovat na projektu, protože mu nefunguje vývojové prostředí.",
                'probability' => 0.2,
                'money' => 40000,
                'time' => 40,
                'result' => "Nemožnost práce některých členů, zdržení.",
                'primary_cause' => "Nedostatečné prověření implementačních prostředků, aktualizace atd." ,
                'trigger' => "",
                'reaction' => "Vyhrazení některého člena týmu, který se bude zabývat problémy s vývojovými prostředky, pravidelně aktualizace.",
                'severity' => 0.9,
                'risk_type_id' => TECHNICKA_R,
                'phase_id' => REALIZACE_E,
                'resposibleFor_id' => 1,
                'creator_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Použití neověřených knihoven",
                'description' => "",
                'probability' => 0.1,
                'money' => 60000,
                'time' => 60,
                'result' => "Není zaručen správný výsledek práce.",
                'primary_cause' => "Nenalezení jiných vhodných, ověřených knihoven." ,
                'trigger' => "",
                'reaction' => "Použití pouze ověřených knihoven.",
                'severity' => 0.3,
                'risk_type_id' => TECHNICKA_R,
                'phase_id' => REALIZACE_E,
                'resposibleFor_id' => 4,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Nekomplatibilnost knihoven jednotlivých členů.",
                'description' => "",
                'probability' => 0.4,
                'money' => 20000,
                'time' => 20,
                'result' => "Části produktů nelze pospojovat.",
                'primary_cause' => "Špatná komunikace ohledně používaných knihoven." ,
                'trigger' => "",
                'reaction' => "Dopredna domluva na užitých knihovnách",
                'severity' => 0.2,
                'risk_type_id' => TECHNICKA_R,
                'phase_id' => REALIZACE_E,
                'resposibleFor_id' => 4,
                'creator_id' => 1,
                'start_date' => "2017-03-01 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Přemazáni master branche na verzovacim systému.",
                'description' => "Programátor řešil konflikty při aktualizaci jeho kódu a neudělal to pečlivě.",
                'probability' => 0.1,
                'money' => 90000,
                'time' => 90,
                'result' => "Ztráta funkčních kódu.",
                'primary_cause' => "Nepozornost pracovníka, chybějící záloha." ,
                'trigger' => "",
                'reaction' => "Zálohovat co nejčastěji master branch.",
                'severity' => 0.9,
                'risk_type_id' => TECHNICKA_R,
                'phase_id' => REALIZACE_E,
                'resposibleFor_id' => 4,
                'creator_id' => 1,
                'start_date' => "2017-03-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],

            // externí události

            [
                'name' => "Poškození pracovních strojů přírodním živlem.",
                'description' => "",
                'probability' => 0.05,
                'money' => 100000,
                'time' => 10,
                'result' => "Hmotná škoda a možná ztráta dát.",
                'primary_cause' => "Nepojištěny majetek, nezálohovana data." ,
                'trigger' => "",
                'reaction' => "Zálohovat data a mít pojištěný hmotný majetek firmy.",
                'severity' => 0.8,
                'risk_type_id' => EXTERNI_R,
                'phase_id' => REALIZACE_E,
                'resposibleFor_id' => 2,
                'creator_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Zákazník přeruší smlouvu",
                'description' => "Zákazník odstupuje od dohodnuté smlouvy.",
                'probability' => 0.2,
                'money' => 60000,
                'time' => 60,
                'result' => "Finanční ztráta.",
                'primary_cause' => "Příliš optimistická a nedůsledná smlouva se zákazníkem." ,
                'trigger' => "",
                'reaction' => "Mít ve smlouvě se zákazníkem zahrnuty storno poplatky, které by případně kompenzovaly finanční ztrátu.",
                'severity' => 0.9,
                'risk_type_id' => EXTERNI_R,
                'phase_id' => REALIZACE_E,
                'resposibleFor_id' => 3,
                'creator_id' => 1,
                'start_date' => "2017-02-03 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Nezkušení uživatele koncového systému.",
                'description' => "Uživatele neumí pracovat s produktem, přetrvávají opakující se dotazy na jeho správné používání.",
                'probability' => 0.3,
                'money' => 40000,
                'time' => 50,
                'result' => "Prodlužující se podpora nasazení produktů do provozu.",
                'primary_cause' => "Chybějící domluva na zaškolení." ,
                'trigger' => "",
                'reaction' => "Vypracování kvalitní příručky a provedení zaškolení na úrovni koncových uživatelů.",
                'severity' => 0.4,
                'risk_type_id' => EXTERNI_R,
                'phase_id' => REALIZACE_E,
                'resposibleFor_id' => 3,
                'creator_id' => 1,
                'start_date' => "2017-03-15 08:00:00",
                'end_date' => "2017-05-05 23:59:00",
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];

        $this->insert($this->tableNameRi, $rows);

        //Role
        $rows = [
            [
                'name' => "Administrátor",
                'description' => "Administrátor se stará o správu aplikace.",
                'user_id' => 1,
                'client_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Project manager",
                'description' => "Project manager řídí jednotlivé etapy projektu, kontroluje výstupy každé z nich a je zodpovědný za dodání celého projektu.",
                'user_id' => 2,
                'client_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Majitel",
                'description' => "Vlastník aplikace.",
                'user_id' => 3,
                'client_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Běžný uživatel",
                'description' => "Běžný uživatel aplikace.",
                'user_id' => 4,
                'client_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Běžný uživatel",
                'description' => "Běžný uživatel aplikace.",
                'user_id' => 5,
                'client_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Běžný uživatel",
                'description' => "Běžný uživatel aplikace.",
                'user_id' => 5,
                'client_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'name' => "Běžný uživatel",
                'description' => "Běžný uživatel aplikace.",
                'user_id' => 6,
                'client_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];

        $this->insert($this->tableNameRo, $rows);

        //Users on phase
        $rows = [
            [
                'user_id' => 1,
                'phase_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 1,
                'phase_id' => 2,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 1,
                'phase_id' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 1,
                'phase_id' => 4,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 2,
                'phase_id' => 2,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 3,
                'phase_id' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 3,
                'phase_id' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 6,
                'phase_id' => 3,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 5,
                'phase_id' => 5,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 6,
                'phase_id' => 5,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ]
        ];

        $this->insert($this->tableNameUoPh, $rows);

        //Users on Project
        $rows = [
            [
                'user_id' => 1,
                'project_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 2,
                'project_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 3,
                'project_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 4,
                'project_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 5,
                'project_id' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 6,
                'project_id' => 1,
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
