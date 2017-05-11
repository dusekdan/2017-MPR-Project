<?php
/**
 * Created by PhpStorm.
 * User: František Rožek
 * Date: 3. 5. 2017
 * Time: 17:56
 */

namespace App\AdminModule\Presenters;

use Nette;
use App\AdminModule\Forms\ClientFormFactory;
use App\Model\Facades\ClientFacade;

class ClientPresenter extends BasePresenter
{
	/** @var  ClientFormFactory */
	private $clientFormFactory;
	
	/** @var  ClientFacade */
	private $clientFacade;
	
	public function __construct(ClientFormFactory $clientFormFactory, ClientFacade $clientFacade)
	{
		$this->clientFormFactory = $clientFormFactory;
		$this->clientFacade = $clientFacade;
	}
	
	public function renderDefault()
	{
		$this->template->clients = $this->clientFacade->getClients();
	}
	
	public function actionAddClient()
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
	
	public function renderAddClient()
	{
	
	}
	
	/**
	 * Create new client.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentAddClientForm()
	{
		return $this->clientFormFactory->addClient(function () {
			$this->flashMessage("Nový klient byl úspěšně přidán.", "success");
			$this->showModal = false; // pokud je to ok, zavřu to
			$this->redirect('Client:default');
		});
	}
	
	public function actionEditClient($clientId)
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
	
	public function renderEditClient($clientId)
	{
	
	}
	
	/**
	 * Create new client.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentEditClientForm()
	{
		$client = $this->clientFacade->getClient($this->getParameter('clientId'));
		
		return $this->clientFormFactory->editClient(function () {
			$this->flashMessage("Klient byl úspěšně upraven.", "success");
			$this->showModal = false; // pokud je to ok, zavřu to
			$this->redirect('Client:default');
		}, $client);
	}
	
	public function actionRemoveClient($clientId)
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
	
	public function renderRemoveClient($clientId)
	{
		$this->template->client = $this->clientFacade->getClient($clientId);
	}
	
	/**
	 * Create new client.
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentRemoveClientForm()
	{
		$client = $this->clientFacade->getClient($this->getParameter('clientId'));
		
		return $this->clientFormFactory->removeClient(function () {
			$this->flashMessage("Klient byl úspěšně odstraněn.", "success");
			$this->showModal = false; // pokud je to ok, zavřu to
			$this->redirect('Client:default');
		}, $client);
	}
	
	public function handleChangeEnabled($clientId)
	{
		try {
			$client = $this->clientFacade->getClient($clientId);
			$this->clientFacade->changeEnabled($client, true);
			$this->flashMessage("Klientovi s id:{$clientId} byla úspěšně změněna aktivita.", "success");
		} catch (\Exception $e) {
			$this->flashMessage("Klientovi s id:{$clientId} se nepodařilo změnit aktivitu", "danger");
		}
	}
}