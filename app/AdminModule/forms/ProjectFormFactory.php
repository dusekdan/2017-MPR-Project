<?php

declare(strict_types=1);

namespace App\AdminModule\Forms;

use App\Model\Entities\Risk;
use Nette;
use Nette\Application\UI\Form;
use App\Model\Facades\ProjectFacade;
use App\Model\Facades\PhaseFacade;
use App\Model\Facades\RiskFacade;
use App\Model\Facades\RiskTypeFacade;
use App\Model\Facades\UserFacade;
use App\Model\Facades\ClientFacade;

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

    /** @var ClientFacade */
	private $clientFacade;
	
	public function __construct(EntityManager $em, ProjectFacade $projectFacade, PhaseFacade $phaseFacade, UserFacade $userFacade, RiskFacade $riskFacade, RiskTypeFacade $riskTypeFacade, ClientFacade $clientFacade)
	{
		$this->em = $em;
		$this->projectFacade = $projectFacade;
		$this->phaseFacade = $phaseFacade;
		$this->userFacade = $userFacade;
		$this->riskFacade = $riskFacade;
		$this->riskTypeFacade = $riskTypeFacade;
        $this->clientFacade = $clientFacade;
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
     * Add new project form
     * @return Form
     */
    public function addProject($onSuccess)
    {
        $users = [];
        foreach ($this->userFacade->getUsers() as $u) {
            $users[$u->getId()] = $u->getFirstName()." ".$u->getLastName()." (".$u->getUsername().")";
        }

        $clients = [];
        foreach ($this->clientFacade->getClients() as $c) {
            $clients[$c->getId()] = $c->getName();
        }

        $form = $this->create();
        $form->getElementPrototype()->class('ajax');

        $form->addText('name', 'Jméno')
            ->addRule(Form::FILLED, "Vyplňte prosím jméno");

        $form->addTextArea('subscription', 'Popis')
            ->addRule(Form::FILLED, "Vyplňte prosím popis projektu")
            ->addRule(Form::MAX_LENGTH, 'Poznámka je příliš dlouhá', 300);

        $form->addText('from', 'Od')
            ->setAttribute('class', 'datepicker')
            ->addRule(Form::FILLED, "Vyplňte prosím časový interval");

        $form->addText('to', 'Do')
            ->setAttribute('class', 'datepicker')
            ->addRule(Form::FILLED, "Vyplňte prosím časový interval");

        $form->addSelect('projectManagerId','Projektový manažer', $users)
            ->addRule(Form::FILLED, "Vyplňte prosím projektového manažera");

        $form->addSelect('clientId','Klient', $clients)
            ->addRule(Form::FILLED, "Vyplňte prosím klienta");

        $form->addSubmit('addProject', 'Přidat');
        $form->addButton('cancel', 'Zrušit')
            ->setAttribute('data-dismiss', 'modal');

        $form->onSuccess[] = [$this, 'addProjectSubmitted'];
        $form->onSuccess[] = $onSuccess;


        return $form;
    }

    /**
     * @param Form $form
     * @param $values
     */
    public function addProjectSubmitted(Form $form, $values)
    {
        $from = new Nette\Utils\DateTime($values['from']);
        $to = new Nette\Utils\DateTime($values['to']);
        $this->projectFacade->createProject($values['name'], $values['subscription'], $from, $to, $values['projectManagerId'], $values['clientId'], true);

        return;
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
		
		$form->addText('startDate', 'Od')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('endDate', 'Do')
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('probability', 'Pravděpodobnost')
			->setType('number')
			->setAttribute('step','0.1')
			->addRule(Form::FLOAT, "Pravděpodobnost musí být desetinné číslo")
			->addRule(Form::MAX, "Pravděpodobnost musí být menší než 100%", 100)
			->addRule(Form::MIN, "Pravděpodobnost musí být větší než 0",0)
			->addRule(Form::FILLED, "Vyplňte prosím pravděpodobnost rizika");
		
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
	
	public function addRiskSubmitted(Form $form, $values)
	{
		$startDate = new Nette\Utils\DateTime($values['startDate']);
		$endDate = new Nette\Utils\DateTime($values['endDate']);
		$phase = $this->phaseFacade->getPhase($values['phaseId']);
		$riskType = $this->riskTypeFacade->getRiskType($values['riskTypeId']);
		$responsibleUser = $this->userFacade->getUser($values['responsibleUserId']);
		$creator = $this->userFacade->getUser($values['creatorId']);
		
		$this->riskFacade->createRisk($values['name'], $values['description'], $values['probability'], $values['money'], $values['time'], $values['result'], $values['primaryCause'], $values['trigger'], $values['reaction'], $values['severity'], $startDate, $endDate, $riskType, $phase, $responsibleUser, $creator, true);
		
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
		$project = $this->projectFacade->getProject($values['project']);
		$this->phaseFacade->createPhase($values['name'], $values['subscription'], $from, $to, $project, true);
		
		return;
	}
	
	/**
	 * Edit existing risk form
	 * @return Form
	 */
	public function editRisk($onSuccess, $risk)
	{
		$users = [];
		foreach ($risk->getPhase()->getUsers() as $u) {
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
			->setDefaultValue($risk->getName())
			->addRule(Form::FILLED, "Vyplňte prosím jméno");
		
		$form->addText('description', 'Popis')
			->setDefaultValue($risk->getDescription())
			->addRule(Form::FILLED, "Vyplňte prosím popis rizika");
		
		$form->addText('startDate', 'Od')
			->setDefaultValue($risk->getStartDate()->format('d.m.Y'))
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('endDate', 'Do')
			->setDefaultValue($risk->getEndDate()->format('d.m.Y'))
			->setAttribute('class', 'datepicker')
			->addRule(Form::FILLED, "Vyplňte prosím časový interval");
		
		$form->addText('probability', 'Pravděpodobnost')
			->setDefaultValue($risk->getProbability())
			->setType('number')
			->setAttribute('step','0.1')
			->addRule(Form::FLOAT, "Pravděpodobnost musí být desetinné číslo")
			->addRule(Form::MAX, "Pravděpodobnost musí být menší než 100%", 100)
			->addRule(Form::MIN, "Pravděpodobnost musí být větší než 0",0)
			->addRule(Form::FILLED, "Vyplňte prosím pravděpodobnost rizika");
		
		$form->addText('time', 'Čas')
			->setDefaultValue($risk->getTime())
			->setType('number')
			->setAttribute('placeholder', 'Zadejte počet hodin')
			->addRule(Form::MIN, "Čas nesmí být záporný", 0)
			->addRule(Form::FILLED, "Vyplňte prosím čas");
		
		$form->addText('money', 'Peníze')
			->setDefaultValue($risk->getMoney())
			->setType('number')
			->addRule(Form::FILLED, "Vyplňte prosím peněžní odhad");
		
		$form->addText('result', 'Výsledek')
			->setDefaultValue($risk->getResult())
			->addRule(Form::FILLED, "Vyplňte prosím výsledek rizika");
		
		$form->addText('trigger', 'Spouštěč')
			->setDefaultValue($risk->getTrigger())
			->addRule(Form::FILLED, "Vyplňte prosím spouštěč rizika");
		
		$form->addText('reaction', 'Reakce')
			->setDefaultValue($risk->getReaction())
			->addRule(Form::FILLED, "Vyplňte prosím reakci na riziko");
		
		$form->addText('severity', 'Závažnost')
			->setDefaultValue($risk->getSeverity())
			->addRule(Form::FILLED, "Vyplňte prosím závažnost rizika");
		
		$form->addTextArea('primaryCause', 'Primární účel')
			->setDefaultValue($risk->getPrimaryCause())
			->addRule(Form::FILLED, "Vyplňte prosím primární účel rizika");
		
		$form->addSelect('riskTypeId','Typ rizika', $types)
			->addRule(Form::FILLED, "Vyplňte prosím typ rizika");
		
		$form->addSelect('responsibleUserId','Zodpovědný uživatel', $users)
			->addRule(Form::FILLED, "Vyplňte prosím zodpovědného uživatele za riziko");
		
		
		$form->addHidden('idRisk',$risk->id);
		
		$form->addSubmit('addRisk', 'Upravit');
		$form->addButton('cancel', 'Zrušit')
			->setAttribute('data-dismiss', 'modal');
		
		$form->onSuccess[] = [$this, 'editRiskSubmitted'];
		$form->onSuccess[] = $onSuccess;
		
		return $form;
	}
	
	public function editRiskSubmitted(Form $form, $values)
	{
		$responsibleUser = $this->userFacade->getUser($values['responsibleUserId']);
		$riskType = $this->riskTypeFacade->getRiskType($values['riskTypeId']);
		
		$this->riskFacade->editRisk($values, $riskType, $responsibleUser, true);
		
		return;
	}
	
	public function removeRisk($onSuccess, $risk)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		
		$form->addSubmit('removeRisk', 'Odstranit');
		$form->addButton('cancel', 'Zrušit')
			->setAttribute('data-dismiss', 'modal');
		
		$form->addHidden("idRisk", $risk->id);
		
		$form->onSuccess[] = [$this, 'removeRiskSubmitted'];
		$form->onSuccess[] = $onSuccess;
		
		return $form;
	}
	
	public function removeRiskSubmitted(Form $form, $values)
	{
		$risk = $this->riskFacade->getRisk($values['idRisk']);
		$this->riskFacade->removeRisk($risk, true);
		return;
	}
	
	public function addUserProject($users, callable $onSuccess, $caption)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		$form->addSelect('users', '', $users)
			->setPrompt('Vyberte uživatele pro přidání');
		
		$form->addSubmit('send')
			->getControlPrototype()
			->setName('button')
			->setHtml('<span class="glyphicon glyphicon-user"></span>'.$caption);
		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			$onSuccess($values->users);
		};
		
		return $form;
	}
	
}
