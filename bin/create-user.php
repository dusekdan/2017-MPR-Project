<?php
//@TODO třeba to začnu používat :)

if (!isset($_SERVER['argv'][3])) {
	echo '
Add new user to database.

Usage: create-user.php <name> <email> <password>
';
	exit(1);
}

list(, $name, $email, $password) = $_SERVER['argv'];

$container = require __DIR__ . '/../app/bootstrap.php';
/** @var App\BaseModule\Model\UserManager $manager */
$manager = $container->getByType(App\BaseModule\Model\UserManager::class);

try {
	$manager->add($name, $email, $password);
	echo "User $name was added.\n";

} catch (App\BaseModule\Model\DuplicateNameException $e) {
	echo "Error: duplicate name.\n";
	exit(1);
}
