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

        $acl->addRole('guest');
        $acl->addRole('administrator');
        $acl->addRole('owner');
        $acl->addRole('projectManager', 'owner');
        $acl->addRole('user', 'projectManager');



		/* seznam zdrojů */
		$acl->addResource('AdminModule'); // přístup do Osobní údaje, Plán, Kalendář, Deník, Zprávy, Soubory
		$acl->addResource('BaseModule'); // přístup do administrace sportmodulu

		/* seznam pravidel oprávnění (role, zdroj, operace)*/
		/* stránky */
		$acl->allow('user','BaseModule', ['edit','view','remove','add']);
		$acl->allow('administrator','AdminModule', ['edit','view','remove','add']); //povoleno pro admina -> nemusím povolovat pro superAdmina
        $acl->allow('projectManager','AdminModule', ['edit','view','remove','add']); //povoleno pro admina -> nemusím povolovat pro superAdmina
        $acl->allow('owner','AdminModule', ['edit','view','remove','add']); //povoleno pro admina -> nemusím povolovat pro superAdmina


		$acl->deny('user','BaseModule', ['edit', 'remove']);
		$acl->deny('user','AdminModule', ['edit','view','remove','add']);
		$acl->deny('administrator', 'AdminModule', 'updateUsers');
        $acl->deny('projectManager', 'AdminModule', 'updateUsers');
        $acl->deny('owner', 'AdminModule', 'updateUsers');

		/* superAdmin má práva na všechno */
		$acl->allow('administrator', ['BaseModule', 'AdminModule'], ['edit', 'view', 'remove', 'add', 'updateUsers']);

		return $acl;
	}
}