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
 * @ORM\Table(name="phases")
 */
class Phase
{
	use MagicAccessors; //traita

	/**
	 * ID faze
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	protected $id;


    /**
     * ID Projektu, komu faze patri
     * @ORM\Column(name="id_project", type="integer")
     * @var integer
     */
    protected $idProject;



    /**
	 * Nazev faze
	 * @ORM\Column(type="string", length=100)
	 * @var string
	 */
	protected $name;

	/**
	 * Popis faze
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $description;

	/**
	 * Den zacatku faze
	 * @ORM\Column(name"start_date", type="datetime")
     * @var \DateTime
	 */
	protected $startDate;

    /**
     * Den konce faze
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



	public function __construct($idPhase, $name, $description, $startDate, $endDate, $idProjectManager)
	{
		$this->setIdPhase($idPhase);
		$this->setName($name);
		$this->setDescription($description);
		$this->setStartDate($startDate);
		$this->setEndDate($endDate);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
	}

}