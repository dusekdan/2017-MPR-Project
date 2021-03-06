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
 * @ORM\Table(name="roles")
 */
class Role
{
	use MagicAccessors; //traita

	/**
	 * ID Role Uzivatela v Spolocnosti
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	protected $id;


    /**
     * ID Clienta, pre ktoru user pracuje
     * @ORM\Column(name="company_id", type="integer")
     * @var integer
     */
    protected $idClient;



    /**
     * ID Usera, ktoreho sa zaznam tyka
     * @ORM\Column(name="user_id", type="integer")
     * @var integer
     * @Id @ManyToOne(targetEntity="User")
     */
    protected $idUser;


    /**
	 * Nazev role
	 * @ORM\Column(type="string", length=100) //just for now, should be done by enum list
	 * @var string
	 */
	protected $roleName;
	/**
	 * Popis pozicie daneho zamestnanca vo firme
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	protected $description;


    /**
     * Datum vytvorenia zaznamu o riziku
     * @ORM\Column(name"created_", type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu o riziku
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



	public function __construct($idUser,$idCompany, $name ,$description)
	{
        $this->setIdUser($idUser);
		$this->setIdCompany($idCompany);
		$this->setName($name);
		$this->setDescription($description);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
    }

}