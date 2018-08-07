<?php
namespace Sellastica\Utils;

/**
 * Strings tools library
 */
class Strings extends \Nette\Utils\Strings
{
	/**
	 * Returns the string rest after the first occurrunce of the char
	 *
	 * @param string $string
	 * @param string $char
	 * @return string
	 */
	public static function afterFirstChar(string $string, string $char): string
	{
		return false !== strpos($string, $char)
			? substr($string, strpos($string, $char) + strlen($char), strlen($string))
			: $string;
	}

	/**
	 * Returns the string rest after the last occurrunce of the char
	 *
	 * @param string $string
	 * @param string $char
	 * @return string
	 */
	public static function afterLastChar(string $string, string $char): string
	{
		return false !== strrpos($string, $char)
			? substr($string, strrpos($string, $char) + strlen($char), strlen($string))
			: $string;
	}

	/**
	 * Returns the string from beginning to the first occurrunce of the char
	 *
	 * @param string $string
	 * @param string $char
	 * @return string
	 */
	public static function beforeFirstChar(string $string, string $char): string
	{
		return false !== strpos($string, $char)
			? substr($string, 0, strpos($string, $char))
			: $string;
	}

	/**
	 * Returns the string from beginning to the last occurrunce of the char
	 *
	 * @param string $string
	 * @param string $char
	 * @return string
	 */
	public static function beforeLastChar(string $string, string $char): string
	{
		return false !== strpos($string, $char)
			? substr($string, 0, strrpos($string, $char))
			: $string;
	}

	/**
	 * Returns the string cropped of the char from the end
	 *
	 * @param string $string
	 * @param string $charToRemove
	 * @return string
	 */
	public static function removeFromEnd(string $string, string $charToRemove): string
	{
		$sPattern = '~' . preg_quote($charToRemove) . '+$~';
		return preg_replace($sPattern, '', $string);
	}

	/**
	 * Returns the string cropped of the char from the beginning
	 *
	 * @param string $string
	 * @param string $charToRemove
	 * @return string
	 */
	public static function removeFromBeginning(string $string, string $charToRemove): string
	{
		$sPattern = '~^' . preg_quote($charToRemove) . '+~';
		return preg_replace($sPattern, '', $string);
	}

	/**
	 * @param string $search
	 * @param $replace
	 * @param string $subject
	 * @return string
	 */
	public static function replaceLast(string $search, $replace, string $subject): string
	{
		$pos = strrpos($subject, $search);
		if ($pos !== false) {
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}

		return $subject;
	}

	/**
	 * Explodes full name and tries to detect first name, last name and sex (in czech language)
	 *
	 * @param string $fullName
	 * @param bool $lastNameFirst
	 * @return array
	 */
	public static function explodeFullName(string $fullName, bool $lastNameFirst = false): array
	{
		$nameProperties = [
			'firstName' => null,
			'lastName' => null,
			'sex' => null,
		];
		$firstNameIndex = $lastNameFirst ? 1 : 0;
		$lastNameIndex = $lastNameFirst ? 0 : 1;

		//replace all whitespaces to spaces
		$fullName = trim(preg_replace('/\s+/', ' ', $fullName));

		if ($fullName != '' && \Nette\Utils\Strings::contains($fullName, ' ')) {
			$nameArray = explode(' ', $fullName);
			$nameProperties['firstName'] = \Nette\Utils\Strings::firstUpper(\Nette\Utils\Strings::lower($nameArray[$firstNameIndex]));
			$nameProperties['lastName'] = \Nette\Utils\Strings::firstUpper(\Nette\Utils\Strings::lower($nameArray[$lastNameIndex]));
		}

		return $nameProperties;
	}

	/**
	 * Returns stop words for searching in defined language
	 *
	 * @param string $localization
	 * @return array
	 */
	public static function getStopwords(string $localization): array
	{
		switch ($localization) {
			case 'cs_CZ':
				$array = ['a', 'aby', 'aj', 'ale', 'anebo', 'ani', 'aniz', 'ano', 'asi', 'az', 'ba', 'bez', 'by', 'ci', 'co',
					'coz', 'do', 'ho', 'i', 'jak', 'jake', 'jako', 'je', 'jeho', 'jej', 'jeji', 'jejich', 'jen', 'jeste',
					'jenz', 'ji', 'jine', 'jiz', 'jsem', 'jses', 'jsi', 'jsme', 'jsou', 'jste', 'k', 'kam', 'kde', 'kdo',
					'kdyz', 'ke', 'ktera', 'ktere', 'kteri', 'kterou', 'ktery', 'ku', 'ma', 'mate', 'me', 'mezi', 'mi', 'mit',
					'mne', 'mnou', 'muj', 'muze', 'my', 'na', 'nad', 'nam', 'nas', 'nasi', 'ne', 'nebo', 'nebot', 'necht',
					'nejsou', 'není', 'neni', 'net', 'nez', 'ni', 'nic', 'nove', 'novy', 'nybrz', 'o', 'od', 'ode', 'on',
					'pak', 'po', 'pod', 'podle', 'pokud', 'pouze', 'prave', 'pred', 'pres', 'pri', 'pro', 'proc', 'proto',
					'protoze', 's', 'se', 'si', 'sice', 'sve', 'svuj', 'svych', 'svym', 'svymi', 'ta', 'tak', 'take', 'takze',
					'tamhle', 'tato', 'tedy', 'tema', 'te', 'ten', 'tedy', 'tento', 'teto', 'tim ', 'timto', 'to', 'tohle',
					'toho', 'tohoto', 'tom', 'tomto', 'tomuto', 'totiz', 'tu', 'tudiz', 'tuto', 'tvuj', 'ty', 'tyto', 'u',
					'uz', 'v', 'vam', 'vas', 'vas', 'vase', 've', 'vedle', 'vice', 'vsak', 'vy', 'vzdyt', 'z', 'za', 'zda',
					'zde', 'ze',
				];
				break;
			case 'sk_SK':
				$array = ['a', 'aby', 'aj', 'ako', 'ale', 'alebo', 'ani', 'ano', 'asi', 'az', 'bez', 'bud', 'by', 'cez',
					'ci', 'co', 'ešte', 'ho', 'i', 'iba', 'ich', 'ja', 'je', 'jeho', 'jej', 'ju', 'k', 'kam', 'kde', 'ked',
					'kto', 'ku', 'menej', 'mi', 'moja', 'moje', 'moj', 'my', 'nad', 'nam', 'nez', 'nic', 'nie', 'o', 'od',
					'on', 'on', 'ona', 'ona', 'oni', 'ono', 'po', 'pod', 'podla', 'pokial', 'potom', 'prave', 'preco',
					'pred', 'preto', 'pretoze', 'pri', 's', 'sa', 'si', 'sme', 'so', 'som', 'ste', 'su', 'ta', 'tak',
					'takze', 'tam', 'tato', 'teda', 'ten', 'tento', 'tieto', 'tiez', 'to', 'toho', 'tom', 'tomto', 'toto',
					'tu', 'túto', 'ty', 'tym', 'tymto', 'uz', 'v', 'vam', 'viac', 'vo', 'vsak', 'vy', 'z', 'za', 'zo',
				];
				break;
			case 'en_US':
				$array = ['I', 'a', 'about', 'an', 'are', 'as', 'at', 'be', 'by', 'com', 'for', 'from', 'how', 'in', 'is',
					'it', 'of', 'on', 'or', 'that', 'the', 'this', 'to', 'was', 'what', 'when', 'where', 'who', 'will',
					'with', 'the', 'www',
				];
				break;
			default:
				$array = [];
				break;
		}

		return $array;
	}

	/**
	 * @param string $string
	 * @return string
	 */
	public static function removeSpaces(string $string): string
	{
		return trim(preg_replace('/\s+/', '', $string));
	}

	/**
	 * @param mixed $stringOrClass
	 * @return int
	 */
	public static function intify($stringOrClass): int
	{
		return (int)(string)$stringOrClass;
	}

	/**
	 * @param mixed $stringOrClass
	 * @return float
	 */
	public static function floatify($stringOrClass): float
	{
		return (float)(string)$stringOrClass;
	}

	/**
	 * @param string $email
	 * @return string
	 */
	public static function antispam(string $email): string
	{
		return str_replace('@', '&#64;', (string)$email);
	}

	/**
	 * @param string $string
	 * @param string $replacement
	 * @return string
	 */
	public static function fromCamelCase(string $string, string $replacement = '_'): string
	{
		return ltrim(strtolower(preg_replace('/[A-Z]/', "$replacement$0", $string)), $replacement);
	}

	/**
	 * @param string $string
	 * @param string $replacement
	 * @return string
	 */
	public static function toSnakeCase(string $string, string $replacement = '_'): string
	{
		return ltrim(strtolower(preg_replace('/[^a-zA-Z0-9]/', "$replacement", $string)), $replacement);
	}

	/**
	 * @param string $string
	 * @param string $divider
	 * @param bool $capitalizeFirstCharacter
	 * @return string
	 */
	public static function toCamelCase(
		string $string,
		string $divider = '_',
		$capitalizeFirstCharacter = false
	): string
	{
		$str = str_replace(' ', '', ucwords(str_replace($divider, ' ', $string)));
		if (!$capitalizeFirstCharacter) {
			$str = lcfirst($str);
		}

		return $str;
	}

	/**
	 * @param $param
	 * @param string $type
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public static function convertToType($param, string $type)
	{
		switch ($type) {
			case 'string':
				return (string)$param;
				break;
			case 'int':
				return (int)$param;
				break;
			case 'float':
				return (float)$param;
				break;
			case 'bool':
				return (bool)$param;
				break;
			case 'array':
				return (array)$param;
				break;
			case 'object':
				return (object)$param;
				break;
			default:
				throw new \InvalidArgumentException("Unknown type $type");
				break;
		}
	}

	/**
	 * Converts to web safe characters [a-z0-9-] text.
	 * @param string $s UTF-8 encoding
	 * @param string $divider
	 * @param string $charlist allowed characters
	 * @param bool $lower
	 * @return string
	 */
	public static function slugify(
		string $s,
		string $divider = '-',
		string $charlist = null,
		bool $lower = true
	): string
	{
		$s = self::toAscii($s);
		if ($lower) {
			$s = strtolower($s);
		}

		$s = preg_replace('#[^a-z0-9' . ($charlist !== null ? preg_quote($charlist, '#') : '') . ']+#i', $divider, $s);
		$s = trim($s, '-');
		return $s;
	}

	/**
	 * @param string $string
	 * @param string $tag
	 * @param bool $need If FALSE, return whole string, if tag is not found
	 * @return string
	 */
	public static function tagContent(string $string, string $tag, bool $need = false): string
	{
		if ($need || (stripos($string, "<$tag") !== false)) {
			preg_match("~<$tag.*?>(.*?)<\/$tag>~is", $string, $match);
			return $match[1];
		} else {
			return $string;
		}
	}

	/**
	 * @param string $slug
	 * @param string $divider
	 * @param bool $capitalizeFirstCharacter
	 * @return string
	 */
	public static function toWords(
		string $slug,
		string $divider = '_',
		bool $capitalizeFirstCharacter = false
	): string
	{
		$string = str_replace($divider, ' ', $slug);
		return $capitalizeFirstCharacter
			? ucfirst($string)
			: $string;
	}

	/**
	 * @param string $string
	 * @return bool
	 */
	public static function isAlphanumeric(string $string): bool
	{
		return (bool)preg_match('~^[\w]*$~', $string);
	}
}