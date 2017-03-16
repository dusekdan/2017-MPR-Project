<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{
    use Nette\StaticClass;

    /**
     * router řadit od nejméně obecných (specifických) po nejvíce obecných, musí být malá písmena
     * defaultní hodnoty se nezobrazují potom v url
     * @return Nette\Application\IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList;
        $admin = new RouteList('Admin'); //vytvoření modulu (tváří se tak i v debugbaru)
        $admin[] = new Route('//%host%/[<locale=cs cs|en>/]administrace/<presenter>/<action>[/<id>]', [
            'presenter' => [
                Route::VALUE => 'Homepage', // default value
                Route::FILTER_TABLE => [
                    // řetězec v URL => presenter
	                'uzivatel' => 'User'
                ]
            ],
            'action' => [
                Route::VALUE => 'default',
                Route::FILTER_TABLE => [
                    // řetězec v URL => akce presenteru
	                'manazer' => 'users'
                ],
            ],
            'id' => NULL
        ]);

        $router[] = $admin;

        $base = new RouteList('Base');
        $base[] = new Route('//%host%/[<locale=cs cs|en>/]<presenter>/<action>[/<id>]', [
            'presenter' => [
                Route::VALUE => 'Homepage',
                Route::FILTER_TABLE => [
                    'uzivatel' => 'User'
                ],
            ],
            'action' => [
                Route::VALUE => 'default',
                Route::FILTER_TABLE => [
                    'vstup' => 'signIn'
                ],
            ],
            'id' => NULL,
        ]);

        $router[] = $base;

        return $router;
    }
}
