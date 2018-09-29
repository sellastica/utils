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

	/**
	 * @param string $filename
	 * @return bool
	 */
	public static function isFilenameValid(string $filename): bool
	{
		return preg_match('~^[a-z0-9\.\(\)_\-]+$~i', $filename)
			&& strpos($filename, '..') === false;
	}

	/**
	 * @param string $url
	 * @return bool
	 */
	public static function isFtp(string $url): bool
	{
		return preg_match('#((ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $url);
	}
}