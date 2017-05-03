<?php

declare(strict_types=1);

namespace App\AdminModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use App\Model\Facades\ProjectFacade;
use App\Model\Facades\PhaseFacade;
use App\Model\Facades\RiskFacade;
use App\Model\Facades\RiskTypeFacade;
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
	
	/** @var RiskFacade */
	private $riskFacade;
	
	/** @var RiskTypeFacade */
	private $riskTypeFacade;
	
	/** @var UserFacade */
	private $userFacade;
	
	public function __construct(EntityManager $em, ProjectFacade $projectFacade, PhaseFacade $phaseFacade, UserFacade $userFacade, RiskFacade $riskFacade, RiskTypeFacade $riskTypeFacade)
	{
		$this->em = $em;
		$this->projectFacade = $projectFacade;
		$this->phaseFacade = $phaseFacade;
		$this->userFacade = $userFacade;
		$this->riskFacade = $riskFacade;
		$this->riskTypeFacade = $riskTypeFacade;
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
	public function addRisk($onSuccess, $phase, $creator)
	{
		
		$users = [];
		foreach ($phase->getUsers() as $u) {
			$users[$u->getId()] = $u->getFirstName()." ".$u->getLastName()." (".$u->getUsername().")";
		}
		
		$riskTypes = $this->riskTypeFacade->getRiskTypes();
		$types = [];
		foreach ($riskTypes as $riskType) {
			$types[$riskType->getId()] = $riskType->getName();
		}
		
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		
		$form->addText('name', 'Název rizika')
			->addRule(Form::FILLED, "Vyplňte prosím jméno");
		
		$form->addText('description', 'Popis')
			->addRule(Form::FILLED, "Vyplňte prosím popis rizika");
		
		$form->addText('from', 'Od')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('to', 'Do')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('probability', 'Pravděpodobnost')
			->setType('number')
			->setAttribute('step','0.1')
			->addRule(Form::FLOAT, "Pravděpodobnost musí být desetinné číslo")
			->addRule(Form::MAX, "Pravděpodobnost musí být menší než 100%", 100)
			->addRule(Form::MIN, "Pravděpodobnost musí být větší než 0",0)
			->addRule(Form::FILLED, "Vyplňte prosím popis rizika");
		
		$form->addText('time', 'Čas')
			->setType('number')
			->setAttribute('placeholder', 'Zadejte počet hodin')
			->addRule(Form::MIN, "Čas nesmí být záporný", 0)
			->addRule(Form::FILLED, "Vyplňte prosím čas");
		
		$form->addText('money', 'Peníze')
			->setType('number')
			->addRule(Form::FILLED, "Vyplňte prosím peněžní odhad");
		
		$form->addText('result', 'Výsledek')
			->addRule(Form::FILLED, "Vyplňte prosím výsledek rizika");
		
		$form->addText('trigger', 'Spouštěč')
			->addRule(Form::FILLED, "Vyplňte prosím spouštěč rizika");
		
		$form->addText('reaction', 'Reakce')
			->addRule(Form::FILLED, "Vyplňte prosím reakci na riziko");
		
		$form->addText('severity', 'Závažnost')
			->addRule(Form::FILLED, "Vyplňte prosím závažnost rizika");
		
		$form->addTextArea('primaryCause', 'Primární účel')
			->addRule(Form::FILLED, "Vyplňte prosím primární účel rizika");
		
		$form->addSelect('riskTypeId','Typ rizika', $types)
			->addRule(Form::FILLED, "Vyplňte prosím typ rizika");
		
		$form->addSelect('responsibleUserId','Zodpovědný uživatel', $users)
			->addRule(Form::FILLED, "Vyplňte prosím zodpovědného uživatele za riziko");
			
		$form->addHidden('phaseId', $phase->getId());
		$form->addHidden('creatorId', $creator->getId());
		
		$form->addSubmit('addRisk', 'Přidat');
		$form->addButton('cancel', 'Zrušit')
			->setAttribute('data-dismiss', 'modal');
		
		$form->onSuccess[] = [$this, 'addRiskSubmitted'];
		$form->onSuccess[] = $onSuccess;
		
		return $form;
	}
	
	/**
	 * @param Form $form
	 * @param $values
	 */
	public function addRiskSubmitted(Form $form, $values)
	{
		$from = new Nette\Utils\DateTime($values['from']);
		$to = new Nette\Utils\DateTime($values['to']);
		$phase = $this->phaseFacade->getPhase($values['phaseId']);
		$riskType = $this->riskTypeFacade->getRiskType($values['riskTypeId']);
		$responsibleUser = $this->userFacade->getUser($values['responsibleUserId']);
		$creator = $this->userFacade->getUser($values['creatorId']);
		
		$this->riskFacade->createRisk($values['name'], $values['description'], $values['probability'], $values['money'], $values['time'], $values['result'], $values['primaryCause'], $values['trigger'], $values['reaction'], $values['severity'], $from, $to, $riskType, $phase, $responsibleUser, $creator, true);
		
		return;
	}
	
	/**
	 * Add new phase form
	 * @return Form
	 */
	public function addPhase($onSuccess, $project)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		
		$form->addText('name', 'Jméno')
			->addRule(Form::FILLED, "Vyplňte prosím jméno");
		
		$form->addTextArea('subscription', 'Popis')
			->addRule(Form::FILLED, "Vyplňte prosím popis rizika")
			->addRule(Form::MAX_LENGTH, 'Poznámka je příliš dlouhá', 300);
		
		$form->addText('from', 'Od')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('to', 'Do')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addHidden('project', $project);
		
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
		$this->phaseFacade->createPhase($values['name'], $values['subscription'], $from, $to, $values['project'], true);
		
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
			->addRule(Form::FILLED, "Vyplňte prosím jméno");
		
		$form->addText('subscription', 'Popis')
			->addRule(Form::FILLED, "Vyplňte prosím popis rizika");
		
		$form->addText('fromAdRisk', 'Od')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('toAdRisk', 'Do')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('probability', 'Pravděpodobnost')
			->addRule(Form::FILLED, "Vyplňte pravděpodobnost prosím");
		
		$form->addText('prize', 'Cena')
			->addRule(Form::FILLED, "Vyplňte prosím odhad ceny");
		
		$form->addText('time', 'Čas')
			->addRule(Form::FILLED, "Vyplňte prosím časový odhad");
		
		$form->addText('state', 'Stav')
			->addRule(Form::FILLED, "Vyplňte prosím stav rizika");
		
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
