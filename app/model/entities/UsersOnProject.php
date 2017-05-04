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
 * @ORM\Table(name="users_on_projects")
 */
class UsersOnProject
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
     * Id projektu na ktorom user pracuje
     * @ORM\ManyToOne(targetEntity="Project")
     */
    protected $project;



    /**
     * ID Usera, ktoreho sa zaznam tyka
     * @ORM\Column(name="user_id", type="integer")
     * @var integer
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;


    /**
     * Datum vytvorenia zaznamu
     * @ORM\Column(name="created", type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu
     * @ORM\Column(name="updated", type="datetime")
     * @var \DateTime
     */
    protected $updated;


    /**
     * Enabled, moznost pracovat so zaznamom
     * @ORM\Column(type="boolean", options={"default"=true})
     * @var boolean
     */
    protected  $enabled;



	public function __construct($user,$project)
	{
        $this->setIdUser($user);
		$this->setIdProject($project);
		$this->setEnabled(true);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
    }

}