<?php
/**
 * Created by PhpStorm for my_nette_project.
 * User: Karel Píč
 * Date: 23.02.2017
 * Time: 22:33
 */

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\Identity;
use Nette\Security\Passwords;
use Nette\Security\AuthenticationException;

use App\Model\Facades\UserFacade;


class Authentication implements Nette\Security\IAuthenticator
{
	use Nette\SmartObject;

	/**
	 * Repozitář
	 * @var UserFacade userFacade
	 */
	private $userFacade;

	public function __construct(UserFacade $userFacade)
	{
		$this->userFacade = $userFacade;
	}

	/**
	 * Performs an authentication.
	 * @return Identity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$user = $this->userFacade->getUserByName($username);
		if (!$user) {
			throw new AuthenticationException('Uživatelské jméno je špatně zapsané.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $user->getPassword())) {
			throw new AuthenticationException('Heslo je špatně zapsané.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($user->getPassword())) {
			$user->setPassword(Passwords::hash($password));
		}

		// uložení kdy byl naposled přihlášen
		$this->userFacade->setLastSign($user, TRUE);


		return new Identity($user->getId(), $user->getRole(), $this->userFacade->getIdentityData($user));
	}
}