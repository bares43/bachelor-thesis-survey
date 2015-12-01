<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route("akce/<code>","Action:default");
		$router[] = new Route('<presenter>/<action>', array(
			'presenter' => array(
				Route::VALUE => 'Homepage',
				Route::FILTER_TABLE	=> array(
					'uvod'=>'Homepage',
					'dotaznik'=>'Survey',
					'nejlepsi-respondenti'=>'Highscore',
					'co-je-wireframe'=>'WhatIsWireframe',
					'napoveda'=>'Help',
					'o-projektu'=>'About',
					'kontakt'=>'Contact'
				)
			),
			'action' => 'default'
		));
		return $router;
	}

}
