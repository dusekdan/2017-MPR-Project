<?php

declare(strict_types=1);

namespace App\BaseModule\Forms;

use App\Components\FileStorage;
use Nette;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security;

use Nette\Utils\Image;
use Nette\Utils\ImageException;

use App\Components\Utilities;
use App\Model\Facades\UserFacade;
use App\Model\Entities\User;
use Kdyby\Doctrine\EntityManager;

use Tracy\Debugger;

class UserFormFactory extends BaseFactory
{
	use Nette\SmartObject;

	/** @var User */
	private $user;

	/** @var EntityManager*/
	private $em;

	/** @var FileStorage */
	private $fileStorage;

	/** @var UserFacade */
	private $userFacade;

	/** @var object Parametry z config.neon*/
	private $conf;
	
	public function __construct($param, Security\User $user, EntityManager $em, FileStorage $fileStorage, Utilities $utilities, UserFacade $userFacade)
	{
		$this->user = $user;
		$this->em = $em;
		$this->fileStorage = $fileStorage;
		$this->conf = $utilities->convertToObject($param); //přetypování pole na objekt abych mohl zapisovat $x->y místo $x['y']
		$this->userFacade = $userFacade;
	}

	/**
     * Přihlášení
	 * @return Form
	 */
	public function signIn()
	{
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		$form->addText('username', 'Přihlašovací jméno:', 35)
		    ->addRule(Form::FILLED, 'Vyplňte Váše přihlašovací jméno');
		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím vložte heslo.');
		$form->addCheckbox('remember', 'Zapamatovat si');
		$form->addSubmit('send', 'Přihlásit se');

		return $form;
	}
	
	
	/**
     * Registrace
	 * @return Form
	 */
	public function signUp(callable $onSuccess)
	{
		$form = $this->create();
		$form->addGroup()
			->setOption("bottomDescription", "Položky označené hvězdičkou * jsou povinné.");

		$form->addText('username', 'Uživatelské jméno: *')
			->addRule(Form::FILLED,"Vypltě prosím uživatelské jméno");

	    $form->addText('firstName', 'Jméno: *')
			->addRule(Form::FILLED,"Vypltě prosím jméno");
		
		$form->addText('lastName', 'Příjmení: *')
			->addRule(Form::FILLED,"Vypltě prosím příjmení");
		
		$form->addText('birthday', 'Datum narození:')
			->setRequired(FALSE)
			->setAttribute('id', 'datepicker')
			->addRule(Form::PATTERN,'Nesprávný formát data, musí být dd.mm.yyyy .', '((0[1-9]|[12][0-9]|3[01])|).(0[1-9]|1[012]).(19|20)\d\d');
		
		$form->addText("phone", "Tel: *")
			->addRule(Form::FILLED,"Vypltě prosím telefon")
			->addCondition(Form::MIN_LENGTH, 10)
			->addRule(Form::PATTERN, 'Musí obsahovat číslice a předvolbu např: +420', '(\+[0-9]*)')
			->addRule(Form::LENGTH, "Telefon musí být maximalne 13 číslic s předvolbou",13)
			->endCondition()
			->addCondition(Form::MAX_LENGTH, 10)
			->addRule(Form::PATTERN, 'Musí obsahovat číslice', '([0-9]*)')
			->addRule(Form::LENGTH, "Telefon musí být minimálně 9 znaků dlouhý",9)
			->endCondition();
		
		$form->addText('email', 'E-mail: *', 35)
			->setAttribute('placeholder', 'jméno@email.cz')
			->addRule(Form::FILLED, 'Vyplňte Váš email')
			->addCondition(Form::FILLED)
			->addRule(Form::EMAIL, 'Neplatná emailová adresa');
		
		$form->addPassword('password', 'Heslo: *', 20)
			->setOption('description', '6 - 20 znaků')
			->addRule(Form::FILLED, 'Vyplňte Vaše heslo')
			->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', $this->conf->password->minLength);
		
	    $form->addPassword('passwordAgain', 'Heslo znovu: *', 20)
			->addConditionOn($form['password'], Form::VALID)
			->addRule(Form::FILLED, 'Heslo znovu.')
			->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['password']);

		$form->addSubmit('send', 'Registrovat');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {

			if ($this->userFacade->getUserByName($values->username)) {
				$form['username']->addError('Uživatel s tímto uživatelským jménem už existuje.');

				return;
			}
			if ($this->userFacade->getUserByEmail($values->email)) {
				$form['email']->addError('Uživatel s tímto emailem už existuje.');

				return;
			}

			try {
				$user = new User($values->username, $values->password, $values->email, $values->firstName, $values->lastName, $values->birthday, $values->phone, NULL);
				$this->em->persist($user);
				$this->em->flush();
				if (!$this->user->isLoggedIn())
					$this->user->login($values->username, $values->password);
				$this->fileStorage->createDirectory($this->fileStorage->getUserPhotoDir($user->getId()));
			} catch (\Exception $e) {
				$form->addError("Nastala chyba při vytváření uživatele, informujte administrátora.".$e);

				return;
			}
			$onSuccess();
		};

		return $form;
	}
	
	/**
	 * úprava údajů uživatele
	 * @return Form
	 */
	public function update(callable $onSuccess, User $user) {
		$form = $this->create();
		$form->getElementPrototype()->class('ajax');
		//vypne validaci u uzivatele a provede se az na serveru
		//$form->elementPrototype->novalidate = "novalidate";
		$form->addGroup()
				->setOption('container', 'fieldset class=formCol1');

		$form->addText('username', 'Uživatelské jméno:')
			->addRule(Form::FILLED,"Vypltě prosím uživatelské jméno");

		$form->addText('firstName', 'Jméno:')
			->addRule(Form::FILLED,"Vypltě prosím jméno");

		$form->addText('lastName', 'Příjmení:')
			->addRule(Form::FILLED,"Vypltě prosím příjmení");

		$form->addText('birthday', 'Datum narození:')
			->setRequired(FALSE)
			->setAttribute('id', 'datepicker')
			->addRule(Form::PATTERN,'Nesprávný formát data, musí být dd.mm.yyyy .', '((0[1-9]|[12][0-9]|3[01])|).(0[1-9]|1[012]).(19|20)\d\d');

		$form->addText("phone", "Tel: ")
			->addRule(Form::FILLED,"Vypltě prosím telefon")
			->addCondition(Form::MIN_LENGTH, 10)
			->addRule(Form::PATTERN, 'Musí obsahovat číslice a předvolbu např: +420', '(\+[0-9]*)')
			->addRule(Form::LENGTH, "Telefon musí být maximalne 13 číslic s předvolbou",13)
			->endCondition()
			->addCondition(Form::MAX_LENGTH, 10)
			->addRule(Form::PATTERN, 'Musí obsahovat číslice', '([0-9]*)')
			->addRule(Form::LENGTH, "Telefon musí být minimálně 9 znaků dlouhý",9)
			->endCondition();

		$form->addText('email', 'E-mail: *', 35)
			->setAttribute('placeholder', 'jméno@email.cz')
			->addRule(Form::FILLED, 'Vyplňte Váš email')
			->addCondition(Form::FILLED)
			->addRule(Form::EMAIL, 'Neplatná emailová adresa');

		$form->addUpload('image', 'Profilový obrázek:')
			->addConditionOn($form['image'], Form::FILLED)
			->addRule(Form::IMAGE, 'Zvolte si prosím jiný formát profilového obrázku, povolené formáty obrázku jsou JPG, PNG a GIF')
			->addRule(Form::MAX_FILE_SIZE, 'Zmenšete prosím nahravaný obrázek, maximální velikost obrázku je 1 MB.', 1024 * 1024 /* v bajtech */);
		// Role může nastavovat jen superAdmin a nesmí je nastavovat sobě
		if ($this->user->isInRole('superAdmin') && $this->user->getId() != $user->getId()) {
			$form->addSelect('role', 'Role:', User::getRoleList());
			$form['role']->setDefaultValue($user->getRole());
		}

		$form['username']->setDefaultValue($user->getUsername());
		$form['firstName']->setDefaultValue($user->getFirstName());
		$form['lastName']->setDefaultValue($user->getLastName());
		if ($birthday = $user->getBirthday()) {
			$form['birthday']->setDefaultValue(date_format($birthday,"d.m.Y"));
		}
		$form['phone']->setDefaultValue($user->getPhone());
		$form['email']->setDefaultValue($user->getEmail());

		$form->addGroup()
				->setOption('container', 'fieldset class=formFooter');
		$form->addSubmit('update', 'Upravit');
		$form->addSubmit('deletePhoto', 'Smazat fotku');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess, $user) {
			$userId = $user->getId();
			try {
				if ($form->isSubmitted() == $form['deletePhoto']) {
					if (is_file($this->fileStorage->getUserPhotoDir($userId, true) . "/userPhoto-{$userId}.png")) {
						unlink($this->fileStorage->getUserPhotoDir($userId, true) . "/userPhoto-{$userId}.png");
						$user->setHasPhoto(false);
					}
				}

				if ($values->image->isOK() && $values->image->isImage()) {
					$image = Image::fromFile($values->image);
					$image->resize(NULL, $this->conf->image->maxHeight, Image::FIT);
					$image->save($this->fileStorage->getUserPhotoDir($userId, true) . "/userPhoto-{$userId}.png", 80, Image::PNG);
					$user->setHasPhoto(true);
				}
			} catch (ImageException $e) {
				$form->addError("Chyba při práci s obrázkem. - " . $e->getMessage());
				return;
			}

			if (!($user->getUsername() === $values->username) && $this->userFacade->getUserByName($values->username)) {
				$form['username']->addError('Uživatel s tímto uživatelským jménem už existuje.');
				return;
			}
			if (!($user->getEmail() === $values->email) && $this->userFacade->getUserByEmail($values->email)) {
				$form['email']->addError('Uživatel s tímto emailem už existuje.');
				return;
			}

			try {
				$user->setUsername($values->username);
				$user->setFirstName($values->firstName);
				$user->setLastName($values->lastName);
				$user->setBirthday($values->birthday);
				$user->setPhone($values->phone);
				$user->setEmail($values->email);
				if (isset($values->role)) $user->setRole($values->role);
				$this->em->persist($user); // start managing the entity
				$this->em->flush(); // save it to the database
				//okamžitá změna údajů přepsáním identity
				if($this->user->getId() == $userId) {
					$this->user->getStorage()->setIdentity($this->userFacade->getIdentity($userId));
				}
			} catch (\Exception $e) {
				$form->addError($e->getMessage());
				return;
			}

			$onSuccess($user);
		};

		return $form;
	}

	public function changePassword (callable $onSuccess,User $user) {
		$form = $this->create();
		$form->addPassword('password', 'Staré heslo:', 20)
			->setOption('description', '6 - 20 znaků')
			->addRule(Form::FILLED, 'Vyplňte Vaše heslo')
			->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', $this->conf->password->minLength);
		$form->addPassword('password_new', 'Nové heslo:', 20)
			->setOption('description', '6 - 20 znaků')
			->addCondition(Form::FILLED)
			->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', $this->conf->password->minLength);
		$form->addPassword('password_new_again', 'Nové heslo znovu:', 20)
			->addConditionOn($form['password_new'], Form::FILLED)
			->addRule(Form::FILLED, 'Heslo znovu')
			->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['password_new']);
		$form->addSubmit('changePassword', 'Změnit heslo');
		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess, $user) {
			try {
				$this->userFacade->setPassword($user, $values->password, $values->password_new);
				$onSuccess();
			} catch (AuthenticationException $e) {
				$form->addError($e->getMessage());
			}
		};

		return $form;
	}
}
