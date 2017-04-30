<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Karel Píč
 * Date: 23.02.2017
 * Time: 0:26
 */

declare(strict_types=1);

namespace App\Model\Facades;

use App\Model\Entities\Project;
use Kdyby\Doctrine\EntityManager;
use Nette\Security\Passwords;
use Nette;
use Tracy\Debugger;

class ProjectFacade
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
		$this->repository = $em->getRepository(Project::class);
	}

	/**
	 * Najde a vrátí uživatele podle jeho ID.
	 * @param int|NULL $id ID uživatele
	 * @return User|NULL vrátí entitu uživatele nebo NULL pokud uživatel nebyl nalezen
	 */
	public function getProject($id)
	{
		return $this->repository->find($id);
	}

	public function getProjects()
	{
		return $this->repository->findAll();
	}


	public function removeProject($project, $autoFlush)
	{
		if (!$project instanceof Project) {
			$project = $this->getProject($project);
		}
		if ($project) {
			$this->em->remove($project);
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}
}