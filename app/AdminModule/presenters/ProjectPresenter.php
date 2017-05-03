<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Nette;
use App\Model;
use App\Model\Facades\ProjectFacade;
use App\Model\Facades\UserFacade;
use App\Model\Facades\PhaseFacade;
use App\Model\Facades\RiskFacade;
use App\AdminModule\Forms\ProjectFormFactory;
use Tracy\Debugger;


class ProjectPresenter extends BasePresenter
{
	/** @var ProjectFormFactory */
	private $projectFactory;
	
	/** @var UserFacade */
	private $userFacade;
	
	/** @var PhaseFacade */
	private $phaseFacade;
	
	/** @var RiskFacade */
	private $riskFacade;
	
	public function __construct(ProjectFormFactory $projectFormFactory, UserFacade $userFacade, PhaseFacade $phaseFacade, RiskFacade $riskFacade)
	{
		$this->projectFactory = $projectFormFactory;
		$this->userFacade = $userFacade;
		$this->phaseFacade = $phaseFacade;
		$this->riskFacade = $riskFacade;
	}
	
	public function renderDefault()
	{
		$this->template->users = $this->userFacade->getUsers();
	}
	
	public function actionViewRisk($idRisk)
	{
		
		if ($this->isAjax()) {
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				// snippetem překreslim jen to co je potřeba po odeslání formuláře
				// formulář (pro zobrazeni chyb), vyslednou tabulku po zmene v DB
			}
		}
	}
	
	public function renderViewRisk($idRisk)
	{
		$this->template->risk = $this->riskFacade->getRisk($idRisk);
	}
	
	public function actionAddRisk($phase)
	{
		
		if ($this->isAjax()) {
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				// snippetem překreslim jen to co je potřeba po odeslání formuláře
				// formulář (pro zobrazeni chyb), vyslednou tabulku po zmene v DB
			}
		}
	}
	
	public function renderAddRisk($phase)
	{
	}
	
	/**
	 * Create new risk.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentAddRiskForm()
	{
		$phase = $this->phaseFacade->getPhase($this->getParameter('phase'));
		
		return $this->projectFactory->addRisk(function () {
			$this->flashMessage("Nové riziko úspěšně přidáno.", "success");
			$this->showModal = false; // pokud je to ok, zavřu to
			$this->redirect('Project:default');
		}, $phase, $this->user);
	}
	
	
	public function actionEditRisk($idRisk)
	{
		if ($this->isAjax()) {
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				// snippetem překreslim jen to co je potřeba po odeslání formuláře
				// formulář (pro zobrazeni chyb), vyslednou tabulku po zmene v DB
			}
		}
	}
	
	public function renderEditRisk($idRisk)
	{
	
	}
	
	/**
	 * Edit existing risk.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentEditRiskForm()
	{
		$risk = $this->riskFacade->getRisk($this->getParameter('idRisk'));
		
		return $this->projectFactory->editRisk(function () {
			$this->flashMessage("Riziko bylo úspěšně upraveno.", "success");
			$this->showModal = false; // pokud je to ok, zavřu to
			$this->redirect('Project:default');
		}, $risk);
	}
	
	
	public function actionRemoveRisk($idRisk)
	{
		if ($this->isAjax()) {
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				// snippetem překreslim jen to co je potřeba po odeslání formuláře
				// formulář (pro zobrazeni chyb), vyslednou tabulku po zmene v DB
			}
		}
	}
	
	public function renderRemoveRisk($idRisk)
	{
		$this->template->risk = $this->riskFacade->getRisk($this->getParameter('idRisk'));
	}
	
	/**
	 * Remove existing risk.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentRemoveRiskForm()
	{
		$risk = $this->riskFacade->getRisk($this->getParameter('idRisk'));
		
		return $this->projectFactory->removeRisk(function () {
			$this->flashMessage("Riziko bylo úspěšně odstraněno.", "success");
			$this->showModal = false; // pokud je to ok, zavřu to
			$this->redirect('Project:default');
		}, $risk);
	}
	
	public function actionAddPhase()
	{
		if ($this->isAjax()) {
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				// snippetem překreslim jen to co je potřeba po odeslání formuláře
				// formulář (pro zobrazeni chyb), vyslednou tabulku po zmene v DB
				$this->redrawControl("snippetAddPhase");
			}
		}
	}
	
	public function renderAddPhase()
	{
	
	}
	
	/**
	 * Create new risk.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentAddPhaseForm()
	{
		return $this->projectFactory->addPhase(function () {
			$this->flashMessage("Nová fáze úspěšně přidána.", "success");
			$this->showModal = false; // pokud je to ok, zavřu to
			$this->redirect('Project:default');
		}, $this->project);
	}
	
	public function actionAddUser($phaseId, $projectId)
	{
		if ($this->isAjax()) {
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
			} else {
				// snippetem překreslim jen to co je potřeba po odeslání formuláře
				// formulář (pro zobrazeni chyb), vyslednou tabulku po zmene v DB
				$this->redrawControl("snippetAddPhase");
			}
		}
	}
	
	public function renderAddUser($phaseId, $projectId)
	{
		$this->template->title = "Přidat uživatele";
		debugger::fireLog($this->project);
		if (isset($phaseId)) {
			$this->template->shortTitle = "Přidat uživatele do fáze";
			$this->template->addToPhase = true;
		}
		
		if (isset($projectId)) {
			$this->template->shortTitle = "Přidat uživatele do projektu";
			$this->template->addToProject = true;
		}
	}
	
	public function createComponentAddUserToPhase()
	{
		$caption = 'Přidat uživatele do fáze';
		
		$phase = $this->phaseFacade->getPhase($this->getParameter('phaseId'));
		
		$users = [];
		foreach ($this->userFacade->getUsers() as $oneUser) {
			if (!$phase->getUsers()->contains($oneUser))
				$users[$oneUser->getId()] = $oneUser->getUsername();
		}
		
		$form = $this->projectFactory->addUserProject($users,
			function () {
				$this->flashMessage("Uživatel přidán.", "success");
				$this->redirect('Project:default');
			}, $caption);
		
		return $form;
	}
	
	public function createComponentAddUserToProject()
	{
		$caption = 'Přidat uživatele do projektu';
		$project = $this->projectFacade->getProject($this->project);
		$users = [];
		foreach ($this->userFacade->getUsers() as $oneUser) {
			if (!$project->getUsers()->contains($oneUser))
				$users[$oneUser->getId()] = $oneUser->getUsername();
		}
		
		$form = $this->projectFactory->addUserProject($users,
			function () {
				$this->flashMessage("Uživatel přidán.", "success");
				$this->redirect('Project:default');
			}, $caption);
		
		
		return $form;
	}
	
	public function handleRemoveUser($userId)
	{
		$this->userFacade->removeUser($userId, true);
		$this->flashMessage("Uživatel přidán s id $userId byl smazán.", "success");
	}
	
}
