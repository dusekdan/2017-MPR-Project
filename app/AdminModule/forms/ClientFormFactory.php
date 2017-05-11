<?php
/**
 * Created by PhpStorm.
 * User: František Rožek
 * Date: 3. 5. 2017
 * Time: 18:23
 */

namespace App\AdminModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use App\Model\Facades\ClientFacade;


use Kdyby\Doctrine\EntityManager;

class ClientFormFactory extends BaseFactory
{
	use Nette\SmartObject;
	
	/** @var EntityManager */
	private $em;
	
	/** @var ClientFacade */
	private $clientFacade;
	
	public function __construct(EntityManager $em, ClientFacade $clientFacade)
	{
		$this->em = $em;
		$this->clientFacade = $clientFacade;
	}
	
	/**
	 * Add new project form
	 * @return Form
	 */
	public function addClient($onSuccess)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		
		$form->addText('name', 'Název')
			->addRule(Form::FILLED, "Vyplňte prosím název klienta");
		
		$form->addTextArea('description', 'Popis')
			->addRule(Form::FILLED, "Vyplňte prosím popis klienta")
			->addRule(Form::MAX_LENGTH, 'Popis je příliš dlouhý', 300);
		
		$form->addSubmit('addClient', 'Přidat');
		$form->addButton('cancel', 'Zrušit')
			->setAttribute('data-dismiss', 'modal');
		
		$form->onSuccess[] = [$this, 'addClientSubmitted'];
		$form->onSuccess[] = $onSuccess;
		
		return $form;
	}
	
	public function addClientSubmitted(Form $form, $values)
	{
		$this->clientFacade->createClient($values['name'], $values['description'],true);
		return;
	}
	
	/**
	 * Add new project form
	 * @return Form
	 */
	public function editClient($onSuccess, $client)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		
		$form->addText('name', 'Název')
			->setDefaultValue($client->getName())
			->addRule(Form::FILLED, "Vyplňte prosím název klienta");
		
		$form->addTextArea('description', 'Popis')
			->setDefaultValue($client->getDescription())
			->addRule(Form::FILLED, "Vyplňte prosím popis klienta")
			->addRule(Form::MAX_LENGTH, 'Popis je příliš dlouhý', 300);
		
		$form->addHidden('idClient', $client->id);
		
		$form->addSubmit('editClient', 'Upravit');
		$form->addButton('cancel', 'Zrušit')
			->setAttribute('data-dismiss', 'modal');
		
		$form->onSuccess[] = [$this, 'editClientSubmitted'];
		$form->onSuccess[] = $onSuccess;
		
		return $form;
	}
	
	public function editClientSubmitted(Form $form, $values)
	{
		$this->clientFacade->editClient($values,true);
		return;
	}
	
	/**
	 * Add new project form
	 * @return Form
	 */
	public function removeClient($onSuccess, $client)
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		
		$form->addHidden('idClient', $client->id);
		
		$form->addSubmit('removeClient', 'Odstranit');
		$form->addButton('cancel', 'Zrušit')
			->setAttribute('data-dismiss', 'modal');
		
		$form->onSuccess[] = [$this, 'removeClientSubmitted'];
		$form->onSuccess[] = $onSuccess;
		
		return $form;
	}
	
	public function removeClientSubmitted(Form $form, $values)
	{
		$client = $this->clientFacade->getClient($values['idClient']);
		$this->clientFacade->removeClient($client,true);
		return;
	}
}