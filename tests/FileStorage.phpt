<?php

namespace Test;

use Nette;
use Tester;
use Tester\Assert;

use App\Components\FileStorage as FS;

$container = require __DIR__ . '/bootstrap.php';

//TODO připojit se k databázi, projet uživatele a zkontrolovat jejich složky
/**
 * Class FileStorage
 * @package Test
 */
class FileStorage extends Tester\TestCase
{
	private $container;

	private $fileStorage;

	private $homePath = ".";

	function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}


	public function setUp() {
		# Příprava - voláno před každou testovací metodou
		$this->fileStorage = new FS($this->homePath);
	}

	public function tearDown() {
		# Úklid - voláno po každé testovací metodě
	}



	function testManual()
	{
		$pathCreat = "/images/BaseModule/user/userId_user/userPhoto";
		$pathDel = "/images/BaseModule/user/userId_user";
		$this->fileStorage->createDirectory($pathCreat);
		Assert::true(is_dir($this->homePath . $pathCreat));
		$this->fileStorage->deleteDirectory($pathDel);
		Assert::false(is_dir($this->homePath . $pathDel));
	}

}


$test = new FileStorage($container);
$test->run();
