<?php

namespace Test;

use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';


class ExampleTest extends Tester\TestCase
{
	private $container;


	function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}


	public function setUp() {
		# Příprava - voláno před každou testovací metodou
	}

	public function tearDown() {
		# Úklid - voláno po každé testovací metodě
	}



	function testSomething()
	{
		Assert::true(TRUE);
	}

}


$test = new ExampleTest($container);
$test->run();
