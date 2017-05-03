<?php
/**
 * Created by PhpStorm for spravaRizik.
 * User: Karel Píč
 * Date: 2.05.2017
 * Time: 16:00
 */

declare(strict_types=1);

namespace App\Model\Facades;

use App\Model\Entities\Phase;
use App\Model\Entities\Project;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class PhaseFacade
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
		$this->repository = $em->getRepository(Phase::class);
	}

	/**
	 * Najde a vrátí fáze podle jeho ID.
	 * @param int|NULL $id ID fáze
	 * @return User|NULL vrátí entitu uživatele nebo NULL pokud fáze nebyla nalezena
	 */
	public function getPhase($id)
	{
		return $this->repository->find($id);
	}

	public function getPhases()
	{
		return $this->repository->findAll();
	}

	public function getPhasesByProject($project)
	{
		return $this->repository->findBy(array('project' => $project));
	}

	public function removePhase($phase, $autoFlush)
	{
		if (!$phase instanceof Phase) {
			$phase = $this->getPhase($phase);
		}
		if ($phase) {
			$this->em->remove($phase);
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}

	public function createPhase($name, $description, $startDate, $endDate, Project $project, $autoFlush)
	{
		$phase = new Phase($name, $description, $startDate, $endDate, $project);
		$this->em->persist($phase);
		if ($autoFlush) {
			$this->em->flush();
		}
	}
}