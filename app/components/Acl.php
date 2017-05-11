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

        $acl->addRole('guest');                             // nutné pro nette - role pokud je odhlášen

		$acl->addRole('administrator');
        $acl->addRole('owner', 'administrator');
        $acl->addRole('projectManager', 'owner');
        $acl->addRole('user', 'projectManager');



		/* seznam zdrojů */
		$acl->addResource('AdminModule');   // Administrace
		$acl->addResource('BaseModule');    // Základní modul

		/* seznam pravidel oprávnění (role, zdroj, operace) */
		/* stránky */
		$acl->allow('owner', 'AdminModule', ['view', 'viewUser','viewRisk','viewPhase','viewProject']);
		$acl->allow('owner', 'AdminModule', ['addUser', 'addPhase', 'addProject']);
		$acl->allow('owner','AdminModule', ['editUser', 'editPhase', 'editProject']);
		$acl->allow('owner', 'AdminModule', ['deleteUser', 'deletePhase', 'deleteProject']);
		$acl->allow('projectManager', 'AdminModule', ['view', 'viewUser','viewRisk','viewPhase','viewProject']);
		$acl->allow('projectManager', 'AdminModule', ['addRisk', 'addPhase', 'addProject']);
		$acl->allow('projectManager','AdminModule', ['editRisk', 'editPhase']);
		$acl->allow('projectManager', 'AdminModule', ['deleteRisk', 'deletePhase']);
		$acl->allow('user', 'AdminModule', ['view', 'viewRisk','viewPhase','viewProject']);
		$acl->allow('user', 'AdminModule', 'addRisk');

		$acl->deny('owner', 'AdminModule', 'addRisk');
		$acl->deny('owner','AdminModule', 'editRisk');
		$acl->deny('owner', 'AdminModule', 'deleteRisk');
		$acl->deny('projectManager', 'AdminModule', 'addUser');
		$acl->deny('projectManager','AdminModule', 'editUser');
		$acl->deny('projectManager', 'AdminModule', 'deleteUser');
		$acl->deny('user', 'AdminModule', 'viewUser');
		$acl->deny('user', 'AdminModule', ['addUser', 'addPhase', 'addProject']);
		$acl->deny('user', 'AdminModule', ['deleteRisk', 'deletePhase', 'deleteProject']);

		/* superAdmin má práva na všechno */
		$acl->allow('administrator', Permission::ALL, Permission::ALL);

		return $acl;
	}
}