<?php
/**
 * Created by PhpStorm.
 * User: Fratišek Rožek
 * Date: 3. 5. 2017
 * Time: 21:02
 */

namespace App\Model\Facades;

use App\Model\Entities\UsersOnPhase;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class UsersOnPhaseFacade
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
		$this->repository = $em->getRepository(UsersOnPhase::class);
	}
	
	/**
	 * Najde a vrátí uživatele na fázi podle ID v tabulce.
	 * @param User $user uživatel
	 * @param Phase $phase fáze
	 * @return UsersOnPhase|NULL vrátí entitu uživatele na projektu nebo NULL pokud uživatel nebyl nalezen
	 */
	public function getUserOnPhase($user, $phase)
	{
		return $this->repository->findOneBy(['user' => $user,'phase' => $phase]);
	}
	
	/**
	 * Najde a vrátí uživatele na fázi podle ID v tabulce.
	 * @param User $user uživatel
	 * @param ArrayCollection $phases fáze
	 * @return array vrátí entitu uživatele na projektu nebo NULL pokud uživatel nebyl nalezen
	 */
	public function getUserOnPhases($user, $phases)
	{
		$userOnPhases = [];
		foreach ($phases as $phase){
			if($this->repository->findOneBy(['user' => $user,'phase' => $phase]))
				array_push($userOnPhases, $this->repository->findOneBy(['user' => $user,'phase' => $phase]));
		}
		
		return $userOnPhases;
	}
	
	public function createUserOnPhase($user, $phase, $autoFlush)
	{
		$userOnPhase = new UsersOnPhase($user, $phase, $autoFlush);
		$this->em->persist($userOnPhase);
		if ($autoFlush) {
			$this->em->flush();
		}
	}
	
	public function removeUserOnPhase($user, $phase, $autoFlush)
	{
		$userOnPhase = $this->getUserOnPhase($user, $phase);
		
		if ($userOnPhase) {
			$this->em->remove($userOnPhase);
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}
}