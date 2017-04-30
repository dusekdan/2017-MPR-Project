<?php

declare(strict_types=1);

namespace App\AdminModule\Forms;

use Nette;
use Nette\Application\UI\Form;

use App\Components\FileStorage;
use App\AdminModule\Forms\BaseFactory;
use App\BaseModule\Forms\UserFormFactory as baseUFF;


use Tracy\Debugger;

class UserFormFactory extends BaseFactory
{
	use Nette\SmartObject;

	/** @var FileStorage */
	private $fileStorage;

	/** @var baseUFF */
	private $baseUFF;

	//TODO dostat to do konfigu nebo nějak společné s BASEMODULE
	const PASSWORD_MIN_LENGTH = 7;
	const IMAGE_MAX_HEIGHT = 200;


	public function __construct(FileStorage $fileStorage, baseUFF $userFormFactory)
	{
		$this->fileStorage = $fileStorage;
		$this->baseUFF = $userFormFactory;
	}

	public function update(callable $onSuccess, $user)
	{
		$form = $this->baseUFF->update($onSuccess, $user);
		$form->getElementPrototype()->class('ajax');

		return $form;
	}
}
