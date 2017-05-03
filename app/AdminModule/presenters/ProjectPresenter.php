<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

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
	
	/** @persistent */
	public $actualPhase;
	
	/** @persistent */
	public $actualRisk;

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

	public function actionAddRisk()
	{

		if ($this->isAjax()) {
			debugger::fireLog("modal");
			$this->payload->isModal = true;
			//pokud je modal zobrazen překresluju už jen formulář
			if ($this->showModal == false) {
				$this->redrawControl("modal");
				$this->showModal = true;
				debugger::fireLog("modal");
			} else {
				// snippetem překreslim jen to co je potřeba po odeslání formuláře
				// formulář (pro zobrazeni chyb), vyslednou tabulku po zmene v DB
			}
		}
	}

    public function renderAddRisk($phase)
    {
    	if (isset($phase)) {
		    $this->actualPhase = $phase;
	    }
    }

    /**
     * Create new risk.
     * @return Nette\Application\UI\Form
     */
    public function createComponentAddRiskForm()
    {
        $phase = $this->phaseFacade->getPhase($this->actualPhase);
        
    	return $this->projectFactory->addRisk(function() {
            $this->flashMessage("Nové riziko úspěšně přidáno.", "success");
	        $this->showModal = false; // pokud je to ok, zavřu to
	        $this->redirect('Project:default');
        }, $phase, $this->user);
    }


    public function actionEditRisk()
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

    public function renderEditRisk($idRisk){
    	
	    if (isset($idRisk)) {
		    $this->actualRisk = $idRisk;
	    }
    }

    /**
     * Edit existing risk.
     * @return Nette\Application\UI\Form
     */
    public function createComponentEditRiskForm()
    {
	    $risk = $this->riskFacade->getRisk($this->actualRisk);
    	
        return $this->projectFactory->editRisk(function() {
            $this->flashMessage("Riziko bylo úspěšně upraveno.", "success");
	        $this->showModal = false; // pokud je to ok, zavřu to
	        $this->redirect('Project:default');
        }, $risk);
    }
	
	
	public function actionRemoveRisk()
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
 
	public function renderRemoveRisk($idRisk){
		if (isset($idRisk)) {
			$this->actualRisk = $idRisk;
		}
		
		$this->template->risk = $this->riskFacade->getRisk($this->actualRisk);
	}
	
	/**
	 * Remove existing risk.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentRemoveRiskForm()
	{
		$risk = $this->riskFacade->getRisk($this->actualRisk);
		
		return $this->projectFactory->removeRisk(function() {
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
        return $this->projectFactory->addPhase(function() {
            $this->flashMessage("Nová fáze úspěšně přidána.", "success");
	        $this->showModal = false; // pokud je to ok, zavřu to
            $this->redirect('Project:default');
        }, $this->project);
    }

    public function createComponentAddUserPhase()
    {
    	$form = $this->projectFactory->addUserProject($this->project,
		    function() {
			    $this->flashMessage("Uživatel přidán.", "success");
			    $this->redirect('this');
		    });
    	$form['send']->caption = "Přidat uživatele do fáze";

    	return $form;
    }

	public function createComponentAddUserProject()
	{
		$form = $this->projectFactory->addUserProject($this->project,
			function() {
				$this->flashMessage("Uživatel přidán.", "success");
				$this->redirect('this');
			});
		$form['send']->caption = "Přidat uživatele do projektu";

		return $form;
	}
}
