<?php
/**
 * Created by PhpStorm.
 * User: František Rožek
 * Date: 3. 5. 2017
 * Time: 1:53
 */

declare(strict_types=1);

namespace App\Model\Facades;

use App\Model\Entities\RiskType;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class RiskTypeFacade
{
	use Nette\SmartObject;
	
	/** @var EntityManager Manager pro práci s entitami. */
	private $em;
	
	private $repository;
	
	/**
	 * Konstruktor s injektovanou třídou pro práci s entitami.
	 * @param EntityManager $em automaticky injektovaná třída pro práci s entitami
	 */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->repository = $em->getRepository(RiskType::class);
	}
	
	/**
	 * Najde a vrátí typ rizika podle jeho ID.
	 * @param int|NULL $id ID typu rizika
	 * @return RiskType|NULL vrátí entitu RiskType nebo NULL pokud typ rizika nebyl nalezen
	 */
	public function getRiskType($id)
	{
		return $this->repository->find($id);
	}
	
	/**
	 * @return array vrátí všechny typy rizik
	 */
	public function getRiskTypes()
	{
		return $this->repository->findAll();
	}
	
	/**
	 * Smaže typ rizika.
	 * @param RiskType $riskType typ rizika
	 * @param $autoFlush
	 */
	public function removeRiskType($riskType, $autoFlush)
	{
		if (!$riskType instanceof RiskType) {
			$riskType = $this->getRiskType($riskType);
		}
		if ($riskType) {
			$this->em->remove($riskType);
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}
	
	/**
	 * Vytvoří nový typ rizika.
	 * @param string $name Název typu rizika
	 * @param string $description Popis typu rizika.
	 * @param $autoFlush
	 */
	public function createRiskType($name, $description, $autoFlush)
	{
		$riskType = new RiskType($name, $description);
		$this->em->persist($riskType);
		if ($autoFlush) {
			$this->em->flush();
		}
	}
}