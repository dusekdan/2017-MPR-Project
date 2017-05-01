<?php

declare(strict_types=1);

namespace  App\AdminModule\Presenters;

use Nette;
use App\Model;
use App\Model\Facades\ProjectFacade;
use App\AdminModule\Forms\ProjectFormFactory;
use Tracy\Debugger;


class ProjectPresenter extends BasePresenter
{
	/** @var projectFormFactory */
	private $projectFactory;

	public function __construct(ProjectFormFactory $projectFormFactory)
	{
		$this->projectFactory = $projectFormFactory;
	}

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
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
        if ($this->showModal == true) {
            $this->redrawControl("modal");
            $this->showModal = true;
        }

        return $this->projectFactory->addRisk(function() {
            $this->flashMessage("Nový risk úspěšně přidán.", "success");
            $this->redirect('Project:addRisk');
        });
    }


    public function renderChangeRisk(){}

    /**
     * Change existing risk.
     * @return Nette\Application\UI\Form
     */
    public function createComponentChangeRiskForm()
    {
        if ($this->showModal == true) {
            $this->redrawControl("modal");
            $this->showModal = true;
        }

        return $this->projectFactory->changeRisk(function() {
            $this->flashMessage("Risk úspěšně změněn.", "success");
            $this->redirect('Project:changeRisk');
        });
    }


    public function renderAddPhase(){}

    /**
     * Create new risk.
     * @return Nette\Application\UI\Form
     */
    public function createComponentAddPhaseForm()
    {
        if ($this->showModal == true) {
            $this->redrawControl("modal");
            $this->showModal = true;
        }

        return $this->projectFactory->addPhase(function() {
            $this->flashMessage("Nová fáze úspěšně přidána.", "success");
            $this->redirect('Project:addPhase');
        });
    }

}
