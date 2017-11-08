<?php
namespace Sellastica\Utils;

use Nette;

class Validators extends Nette\Utils\Validators
{
	/**
	 * @param string $json
	 * @return bool
	 */
	public static function isJsonValid(string $json): bool
	{
		try {
			Nette\Utils\Json::decode($json);
			return true;
		} catch (Nette\Utils\JsonException $e) {
			return false;
		}
	}
}