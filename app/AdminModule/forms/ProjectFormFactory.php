<?php

declare(strict_types=1);

namespace App\AdminModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use App\Model\Facades\ProjectFacade;
use App\Model\Facades\PhaseFacade;
use App\Model\Facades\UserFacade;
use Kdyby\Doctrine\EntityManager;



use Tracy\Debugger;

class ProjectFormFactory extends BaseFactory
{
	use Nette\SmartObject;

	/** @var EntityManager */
	private $em;

	/** @var ProjectFacade */
	private $projectFacade;

	/** @var PhaseFacade */
	private $phaseFacade;

	/** @var UserFacade */
	private $userFacade;

	public function __construct(EntityManager $em, ProjectFacade $projectFacade, PhaseFacade $phaseFacade, UserFacade $userFacade)
	{
		$this->em = $em;
		$this->projectFacade = $projectFacade;
		$this->phaseFacade = $phaseFacade;
		$this->userFacade = $userFacade;
	}

	public function chooseOne($project, callable $onSuccess)
	{
		$projects = [];
		foreach ($this->projectFacade->getProjects() as $proj) {
			$projects[$proj->getId()] = $proj->getName();
		}
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		$form->addSelect('projects', 'Vyberte si projekt', $projects)
			->setPrompt('Vyberte projekt')
			->addRule(Form::FILLED, "Projekt musí být zvolen.")
			->setAttribute("onChange", "sendForm();");
		if (isset ($project)) {
			$form['projects']->setDefaultValue($project);
		}
		$form->addSubmit('send', 'Zvolit');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			$onSuccess($values->projects);
		};

		return $form;
	}


	/**
	 * Add new risk form
	 * @return Form
	 */
	public function addRisk($stuff)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');

		$form->addText('firstName', 'Jméno')
			->addRule(Form::FILLED, "Vypltě prosím jméno");

		$form->addText('subscription', 'Popis')
			->addRule(Form::FILLED, "Vypltě prosím popis rizika");

		$form->addText('fromAdRisk', 'Od')
			->addRule(Form::FILLED, "Vypltě prosím časový interval");

		$form->addText('toAdRisk', 'Do')
			->addRule(Form::FILLED, "Vypltě prosím časový interval");

		$form->addText('probability', 'Pravděpodobnost')
			->addRule(Form::FILLED, "Vypltě prosím popis rizika");

		$form->addText('time', 'Čas')
			->addRule(Form::FILLED, "Vypltě prosím čas");

		$form->addText('money', 'Peníze')
			->addRule(Form::FILLED, "Vypltě prosím peněžní odhad");

		$form->addText('result', 'Výsledek')
			->addRule(Form::FILLED, "Vypltě prosím výsledek rizika");

		$form->addGroup()
			->setOption('container', 'fieldset class=formFooter');
		$form->addSubmit('addRisk', 'Přidat');
		$form->addSubmit('cancel', 'Zrušit');

		return $form;
	}

	/**
	 * Add new phase form
	 * @return Form
	 */
	public function addPhase($onSuccess, $idProject)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');

		$form->addText('name', 'Jméno')
			->addRule(Form::FILLED, "Vypltě prosím jméno");

		$form->addTextArea('subscription', 'Popis')
			->addRule(Form::FILLED, "Vypltě prosím popis rizika")
			->addRule(Form::MAX_LENGTH, 'Poznámka je příliš dlouhá', 300);

		$form->addText('from', 'Od')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vypltě prosím časový interval");

		$form->addText('to', 'Do')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vypltě prosím časový interval");

		$form->addHidden('idProject', $idProject);

		$form->addSubmit('addPhase', 'Přidat');
		$form->addButton('cancel', 'Zrušit')
			->setAttribute('data-dismiss', 'modal');

		$form->onSuccess[] = [$this, 'addPhaseSubmitted'];
		$form->onSuccess[] = $onSuccess;


		return $form;
	}

	public function addPhaseSubmitted(Form $form, $values)
	{
		$from = new Nette\Utils\DateTime($values['from']);
		$to = new Nette\Utils\DateTime($values['to']);
		$this->phaseFacade->createPhase($values['name'], $values['subscription'], $from, $to, $values['idProject'], true);

		return;
	}

	/**
	 * Change existing risk form
	 * @return Form
	 */
	public function changeRisk($stuff)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');

		$form->addText('firstName', 'Jméno')
			->addRule(Form::FILLED, "Vypltě prosím jméno");

		$form->addText('subscription', 'Popis')
			->addRule(Form::FILLED, "Vypltě prosím popis rizika");

		$form->addText('fromAdRisk', 'Od')
			->addRule(Form::FILLED, "Vypltě prosím časový interval");

		$form->addText('toAdRisk', 'Do')
			->addRule(Form::FILLED, "Vypltě prosím časový interval");

		$form->addText('probability', 'Pravděpodobnost')
			->addRule(Form::FILLED, "Vypltě pravděpodobnost prosím");

		$form->addText('prize', 'Cena')
			->addRule(Form::FILLED, "Vypltě prosím odhad ceny");

		$form->addText('time', 'Čas')
			->addRule(Form::FILLED, "Vypltě prosím časový odhad");

		$form->addText('state', 'Stav')
			->addRule(Form::FILLED, "Vypltě prosím stav rizika");

		$form->addGroup()
			->setOption('container', 'fieldset class=formFooter');
		$form->addSubmit('changePhase', 'Upravit');
		$form->addSubmit('cancel', 'Zrušit');

		return $form;
	}


	public function addUserProject($project, callable $onSuccess)
	{
		$users = [];
		foreach ($this->userFacade->getUsers() as $oneUser) {
			$users[$oneUser->getId()] = $oneUser->getUsername();
		}
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		$form->addSelect('users', '', $users)
			->setPrompt('Vyberte uživatele pro přidání');

		$form->addSubmit('send', 'Zvolit');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			$onSuccess($values->users);
		};

		return $form;
	}

}
