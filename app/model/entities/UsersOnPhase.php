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
 * @ORM\Table(name="users_on_phases")
 */
class UsersOnPhase
{
	use MagicAccessors; //traita

	/**
	 * ID zaznamu
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	protected $id;


    /**
     * Id faze na ktorom user pracuje
     * @ORM\ManyToOne(targetEntity="Project")
     */
    protected $phase;



    /**
     * ID Usera, ktoreho sa zaznam tyka
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;


    /**
     * Datum vytvorenia zaznamu
     * @ORM\Column(name"created", type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu
     * @ORM\Column(name"updated", type="datetime")
     * @var \DateTime
     */
    protected $updated;


    /**
     * Enabled, moznost pracovat so zaznamom
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected  $enabled;



	public function __construct($user, $phase)
	{
        $this->setUser($user);
		$this->setPhase($phase);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
    }

}