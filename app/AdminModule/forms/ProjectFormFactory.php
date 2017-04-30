<?php

declare(strict_types=1);

namespace App\AdminModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use App\Model\Facades\ProjectFacade;
use Kdyby\Doctrine\EntityManager;



use Tracy\Debugger;

class ProjectFormFactory extends BaseFactory
{
	use Nette\SmartObject;

	/** @var EntityManager*/
	private $em;

	/** @var ProjectFacade */
	private $projectFacade;


	public function __construct(EntityManager $em, ProjectFacade $projectFacade)
	{
		$this->em = $em;
		$this->projectFacade = $projectFacade;
	}

	public function chooseOne($project, callable $onSuccess)
	{
		$projects=[];
		foreach ($this->projectFacade->getProjects() as $proj) {
			$projects[$proj->getId()] = $proj->getName();
		}
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		$form->addSelect('Projekty', 'Vyberte si projekt', $projects)
			->setPrompt('Vyberte projekt')
			->addRule(Form::FILLED,"Projekt musí být zvolen.");
		if (isset ($project)) {
			$form['Projekty']->setDefaultValue($project);
		}
		$form->addSubmit('send', 'Zvolit');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			$onSuccess($values->Projekty);
		};

		return $form;
	}

}
