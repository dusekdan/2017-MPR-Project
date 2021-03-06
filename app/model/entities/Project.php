<?php
/**
 * Created by PhpStorm.
 * User: zuz
 * Date: 13.04.2017
 * Time: 1:14
 */
declare(strict_types=1);

namespace App\Model\Entities;

use App\Model\Entities\Traits\TimeInfo;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 * @ORM\Table(name="projects")
 */
class Project
{
	use MagicAccessors; //traita

	/**
	 * ID uživatele
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	protected $id;


    /**
     * ID Clienta, komu Projekt patri
     * @ORM\OneToOne(targetEntity="Client", inversedBy="project")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;



    /**
	 * Nazev projektu
	 * @ORM\Column(type="string", length=100, unique=true)
	 * @var string
	 */


	protected $name;

	/**
	 * Popis projektu
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $description;

	/**
	 * Den zacatku projektu
	 * @ORM\Column(name="start_date", type="datetime")
     * @var DateTime
	 */
	protected $startDate;

    /**
     * Den konce projektu
     * @ORM\Column(name="end_date", type="datetime")
     * @var DateTime
     */
    protected $endDate;

    /**
     * Datum vytvorenia zaznamu o projekte
     * @ORM\Column(name="created", type="datetime")
     * @var DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu o projekte
     * @ORM\Column(name="updated", type="datetime")
     * @var DateTime
     */
    protected $updated;


    /**
     * Enabled, moznost pracovat so zaznamom
     * @ORM\Column(type="boolean", options={"default"=true})
     * @var boolean
     */
    protected  $enabled;

    /**
     * Id usera ako manazera projektu
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
     * @ORM\JoinColumn(name="project_manager_id", referencedColumnName="id")
     */
    protected $projectManager;

	/**
	 * Fáze
	 * @ORM\OneToMany(targetEntity="Phase", mappedBy="project")
	 */
    protected $phases;

	/**
	 * Uživatelé k danému projektu
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="projects")
	 * @ORM\JoinTable(name="users_on_projects")
	 * @var User[]|Collection
	 */
	protected $users;


	public function __construct($client, $name, $description, $startDate, $endDate, $projectManager)
	{
		$this->setClient($client);
		$this->setName($name);
		$this->setDescription($description);
		$this->setStartDate($startDate);
		$this->setEndDate($endDate);
		$this->setUpdated(new DateTime('now'));
		$this->setCreated(new DateTime('now'));
	    $this->setProjectManager($projectManager);
	    $this->setEnabled(true);

	    $this->phases = new ArrayCollection();
	    $this->users = new ArrayCollection();
	}


	public function setStartDate($startDate)
	{
		if (!$startDate instanceof DateTime) {
			$this->startDate = new DateTime($startDate);
		} else {
			$this->startDate = $startDate;
		}
	}
}