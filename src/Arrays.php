<?php
namespace Sellastica\Utils;

class Arrays extends \Nette\Utils\Arrays
{
	/**
	 * @param array $array
	 * @return array
	 */
	public static function nullsToStrings(array $array): array
	{
		return array_map(function ($item) {
			return null !== $item ? $item : '';
		},
			$array
		);
	}

	/**
	 * @param array $array
	 * @return array
	 */
	public static function stringsToNulls(array $array): array
	{
		return array_map(function ($item) {
			return $item !== '' ? $item : null;
		},
			$array
		);
	}

	/**
	 * Converts string (e.g.) some.nested.string to multidimensional array
	 * @example
	 * $assoc = [];
	 * foreach ($fields as $field) {
	 *    Utilities\Arrays::assignArrayByPath($assoc, $field);
	 * }
	 * @param array $arr
	 * @param string $string
	 * @param mixed $value
	 * @param string $separator
	 */
	public static function arrayFromString(&$arr, $string, $value = null, $separator = '.'): void
	{
		$keys = explode($separator, $string);
		foreach ($keys as $key) {
			$arr = &$arr[$key];
		}

		$arr = $value;
	}

	/**
	 * Set an array item to a given value using "dot" notation.
	 * If no key is given to the method, the entire array will be replaced.
	 *
	 * @param  array $array
	 * @param  string $key
	 * @param  mixed $value
	 * @param string $separator
	 * @return mixed
	 */
	public static function set(&$array, $key, $value, string $separator = '.')
	{
		if (is_null($key)) {
			return $array = $value;
		}

		$keys = explode($separator, $key);

		while (count($keys) > 1) {
			$key = array_shift($keys);
			// If the key doesn't exist at this depth, we will just create an empty array
			// to hold the next value, allowing us to create the arrays to hold final
			// values at the correct depth. Then we'll keep digging into the array.
			if (!isset($array[$key]) || !is_array($array[$key])) {
				$array[$key] = [];
			}

			$array = &$array[$key];
		}

		$array[array_shift($keys)] = $value;
		return $array;
	}

	/**
	 * @param array $arr1
	 * @param array $arr2
	 * @param bool $identityCompare
	 * @return array
	 */
	public static function diff(array $arr1, array $arr2, bool $identityCompare = true): array
	{
		return array_udiff_assoc($arr1, $arr2, function ($val1, $val2) use ($identityCompare) {
			if (!$identityCompare
				&& is_object($val1)
				&& is_object($val2)
				&& ($val1 == $val2)
			) {
				return 0;
			} elseif ($identityCompare
				&& is_object($val1)
				&& is_object($val2)
				&& ($val1 === $val2)
			) {
				return 0;
			} elseif ($identityCompare
				&& $val1 === $val2) {
				return 0;
			} elseif (!$identityCompare
				&& $val1 == $val2) {
				return 0;
			}

			return 1;
		});
	}

	/**
	 * @param $array
	 * @param string $divider
	 * @param bool $capitalizeFirstCharacter
	 * @return array
	 */
	public static function keysToCamelCase(
		$array,
		string $divider = '_',
		bool $capitalizeFirstCharacter = false
	): array
	{
		$camel = [];
		foreach ($array as $key => $value) {
			$camel[Strings::toCamelCase($key, $divider, $capitalizeFirstCharacter)] = $value;
		}

		return $camel;
	}

	/**
	 * Searches needle in nested array of arrays or array of objects and return first corresponding KEY if successfull
	 * @example Search in array of objects, where (object->id = 5 && object->title = 'foo')
	 *
	 * @param array|object $haystack Array or traversable object
	 * @param array $filter Associative array
	 * @return mixed|null Null if unsuccessfull
	 */
	public static function search($haystack, array $filter)
	{
		return self::doSearch($haystack, $filter, true);
	}

	/**
	 * Searches needle in nested array of arrays or array of objects and return first corresponding VALUE if successfull
	 * @example Search in array of objects, where (object->id = 5 && object->title = 'foo')
	 *
	 * @param array|object $haystack Array or traversable object
	 * @param array $filter Associative array
	 * @return mixed|null Null if unsuccessfull
	 */
	public static function searchValue($haystack, array $filter)
	{
		return self::doSearch($haystack, $filter, false);
	}

	/**
	 * @param array|object $haystack Array or traversable object
	 * @param array $filter
	 * @param bool $returnKey
	 * @return mixed|null Null if unsuccessfull
	 */
	private static function doSearch($haystack, array $filter, bool $returnKey)
	{
		foreach ($haystack as $key => $nested) {
			$match = true;
			if (is_object($nested) && method_exists($nested, 'toArray')) {
				$array = $nested->toArray();
			} else {
				$array = (array)$nested;
			}

			foreach ($filter as $filterKey => $filterValue) {
				if (!array_key_exists($filterKey, $array) || $array[$filterKey] !== $filterValue) {
					$match = false;
					break;
				}
			}

			if (true === $match) {
				return $returnKey ? $key : $nested;
			}
		}

		return null;
	}

	/**
	 * Sorts multidimensional array recursively by the key
	 * @param array $array
	 */
	public static function ksort(array &$array): void
	{
		foreach ($array as $k => &$v) {
			if (is_array($v)) {
				self::ksort($v);
			}
		}

		ksort($array);
	}

	/**
	 * @param array $array
	 * @return array
	 */
	public static function filterNulls(array $array): array
	{
		return array_filter($array, function ($v) {
			return !is_null($v);
		});
	}

	/**
	 * @param array $array
	 * @return bool
	 */
	public static function isMultidimensional(array $array): bool
	{
		foreach ($array as $v) {
			if (is_array($v)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param array $array
	 * @return array
	 */
	public static function iUnique(array $array): array
	{
		return array_intersect_key(
			$array,
			array_unique(array_map('strtolower', $array))
		);
	}
}