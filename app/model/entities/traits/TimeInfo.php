<?php
/**
 * Created by PhpStorm.
 * User: pick
 * Date: 21.02.2017
 * Time: 23:58
 */

declare(strict_types=1);

namespace App\Model\Entities\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tratira pro časové informace
 * @ORM\HasLifecycleCallbacks
 */
trait TimeInfo
{

	/** @ORM\Column(type="datetime") */
	private $created;

	/** @ORM\Column(name="last_update", type="datetime") */
	private $lastUpdate;


	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function setTimeDate()
	{
		if ($this->getCreated() == null) {
			$this->setCreated(new \DateTime());
		}

		$this->setLastUpdate(new \DateTime());
	}
}