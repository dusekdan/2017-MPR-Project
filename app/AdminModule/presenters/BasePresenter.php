<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Nette;
use App\Model;



/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @persistent */
	public $locale;

	/** @var \Kdyby\Translation\Translator @inject */
	public $translator;

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
}
