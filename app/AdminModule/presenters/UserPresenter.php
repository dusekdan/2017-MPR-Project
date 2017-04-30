<?php
/**
 * Created by PhpStorm.
 * User: pick
 * Date: 14.02.2017
 * Time: 20:51
 */

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Components\FileStorage;

use Nette\Security\User;

use App\Model\Facades\UserFacade;
use App\AdminModule\Forms\UserFormFactory;
use Tracy\Debugger;
use Nette;

class UserPresenter extends BasePresenter
{
	/** @var User */
	private $user;

	/**
	 * @var UserFacade Fasáda pro manipulaci s uživateli.
	 * @inject
	 */
	public $userFacade;

	/** @var UserFormFactory */
	private $formFactory;

	/** @var  FileStorage */
	private $fileStorage;

	/** @persistent */
	public $showModal = false;

	public function __construct(User $user, UserFormFactory $userFormFactory, FileStorage $fileStorage)
	{
		$this->user = $user;
		$this->formFactory = $userFormFactory;
		$this->fileStorage = $fileStorage;
	}

	public function actionUsers()
	{
	}

	public function renderUsers()
	{
		$this->template->users = $this->userFacade->getUsers();
	}

	public function actionUpdate($userId)
	{
		if(!$this->user->isAllowed('AdminModule', 'updateUsers')){
			$this->flashMessage('Nemáte dostatečné oprávnění pro úpravu uživatelů.','danger');
			$this->redirect('User:users');
		}

		if ($this->isAjax()) {
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				$this->redrawControl("snippetUpdate");
				$this->redrawControl("snippetUsers");
			}
		}
	}

	public function renderUpdate($userId)
	{

	}

	public function createComponentUpdateForm($name)
	{
		$userId = $this->getParameter('userId');
		if (isset($userId)) {
			$user = $this->userFacade->getUser($userId);
		} else {
			$user = $this->userFacade->getUser($this->user->id);
		}

		$form = $this->formFactory->update(function ($user){
			$this->flashMessage("Údaje uživatele {$user->username} byly aktualizovány.", "success");
			$this->showModal = false;
			$this->redirect('User:users');
		}, $user);

		return $form;
	}

	public function handleDelete($userId)
	{
		try {
			$this->userFacade->removeUser($userId, true);
			$this->fileStorage->deleteDirectory($this->fileStorage->getUserDir($userId));
			$this->flashMessage("Uživatel s id:{$userId} byl úspěšně odstraněn.", "success");
		} catch (\Exception $e) {
			$this->flashMessage($e->getMessage(), "danger");
		}
	}
}