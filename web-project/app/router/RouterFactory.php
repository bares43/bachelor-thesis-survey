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
			'action' => array(
				Route::VALUE => 'default',
				Route::FILTER_TABLE => array(
					'otazka' => 'question',
					'informace-o-respondentovi' => 'personal',
					'pokracovani-v-dotazniku' => 'continue',
					'zadne-dalsi-otazky' => 'noQuestions',
					'identifikace-webu' => 'final',
					'vysledky' => 'results',
					'novy-respondent' => 'newRespondent',
					'uzavreno' => 'close'
				)
			)
		));
		return $router;
	}

}
