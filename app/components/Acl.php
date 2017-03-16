<?php

declare(strict_types=1);

namespace App\Components;

use Nette\Application\UI\Control;
use Nette\Security\Permission;

/**
 * Class Acl
 * @package App\Components
 */
class Acl extends Control {
	/**
	 * @return \Nette\Security\IAuthorizator
	 */
	public static function create(){
		$acl = new Permission();

		/* seznam uživatelských rolí */
		$acl->addRole('guest');              //host
		$acl->addRole('admin');              //admin
		$acl->addRole('superAdmin', 'admin');//dědí od admina

		/* seznam zdrojů */
		$acl->addResource('AdminModule'); // přístup do Osobní údaje, Plán, Kalendář, Deník, Zprávy, Soubory
		$acl->addResource('BaseModule'); // přístup do administrace sportmodulu

		/* seznam pravidel oprávnění (role, zdroj, operace)*/
		/* stránky */
		$acl->allow('guest','BaseModule', ['edit','view','remove','add']);
		$acl->allow('admin','AdminModule', ['edit','view','remove','add']); //povoleno pro admina -> nemusím povolovat pro superAdmina

		$acl->deny('guest','BaseModule', ['edit', 'remove']);
		$acl->deny('guest','AdminModule', ['edit','view','remove','add']);
		$acl->deny('admin', 'AdminModule', 'updateUsers');

		/* superAdmin má práva na všechno */
		$acl->allow('superAdmin', ['BaseModule', 'AdminModule'], ['edit', 'view', 'remove', 'add', 'updateUsers']);

		return $acl;
	}
}