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
		if(!$this->user->isAllowed('AdminModule', 'editUser')){
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
			}
		}
	}

	public function renderUpdate()
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
	
	
	public function actionAdd()
	{
		if(!$this->user->isAllowed('AdminModule', 'addUser')){
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
			}
		}
	}
	
	public function renderAdd()
	{
	
	}
	
	public function createComponentAddForm()
	{
		$form = $this->formFactory->add(function (){
			$this->flashMessage("Uživatel byl přidán.", "success");
			$this->showModal = false;
			$this->redirect('User:users');
		});
		
		$form->getElementPrototype()->class('ajax');
		
		return $form;
	}
	
	public function handleChangeEnabled($userId)
	{
		try {
			$user = $this->userFacade->getUser($userId);
			$this->userFacade->changeEnabled($user, true);
			$this->flashMessage("Uživateli s id:{$userId} byla úspěšně změněna aktivita.", "success");
		} catch (\Exception $e) {
			$this->flashMessage("Uživateli s id:{$userId} se nepodařilo změnit aktivitu", "danger");
		}
	}
	
	public function handleDelete($userId)
	{
		try {
			
			if($this->project){
				$user = $this->userFacade->getUser($userId);
				if($user->getRole() === "projectManager"){
					$project = $this->projectFacade->getProject($this->project);
					if($project->getProjectManager() === $user) {
						unset($this->project);
						$this->flashMessage("Uživatel byl manažer zvoleného projektu, ten byl smazán a Vás jsme poslali na obecný přehled", "warning");
					}
						
				}
			}
			$this->userFacade->removeUser($userId, true);
			$this->fileStorage->deleteDirectory($this->fileStorage->getUserDir($userId));
			$this->flashMessage("Uživatel s id:{$userId} byl úspěšně odstraněn.", "success");
			
		} catch (\Exception $e) {
			$this->flashMessage($e->getMessage(), "danger");
		}
		if (!isset($this->project)) {
			$this->redirect('this', ['project' => null]);
		}
	}
}