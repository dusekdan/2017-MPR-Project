<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Nette;
use App\Model;
use App\Model\Facades\ProjectFacade;
use App\AdminModule\Forms\ProjectFormFactory;
use Tracy\Debugger;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @persistent */
	public $locale;

	/** @var \Kdyby\Translation\Translator @inject */
	public $translator;

	/** @persistent */
	public $showModal = false;

	/** @persistent */
	public $project;

	/**
	 * @var ProjectFacade Fasáda pro manipulaci s uživateli.
	 * @inject
	 */
	public $projectFacade;

	/**
	 * @var ProjectFormFactory
	 * @inject
	 */
	public $projectFormF;


	public function startup()
	{
		parent::startup();
		/**
		 * Ověření zda má oprávnění
		 */
		if (!$this->user->isAllowed('AdminModule', 'view')) {
			$this->flashMessage('Nemáte dostatečné oprávnění pro přístup.','danger');
			$this->redirect(':Base:User:signIn', ['backlink' => $this->storeRequest()]);
		}
	}

	public function beforeRender()
	{
		parent::beforeRender();

		$this->template->projects = $this->projectFacade->getProjects();
		if (isset($this->project)) {
			$this->template->project = $this->projectFacade->getProject($this->project);
		}
	}

	protected function createComponentChooseOneForm()
	{
		return $this->projectFormF->chooseOne($this->project, function($project) {
			$this->flashMessage("Změna projektu.", "info");
			$this->redirect('this', ['project'=>$project]);
		});
	}


	// add project
    public function actionAddProject()
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

    public function renderAddProject()
    {
    }

    /**
     * Create new project.
     * @return Nette\Application\UI\Form
     */
    public function createComponentAddProjectForm()
    {
        return $this->projectFormF->addProject(function() {
            $this->flashMessage("Přidání projektu proběhlo úspěšne.", "info");
            $this->showModal = false;
            $this->redirect('Homepage:default');
        });
    }

}
