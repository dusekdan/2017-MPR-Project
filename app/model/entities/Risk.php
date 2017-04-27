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
 * @ORM\Table(name="risks")
 */
class Risk
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
     * ID Faze, ktorej riziko patri
     * @ORM\Column(name="id_phase", type="integer")
     * @var integer
     * @Id @ManyToOne(targetEntity="Phase")
     */
    protected $idPhase;

    /**
     * ID Typu rizika, ktoremu riziko patri
     * @ORM\Column(name="id_risk_type", type="integer")
     * @var integer
     * @Id @ManyToOne(targetEntity="Risk")
     */
    protected $idRiskType;



    /**
	 * Nazev rizika
	 * @ORM\Column(type="string", length=100)
	 * @var string
	 */
	protected $name;

	/**
	 * Popis rizika
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $description;


    /**
     * Datum vytvorenia zaznamu o riziku
     * @ORM\Column(name"created_at", type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu o riziku
     * @ORM\Column(name"updated_at", type="datetime")
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
     * Id usera zodpovedneho za riziko
     * @ORM\Column(type="integer")
     * @var integer
     * @Id @ManyToOne(targetEntity="User")
     */
    protected $idResponsibleUser;

    /**
     * Id usera zodpovedneho za riziko
     * @ORM\Column(name="id_resposible_user", type="integer")
     * @var integer
     * @Id @ManyToOne(targetEntity="User")
     */
    protected $idCreator;

    /**
     * Pravdepodobnost rizika
     * @ORM\Column(name="id_creator",type="float")
     * @var float
     */
    protected $probability;

    /**
     * Mnozstvo financi ovplyvnenych rizikom
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $money;

    /**
     * Cas v hodinach(dnoch/tyzdnoch?), o ktory bude projekt opozdeny, kvoli riziku
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $time;

    /**
     * Vysledok rizika
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $result;

    /**
     * Zavaznost rizika
     * @ORM\Column(type="integer")
     * @var string
     */
    protected $severity;
    /**
     * Prvotna pricina rizika
     * @ORM\Column(name="primary_cause",type="string",length=100)
     * @var string
     */
    protected $primaryCause;
    /**
     * Spustac rizika
     * @ORM\Column(type="string"length=100)
     * @var string
     */
    protected $trigger;
    /**
     * Reakcia/Opatrenie rizika
     * @ORM\Column(type="string",length=100)
     * @var string
     */
    protected $reaction;



    public function __construct($idPhase, $idRiskType, $name ,$description, $probability,$money,$time,$result,$severity,$primaryCause,$trigger,$reaction)
	{
		$this->setIdPhase($idPhase);
		$this->setIdRiskType($idRiskType);
		$this->setName($name);
		$this->setDescription($description);
		$this->setProbability($probability);
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
	    $this->setMoney($money);
        $this->setTime($time);
        $this->setResult($result);
        $this->setSeverity($severity);
        $this->setPrimaCause($primaryCause);
        $this->setTrigger($trigger);
        $this->setReaction($reaction);
    }

}