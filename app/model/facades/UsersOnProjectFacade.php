<?php
/**
 * Created by PhpStorm.
 * User: Fratišek Rožek
 * Date: 3. 5. 2017
 * Time: 21:02
 */

namespace App\Model\Facades;

use App\Model\Entities\Project;
use App\Model\Entities\User;
use App\Model\Entities\UsersOnProject;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class UsersOnProjectFacade
{
	use Nette\SmartObject;
	
	/** @var EntityManager Manager pro práci s entitami. */
	private $em;
	
	private $repository;
	
	/** @var  UsersOnPhaseFacade */
	private $usersOnPhaseFacade;
	/**
	 * Konstruktor s injektovanou třídou pro práci s entitami.
	 * @param EntityManager $em automaticky injektovaná třída pro práci s entitami
	 */
	public function __construct(EntityManager $em, UsersOnPhaseFacade $usersOnPhaseFacade)
	{
		$this->em = $em;
		$this->repository = $em->getRepository(UsersOnProject::class);
		$this->usersOnPhaseFacade = $usersOnPhaseFacade;
	}
	
	/**
	 * Najde a vrátí uživatele na projektu podle ID v tabulce.
	 * @param User $user uživatel
	 * @param Project $project projekt
	 * @return UsersOnProject|NULL vrátí entitu uživatele na projektu nebo NULL pokud uživatel nebyl nalezen
	 */
	public function getUserOnProject($user, $project)
	{
		return $this->repository->findOneBy(['user'=>$user, 'project'=>$project]);
	}
	
	/**
	 * Najde a vrátí id uživatelů přiřazených k projektu.
	 * @param Project $project projekt
	 * @return ArrayCollection vrátí pole uživatelů na projektu
	 */
	public function getUsersOnProject($project)
	{
		return $this->repository->findBy(['project'=>$project]);
	}
	
	public function createUserOnProject($user, $project, $autoFlush)
	{
		$userOnProject = new UsersOnProject($user, $project, $autoFlush);
		$this->em->persist($userOnProject);
		if ($autoFlush) {
			$this->em->flush();
		}
	}
	
	public function removeUserOnProject($user, $project, $userOnPhases, $autoFlush)
	{
		$userOnProject = $this->getUserOnProject($user, $project);
		foreach ($userOnPhases as $userOnPhase){
			$this->usersOnPhaseFacade->removeUserOnPhase($userOnPhase->user, $userOnPhase->phase, true);
		}
		
		if ($userOnProject) {
			$this->em->remove($userOnProject);
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}
}