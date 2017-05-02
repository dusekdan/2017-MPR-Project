<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;
use App\Model\Facades\ProjectFacade;
use App\Model\Facades\UserFacade;
use App\Model\Facades\PhaseFacade;
use App\AdminModule\Forms\ProjectFormFactory;
use Tracy\Debugger;


class ProjectPresenter extends BasePresenter
{
	/** @var ProjectFormFactory */
	private $projectFactory;

	/** @var UserFacade */
	private $userFacade;

	public function __construct(ProjectFormFactory $projectFormFactory, UserFacade $userFacade)
	{
		$this->projectFactory = $projectFormFactory;
		$this->userFacade = $userFacade;
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

    public function renderAddRisk()
    {

    }

    /**
     * Create new risk.
     * @return Nette\Application\UI\Form
     */
    public function createComponentAddRiskForm()
    {
        return $this->projectFactory->addRisk(function() {
            $this->flashMessage("Nový risk úspěšně přidán.", "success");
	        $this->showModal = false; // pokud je to ok, zavřu to
	        $this->redirect('Project:default');
        });
    }


    public function actionChangeRisk()
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

    public function renderChangeRisk(){}

    /**
     * Change existing risk.
     * @return Nette\Application\UI\Form
     */
    public function createComponentChangeRiskForm()
    {
        return $this->projectFactory->changeRisk(function() {
            $this->flashMessage("Risk úspěšně změněn.", "success");
	        $this->showModal = false; // pokud je to ok, zavřu to
	        $this->redirect('Project:default');
        });
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

    public function handleDeleteRisk($idRisk)
    {
    	//@TODO dodělat mazání
	    $this->flashMessage("Risk s id:$idRisk byl úspěšně smazán.", "success");
    }
}
