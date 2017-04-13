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
 * @ORM\Table(name="companies")
 */
class Company
{
	use MagicAccessors; //traita

	/**
	 * ID Ccompany
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	protected $id;

    /**
	 * Nazev firmy
	 * @ORM\Column(type="string", length=100)
	 * @var string
	 */
	protected $name;

	/**
	 * Popis firmy
	 * @ORM\Column(type="string")
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



	public function __construct($name ,$description)
    {
		$this->setName($name);
		$this->setDescription($description);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
    }

}