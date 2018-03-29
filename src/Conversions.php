<?php
namespace Sellastica\Utils;

class Conversions
{
	/**
	 * @param mixed $object
	 * @return float|mixed
	 */
	public static function objectToFloat($object)
	{
		if (is_object($object) && method_exists($object, '__toString')) {
			return (float)$object->__toString();
		}

		return $object;
	}

	/**
	 * @param mixed $object
	 * @return float|mixed
	 */
	public static function objectToInt($object)
	{
		if (is_object($object) && method_exists($object, '__toString')) {
			return (int)$object->__toString();
		}

		return $object;
	}

	/**
	 * @param mixed $object
	 * @return float|mixed
	 */
	public static function objectToString($object)
	{
		if (is_object($object) && method_exists($object, '__toString')) {
			return (string)$object;
		}

		return $object;
	}

	/**
	 * Converts scalar, null, or object to string
	 *
	 * @param $string
	 * @return string|false
	 */
	public static function toString($string)
	{
		if (!isset($string)
			|| is_scalar($string)
			|| (is_object($string) && method_exists($string, '__toString'))) {
			return (string)$string;
		}

		return false;
	}

	/**
	 * Converts scalar or object to int
	 *
	 * @param $var
	 * @return int|false
	 */
	public static function toInt($var)
	{
		if (is_numeric($var)) {
			return (int)$var;
		} elseif (is_object($var) && method_exists($var, '__toInt')) {
			return $var->__toInt();
		} elseif (is_object($var) && method_exists($var, '__toFloat')) {
			return (int)$var->__toFloat();
		}

		return false;
	}

	/**
	 * Converts scalar or object to float
	 *
	 * @param $var
	 * @return float|false
	 */
	public static function toFloat($var)
	{
		if (is_numeric($var)) {
			return (float)$var;
		} elseif (is_object($var) && method_exists($var, '__toInt')) {
			return (float)$var->__toInt();
		} elseif (is_object($var) && method_exists($var, '__toFloat')) {
			return $var->__toFloat();
		}

		return false;
	}

	/**
	 * @param $var
	 * @return array|false
	 */
	public static function toArray($var)
	{
		if (is_array($var)) {
			return $var;
		} elseif ($var instanceof \Traversable) {
			return iterator_to_array($var);
		} elseif (is_null($var)) {
			return [];
		}

		return false;
	}
}