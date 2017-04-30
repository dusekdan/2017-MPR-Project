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
 * @ORM\Table(name="clients")
 */
class Client
{
	use MagicAccessors; //traita

	/**
	 * ID Clienta
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	protected $id;

    /**
     * Id Company do ktorej Client patri
     * @ORM\Column(name="id_company", type="integer")
     * @var integer
     */

	protected $name;

	/**
	 * Popis klienta
	 * @ORM\Column(type="string",nullable=true)
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



	public function __construct($idCompany, $name ,$description)
    {
        $this->setIdCompany($idCompany);
		$this->setName($name);
		$this->setDescription($description);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
    }

}