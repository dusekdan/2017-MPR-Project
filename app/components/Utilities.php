<?php
/**
 * Created by PhpStorm.
 * User: pick
 * Date: 16.02.2017
 * Time: 11:19
 */

declare(strict_types=1);

namespace App\Components;


class Utilities
{
	public function __construct()
	{

	}

	/**
	 * Převod pole na objekt abych k němu mohl lépe přistupovat
	 * @param $array
	 * @return object
	 */
	public function convertToObject($array)
	{
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$array[$key] = $this->convertToObject($value);
			}
		}

		return (object) $array;
	}
}