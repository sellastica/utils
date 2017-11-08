<?php
namespace Sellastica\Utils;

/**
 * Numbers tools library
 */
class Numbers
{
	/**
	 * @param float $number
	 * @return float
	 */
	public static function clearRoundingError($number): float
	{
		return round($number, 10);
	}

	/**
	 * @param \DateTime $from1
	 * @param \DateTime $till1
	 * @param \DateTime $from2
	 * @param \DateTime $till2
	 * @return bool
	 */
	public static function areRangesCrossed(
		$from1 = null,
		$till1 = null,
		$from2 = null,
		$till2 = null
	): bool
	{
		$from1 = !is_null($from1) ? $from1 : -INF;
		$till1 = !is_null($till1) ? $till1 : INF;
		$from2 = !is_null($from2) ? $from2 : -INF;
		$till2 = !is_null($till2) ? $till2 : INF;

		return ($from1 == $from2)
			|| ($from1 > $from2 ? $from1 <= $till2 : $from2 <= $till1);
	}

	/**
	 * Convert bytes to human readable format
	 *
	 * @param int $bytes
	 * @param int $precision
	 * @return string
	 */
	public static function bytesToSize($bytes, $precision = 2): string
	{
		$bytes = (int)$bytes;
		$precision = (int)$precision;

		$kilobyte = 1024;
		$megabyte = $kilobyte * 1024;
		$gigabyte = $megabyte * 1024;
		$terabyte = $gigabyte * 1024;

		if (($bytes >= 0) && ($bytes < $kilobyte)) {
			return $bytes . ' B';

		} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
			return round($bytes / $kilobyte, $precision) . ' KB';

		} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
			return round($bytes / $megabyte, $precision) . ' MB';

		} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
			return round($bytes / $gigabyte, $precision) . ' GB';

		} elseif ($bytes >= $terabyte) {
			return round($bytes / $terabyte, $precision) . ' TB';
		} else {
			return $bytes . ' B';
		}
	}
}