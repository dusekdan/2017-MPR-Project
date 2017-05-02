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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Model\Entities\Project;
use App\Model\Entities\Risk;
use Kdyby\Doctrine\Entities\MagicAccessors;

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
	 * @ORM\Column(name="start_date", type="datetime")
     * @var \DateTime
	 */
	protected $startDate;

    /**
     * Den konce faze
     * @ORM\Column(name="end_date", type="datetime")
     * @var \DateTime
     */
    protected $endDate;

    /**
     * Datum vytvorenia zaznamu o projekte
     * @ORM\Column(name="created", type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu o projekte
     * @ORM\Column(name="updated", type="datetime")
     * @var \DateTime
     */
    protected $updated;


    /**
     * Enabled, moznost pracovat so zaznamom
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $enabled;

	/**
	 * Rizika k dané fazi
	 * @ORM\OneToMany(targetEntity="Risk", mappedBy="phase")
	 * @var Risk[]|Collection
	 */
	protected $risks;

	/**
	 * Uživatelé k dané fazi
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="phases")
	 * @ORM\JoinTable(name="users_on_phases")
	 * @var User[]|Collection
	 */
	protected $users;

	/**
	 * Projekt, komu faze patri
	 * @ORM\ManyToOne(targetEntity="Project", inversedBy="phases")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
	 */
	protected $project;

	public function __construct($name, $description, $startDate, $endDate, $idProject)
	{

		$this->setName($name);
		$this->setDescription($description);
		$this->setStartDate($startDate);
		$this->setEndDate($endDate);
		$this->setProject($idProject);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
		$this->setEnabled(true);

		$this->risks = new ArrayCollection();
		$this->users = new ArrayCollection();
	}
}