<?php
/**
 * Created by PhpStorm.
 * User: pick
 * Date: 17.02.2017
 * Time: 0:14
 */

declare(strict_types=1);

namespace App\Model\Entities;

use App\Model\Entities\Traits\TimeInfo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;
use Nette\Security\Passwords;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
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
	 * Přezdívka - login
	 * @ORM\Column(type="string", length=30, unique=true)
	 * @var string
	 */


	protected $username;

	/**
	 * Heslo
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $password;

	/**
	 * Email
	 * @ORM\Column(type="string", length=100, unique=true)
	 */
	protected $email;

	/**
	 * Jméno
	 * @ORM\Column(name="first_name", type="string", length=30)
	 * @var string
	 */
	protected $firstName;

	/**
	 * Příjmení
	 * @ORM\Column(name="last_name", type="string", length=30)
	 * @var string
	 */
	protected $lastName;

	/**
	 * Datum narození
	 * @ORM\Column(type="date", nullable=true)
	 * @var \DateTime
	 */
	protected $birthday;

	/**
	 * Telefonní číslo
	 * @ORM\Column(type="string", length=13, nullable=true)
	 * @var string
	 */
	protected $phone;

	/**
	 * Role oprávnění
	 * @ORM\Column(type="string", length=30)
	 * @var string
	 */
	protected $role;

	/**
	 * Datum vytvoření uživatele
	 * @ORM\Column(type="datetime")
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * Datum vytvoření uživatele
	 * @ORM\Column(type="datetime")
	 * @var \DateTime
	 */
	protected $updated;

	/**
	 * Čas posledního přihlášení
	 * @ORM\Column(name="last_sign", type="datetime", nullable=true)
	 * @var \DateTime
	 */
	protected $lastSign;

	/**
	 * Profilová fotka
	 * @ORM\Column(name="has_photo", type="boolean", options={"default"=false})
	 * @var boolean
	 */
	protected $hasPhoto;

    /**
     * Enabled, moznost pracovat so zaznamom
     * @ORM\Column(type="boolean", options={"default"=true})
     * @var boolean
     */
    protected  $enabled;

	/**
	 * Uživatelé k dané fazi
	 * @ORM\ManyToMany(targetEntity="Phase", mappedBy="users")
	 * @var Phase[]|ArrayCollection
	 */
	protected $phases;

	/**
	 * Uživatelé k daným projektům
	 * @ORM\ManyToMany(targetEntity="Project", mappedBy="users")
	 * @var Project[]|ArrayCollection
	 */
	protected $projects;

	/**
	 * Projekty kterých je manager
	 * @ORM\OneToMany(targetEntity="Project", mappedBy="projectManager")
	 */
	protected $project;

	/**
	 * @var array roleList
	 */
	static private $roleList = [
		'user' => 'Uživatel',
		'administrator' => 'Administrátor',
		'projectManager' => 'Projektový manažer',
        'owner' => 'Majitel spoločnosti'
	];


	public function __construct($username, $password, $email, $firstName, $lastName, $birthday, $phone, $role)
	{
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setEmail($email);
		$this->setFirstName($firstName);
		$this->setLastName($lastName);
		$this->setBirthday($birthday);
		$this->setPhone($phone);
		$role ? $this->setRole($role) : $this->setRole();
		$this->setCreated(new \DateTime('now'));
        $this->setUpdated(new \DateTime('now'));
        $this->setHasPhoto(false);
        $this->setEnabled(true);

        $this->phases = new ArrayCollection();
        $this->projects = new ArrayCollection();
	}

	/**
	 * @param $password
	 */
	public function setPassword($password)
	{
		$this->password = Passwords::hash($password);
	}

	public function setBirthday($birthday) {
		$this->birthday = (!empty($birthday)) ? new \DateTime($birthday) : NULL;
	}

	public function setRole($role = 'user') {
		$this->role = $role;
	}

	public static function getRoleList()
	{
		return self::$roleList;
	}
}