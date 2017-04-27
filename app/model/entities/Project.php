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
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;
//use Nette\Security\Passwords;

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
     * @ORM\Column(name="id_client", type="integer")
     * @var integer
     * @Id @ManyToOne(targetEntity="Client")
     */
    protected $idClient;



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
	 * @ORM\Column(name"start_date", type="datetime")
     * @var \DateTime
	 */
	protected $startDate;

    /**
     * Den konce projektu
     * @ORM\Column(name"end_date", type="datetime")
     * @var \DateTime
     */
    protected $endDate;

    /**
     * Datum vytvorenia zaznamu o projekte
     * @ORM\Column(name"created_", type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu o projekte
     * @ORM\Column(name"updatedt", type="datetime")
     * @var \DateTime
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
     * @ORM\Column(type="integer")
     * @Id @ManyToOne(targetEntity="User")
     */
    protected $idProjectManager;


	public function __construct($idClient, $name, $description, $startDate, $endDate, $idProjectManager)
	{
		$this->setIdClient($idClient);
		$this->setName($name);
		$this->setDescription($description);
		$this->setStartDate($startDate);
		$this->setEndDate($endDate);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
	    $this->setIdProjectManager($idProjectManager);
	}

}