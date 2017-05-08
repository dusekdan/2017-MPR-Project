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
     * @ORM\ManyToOne(targetEntity="Phase")
     * @ORM\JoinColumn(name="phase_id", referencedColumnName="id")
     */
    protected $phase;

    /**
     * ID Typu rizika, ktoremu riziko patri
     * @ORM\ManyToOne(targetEntity="RiskType")
     * @ORM\JoinColumn(name="risk_type_id", referencedColumnName="id")
     */
    protected $riskType;



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
     * Den zacatku risku
     * @ORM\Column(name="start_date", type="datetime")
     * @var \DateTime
     */
    protected $startDate;

    /**
     * Den konce risku
     * @ORM\Column(name="end_date", type="datetime")
     * @var \DateTime
     */
    protected $endDate;
    /**
     * Datum vytvorenia zaznamu o riziku
     * @ORM\Column(name="created", type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Datum posledneho update zaznamu o riziku
     * @ORM\Column(name="updated", type="datetime")
     * @var \DateTime
     */
    protected $updated;


    /**
     * Enabled, moznost pracovat so zaznamom
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected  $enabled;

    /**
     * Id usera zodpovedneho za riziko
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="resposibleFor_id", referencedColumnName="id")
     */
    protected $responsibleUser;

    /**
     * Id usera zodpovedneho za riziko
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    protected $creator;

    /**
     * Pravdepodobnost rizika
     * @ORM\Column(name="probability", type="float")
     * @var float
     */
    protected $probability;

    /**
     * Mnozstvo financi ovplyvnenych rizikom
     * @ORM\Column(name="money", type="integer")
     * @var integer
     */
    protected $money;

    /**
     * Cas v hodinach(dnoch/tyzdnoch?), o ktory bude projekt opozdeny, kvoli riziku
     * @ORM\Column(name="`time`", type="integer")
     * @var integer
     */
    protected $time;

    /**
     * Vysledok rizika
     * @ORM\Column(name="result", type="string", length=100)
     * @var string
     */
    protected $result;

    /**
     * Zavaznost rizika
     * @ORM\Column(name="severity", type="float")
     * @var string
     */
    protected $severity;

    /**
     * Prvotna pricina rizika
     * @ORM\Column(name="primary_cause", type="string", length=100)
     * @var string
     */
    protected $primaryCause;

    /**
     * Spustac rizika
     * @ORM\Column(name="`trigger`", type="string", length=100)
     * @var string
     */
    protected $trigger;

    /**
     * Reakcia/Opatrenie rizika
     * @ORM\Column(name="reaction", type="string", length=300)
     * @var string
     */
    protected $reaction;



    public function __construct($name, $description, $probability, $money, $time, $result, $primaryCause, $trigger, $reaction, $severity, $startDate, $endDate, $riskTypeId, $phaseId, $responsibleUserId, $creatorId)
	{
		$this->setName($name);
		$this->setDescription($description);
		$this->setProbability($probability);
	    $this->setMoney($money);
        $this->setTime($time);
        $this->setResult($result);
        $this->setPrimaryCause($primaryCause);
        $this->setTrigger($trigger);
        $this->setReaction($reaction);
		$this->setSeverity($severity);
		$this->setStartDate($startDate);
		$this->setEndDate($endDate);
		$this->setRiskType($riskTypeId);
		$this->setPhase($phaseId);
		$this->setResponsibleUser($responsibleUserId);
		$this->setCreator($creatorId);
		
		$this->setUpdated(new \DateTime('now'));
		$this->setCreated(new \DateTime('now'));
		$this->setEnabled(true);
    }

}