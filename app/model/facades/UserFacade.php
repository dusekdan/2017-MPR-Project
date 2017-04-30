<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Karel Píč
 * Date: 23.02.2017
 * Time: 0:26
 */

declare(strict_types=1);

namespace App\Model\Facades;

use App\Model\Entities\User;
use Kdyby\Doctrine\EntityManager;
use Nette\Security\Passwords;
use Nette;
use Tracy\Debugger;

class UserFacade
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
		$this->repository = $em->getRepository(User::class); //TODO Náročná operace na konstruktor - asi přes funkci setRepository a ověřovat zda je nastavena a pokud ne, tak nastavit
	}

	/**
	 * Najde a vrátí uživatele podle jeho ID.
	 * @param int|NULL $id ID uživatele
	 * @return User|NULL vrátí entitu uživatele nebo NULL pokud uživatel nebyl nalezen
	 */
	public function getUser($id)
	{
		return $this->repository->find($id);
	}

	public function getUsers()
	{
		return $this->repository->findAll();
	}

	public function getUserByName($username)
	{
		return $this->repository->findOneBy(['username' => $username]);
	}

	public function getUserByEmail($email)
	{
		return $this->repository->findOneBy(['email' => $email]);
	}

	/**
	 * Načtení nové identity
	 * @param $id
	 * @return Identity
	 */
	public function getIdentity($id)
	{
		$user = $this->getUser($id);

		return new Nette\Security\Identity($user->getId(), $user->getRole(), $this->getIdentityData($user));
	}

	/**
	 * Data pro Identitu
	 * @param $user User nebo id
	 * @return mixed
	 */
	public function getIdentityData($user)
	{
		if (!$user instanceof User) {
			$user = $this->getUser($user);
		}

		return (object)['username' => $user->getUsername(), 'email' => $user->getEmail(), 'firstName' => $user->getFirstName(), 'lastName' => $user->getLastName(), 'hasPhoto' => $user->getHasPhoto(), 'allRoles' => $user->getRoleList()];
	}

	public function setPassword($user, $oldPassword, $newPassword)
	{
		if (!Passwords::verify($oldPassword, $user->getPassword())) {
			throw new Nette\Security\AuthenticationException('Heslo je špatně zapsané.', self::INVALID_CREDENTIAL);
		}
		$user->setPassword($newPassword);
	}

	public function removeUser($user, $autoFlush)
	{
		if (!$user instanceof User) {
			$user = $this->getUser($user);
		}
		if ($user) {
			$this->em->remove($user);
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}

	public function setLastSign($user, $autoFlush)
	{
		if (!$user instanceof User) {
			$user = $this->getUser($user);
		}
		if ($user) {
			$user->setLastSign(new \DateTime("now"));
			if ($autoFlush) {
				$this->em->flush();
			}
		}
	}
}