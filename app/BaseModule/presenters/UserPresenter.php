<?php

declare(strict_types=1);

namespace App\BaseModule\Presenters;

use App\Model\Facades\UserFacade;
use Nette;
use App\BaseModule\Forms;
use Nette\Security\User;
use Nette\Security\AuthenticationException;
use Tracy\Debugger;

class UserPresenter extends BasePresenter
{
	/** @var Forms\UserFormFactory @inject */
	public $userFactory;

	/** @var UserFacade*/
	private $userFacade;

	/** @var User */
	private $user;

	/** @persistent */
	public $showModal = false;

	/** @persistent */
	public $backlink = '';

	public function __construct(User $user, UserFacade $userFacade)
	{
		$this->user = $user;
		$this->userFacade = $userFacade;
	}

	public function actionSignIn()
	{
		if ($this->isAjax()) {
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				$this->redrawControl("snippetSignIn");
			}
		}
		$this->showModal = true; // přihlášení chci vždy zobrazit
	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->userFactory->signIn();
		$form->onSuccess[] = [$this, 'processSignInForm'];

		return $form;
	}

	public function processSignInForm($form, $values)
	{
		try {
			$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
			$this->user->login($values->username, $values->password);
			$identity = $this->user->getIdentity();
			$this->flashMessage("Byl jste úspěšně přihlášen " . $identity->data['username'] . ".", "success");
			//$this->restoreRequest($this->backlink); //TODO - zatím to neběhá pod AJAXEM asi kvuli payloudu
			$this->redirect(':Admin:Homepage:');
		} catch (AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}

	/**
	 * Sign-up form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
		return $this->userFactory->signUp(function() {
			$this->flashMessage("Byl jste úspěšně zaregistrován.", "success");
			$this->redirect('Homepage:');
		});
	}

	/**
	 * Update form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentUpdateForm()
	{
		return $this->userFactory->update(function() {
			$this->flashMessage("Vyše údaje byly aktualizovány.", "success");
			$this->redirect('User:update');
		}, $this->userFacade->getUser($this->user->getId()));
	}

	/**
	 * Změna hesla
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentChangePassword()
	{
		return $this->userFactory->changePassword(function() {
			$this->flashMessage("Vaše heslo bylo úspěšně změněno.", "success");
		}, $this->userFacade->getUser($this->user->getId()));
	}

	/**
	 * Odhlášení
	 */
	public function actionSignOut()
	{
		$identity = $this->user->getIdentity();
		$this->getUser()->logout();
		$this->flashMessage("Byl jste úspěšně odhlášen " . $identity->data['username'] . ".", "info");
		$this->redirect('Homepage:');
	}

	/**
	 * Ověření zda má oprávnění
	 */
	public function actionUpdate($backlink = '')
	{
		if(!$this->user->isLoggedIn()){
			$this->flashMessage('Nemáte dostatečné oprávnění pro přístup.','danger');
			$this->redirect('Homepage:');
		}
	}
}
