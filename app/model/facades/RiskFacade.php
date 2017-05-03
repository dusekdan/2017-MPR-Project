<?php
/**
 * Created by PhpStorm.
 * User: František Rožek
 * Date: 2. 5. 2017
 * Time: 19:42
 */

declare(strict_types=1);

namespace App\Model\Facades;

use App\Model\Entities\Risk;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class RiskFacade
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
		$this->repository = $em->getRepository(Risk::class);
	}
	
	/**
	 * Najde a vrátí fáze podle jeho ID.
	 * @param int|NULL $id ID fáze
	 * @return Risk|NULL vrátí entitu rizika nebo NULL pokud riziko nebylo nalezeno
	 */
	public function getRisk($id)
	{
		return $this->repository->find($id);
	}
	
	/**
	 * Najde a vrátí všechna rizika.
	 * @return array Vrátí všechna rizika.
	 */
	public function getRisks()
	{
		return $this->repository->findAll();
	}
	
	/**
	 * Smaže riziko.
	 * @param Risk $risk Riziko ke smazání
	 * @param $autoFlush
	 */
	public function removeRisk($risk, $autoFlush)
	{
		if (!$risk instanceof Risk) {
			$risk = $this->getRisk($risk);
		}
		if ($risk) {
			$this->em->remove($risk);
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}
	
	
	/**
	 * Vytvoří nové riziko se zadanými parametry.
	 */
	public function createRisk($name, $description, $probability, $money, $time, $result, $primaryCause, $trigger, $reaction, $severity, $startDate, $endDate, $riskType, $phase, $responsibleUser, $creator, $autoFlush)
	{
		$risk = new Risk($name, $description, $probability, $money, $time, $result, $primaryCause, $trigger, $reaction, $severity, $startDate, $endDate, $riskType, $phase, $responsibleUser, $creator);
		$this->em->persist($risk);
		if ($autoFlush) {
			$this->em->flush();
		}
	}
	
	/**
	 * Upraví riziko zadanými hodnotami.
	 */
	public function editRisk($values, $riskType, $responsibleUser, $autoFlush)
	{
		
		$startDate = new Nette\Utils\DateTime($values['startDate']);
		$endDate = new Nette\Utils\DateTime($values['endDate']);
		
		$risk = $this->getRisk($values['idRisk']);
		
		$risk->setName($values['name']);
		$risk->setDescription($values['description']);
		$risk->setStartDate($startDate);
		$risk->setEndDate($endDate);
		$risk->setProbability($values['probability']);
		$risk->setTime($values['time']);
		$risk->setMoney($values['money']);
		$risk->setResult($values['result']);
		$risk->setTrigger($values['trigger']);
		$risk->setReaction($values['reaction']);
		$risk->setSeverity($values['severity']);
		$risk->setPrimaryCause($values['primaryCause']);
		
		$risk->setRiskType($riskType);
		$risk->setResponsibleUser($responsibleUser);
		
		$this->em->persist($risk);
		if ($autoFlush) {
			$this->em->flush();
		}
	}
	
}