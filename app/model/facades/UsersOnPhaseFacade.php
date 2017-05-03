<?php
/**
 * Created by PhpStorm.
 * User: Fratišek Rožek
 * Date: 3. 5. 2017
 * Time: 21:02
 */

namespace App\Model\Facades;

use App\Model\Entities\UsersOnPhase;
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
	
	public function createUserOnPhase($user, $phase, $autoFlush)
	{
		$userOnPhase = new UsersOnPhase($user, $phase, $autoFlush);
		$this->em->persist($userOnPhase);
		if ($autoFlush) {
			$this->em->flush();
		}
	}
}