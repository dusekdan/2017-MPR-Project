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


    /**
     * Add new risk form
     * @return Form
     */
    public function addRisk($stuff) {
        $form = $this->create();
        $form->getElementPrototype()->class('ajax');

        $form->addText('firstName', 'Jméno')
            ->addRule(Form::FILLED,"Vypltě prosím jméno");

        $form->addText('subscription', 'Popis')
            ->addRule(Form::FILLED,"Vypltě prosím popis rizika");

        $form->addText('fromAdRisk', 'Od')
            ->addRule(Form::FILLED,"Vypltě prosím časový interval");

        $form->addText('toAdRisk', 'Do')
            ->addRule(Form::FILLED,"Vypltě prosím časový interval");

        $form->addText('probability', 'Pravděpodobnost')
            ->addRule(Form::FILLED,"Vypltě prosím popis rizika");

        $form->addText('time', 'Čas')
            ->addRule(Form::FILLED,"Vypltě prosím čas");

        $form->addText('money', 'Peníze')
            ->addRule(Form::FILLED,"Vypltě prosím peněžní odhad");

        $form->addText('result', 'Výsledek')
            ->addRule(Form::FILLED,"Vypltě prosím výsledek rizika");

        return $form;
    }

    /**
     * Add new phase form
     * @return Form
     */
    public function addPhase($stuff) {
        $form = $this->create();
        $form->getElementPrototype()->class('ajax');

        $form->addText('firstName', 'Jméno')
            ->addRule(Form::FILLED,"Vypltě prosím jméno");

        $form->addText('subscription', 'Popis')
            ->addRule(Form::FILLED,"Vypltě prosím popis rizika");

        $form->addText('fromAdRisk', 'Od')
            ->addRule(Form::FILLED,"Vypltě prosím časový interval");

        $form->addText('toAdRisk', 'Do')
            ->addRule(Form::FILLED,"Vypltě prosím časový interval");

        return $form;
    }

    /**
     * Change existing risk form
     * @return Form
     */
    public function changeRisk($stuff) {
        $form = $this->create();
        $form->getElementPrototype()->class('ajax');

        $form->addText('firstName', 'Jméno')
            ->addRule(Form::FILLED,"Vypltě prosím jméno");

        $form->addText('subscription', 'Popis')
            ->addRule(Form::FILLED,"Vypltě prosím popis rizika");

        $form->addText('fromAdRisk', 'Od')
            ->addRule(Form::FILLED,"Vypltě prosím časový interval");

        $form->addText('toAdRisk', 'Do')
            ->addRule(Form::FILLED,"Vypltě prosím časový interval");

        $form->addText('probability', 'Pravděpodobnost')
            ->addRule(Form::FILLED,"Vypltě pravděpodobnost prosím");

        $form->addText('prize', 'Cena')
            ->addRule(Form::FILLED,"Vypltě prosím odhad ceny");

        $form->addText('time', 'Čas')
            ->addRule(Form::FILLED,"Vypltě prosím časový odhad");

        $form->addText('state', 'Stav')
            ->addRule(Form::FILLED,"Vypltě prosím stav rizika");

        return $form;
    }

}
