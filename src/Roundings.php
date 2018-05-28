<?php
namespace Sellastica\Utils;

class Roundings
{
	/**
	 * @param float $number
	 * @param string|RoundingMode $mode
	 * @param string|RoundingPrecision $precision
	 * @return float
	 */
	public static function round(float $number, $mode, $precision): float
	{
		if ($precision instanceof RoundingPrecision) {
			$precision = $precision->getPrecision();
		} else {
			RoundingPrecision::assertPrecision($precision);
		}

		if ($mode instanceof RoundingMode) {
			$mode = $mode->getMode();
		} else {
			RoundingMode::assertMode($mode);
		}

		switch ($mode) {
			case RoundingMode::STATISTICAL:
				return self::roundStatistical($number, $precision);
				break;
			case RoundingMode::MATHEMATICALLY:
				return self::roundMathematically($number, $precision);
				break;
			case RoundingMode::UP:
				return self::roundUp($number, $precision);
				break;
			case RoundingMode::DOWN:
				return self::roundDown($number, $precision);
				break;
			default:
				return $number;
				break;
		}
	}

	/**
	 * Rounds number mathematically
	 *
	 * @param float $number
	 * @param string $precision
	 * @return float|int
	 */
	public static function roundMathematically(float $number, string $precision = RoundingPrecision::INTEGERS): float
	{
		RoundingPrecision::assertPrecision($precision);
		switch ($precision) {
			case RoundingPrecision::THOUSANDTH:
				return round($number, 3);
				break;
			case RoundingPrecision::HUNDREDTHS:
				return round($number, 2);
				break;
			case RoundingPrecision::TENTHS:
				return round($number, 1);
				break;
			case RoundingPrecision::TENS:
				return round($number / 10) * 10;
				break;
			case RoundingPrecision::HUNDREDS:
				return round($number / 100) * 100;
				break;
			case RoundingPrecision::THOUSANDS:
				return round($number / 1000) * 1000;
				break;
			default:
				return round($number);
				break;
		}
	}

	/**
	 * @param float $number
	 * @param string $precision
	 * @return float
	 */
	public static function roundStatistical(float $number, string $precision = RoundingPrecision::INTEGERS): float 
	{
		RoundingPrecision::assertPrecision($precision);
		switch ($precision) {
			case RoundingPrecision::THOUSANDTH:
				return round($number, 3, PHP_ROUND_HALF_EVEN);
				break;
			case RoundingPrecision::HUNDREDTHS:
				return round($number, 2, PHP_ROUND_HALF_EVEN);
				break;
			case RoundingPrecision::TENTHS:
				return round($number, 1, PHP_ROUND_HALF_EVEN);
				break;
			case RoundingPrecision::TENS:
				return round($number / 10, 0, PHP_ROUND_HALF_EVEN) * 10;
				break;
			case RoundingPrecision::HUNDREDS:
				return round($number / 100, 0, PHP_ROUND_HALF_EVEN) * 100;
				break;
			case RoundingPrecision::THOUSANDS:
				return round($number / 1000, 0, PHP_ROUND_HALF_EVEN) * 1000;
				break;
			default:
				return round($number, 0, PHP_ROUND_HALF_EVEN);
				break;
		}
	}

	/**
	 * @param float $number
	 * @param string $precision
	 * @return float|int
	 */
	public static function roundUp(float $number, string $precision = RoundingPrecision::INTEGERS): float
	{
		RoundingPrecision::assertPrecision($precision);
		switch ($precision) {
			case RoundingPrecision::THOUSANDTH:
				return ceil($number * 1000) / 1000;
				break;
			case RoundingPrecision::HUNDREDTHS:
				return ceil($number * 100) / 100;
				break;
			case RoundingPrecision::TENTHS:
				return ceil($number * 10) / 10;
				break;
			case RoundingPrecision::TENS:
				return ceil($number / 10) * 10;
				break;
			case RoundingPrecision::HUNDREDS:
				return ceil($number / 100) * 100;
				break;
			case RoundingPrecision::THOUSANDS:
				return ceil($number / 1000) * 1000;
				break;
			default:
				return ceil($number);
				break;
		}
	}

	/**
	 * @param float $number
	 * @param string $precision
	 * @return float|int
	 */
	public static function roundDown(float $number, string $precision = RoundingPrecision::INTEGERS): float
	{
		RoundingPrecision::assertPrecision($precision);
		switch ($precision) {
			case RoundingPrecision::THOUSANDTH:
				return floor($number * 1000) / 1000;
				break;
			case RoundingPrecision::HUNDREDTHS:
				return floor($number * 100) / 100;
				break;
			case RoundingPrecision::TENTHS:
				return floor($number * 10) / 10;
				break;
			case RoundingPrecision::TENS:
				return floor($number / 10) * 10;
				break;
			case RoundingPrecision::HUNDREDS:
				return floor($number / 100) * 100;
				break;
			case RoundingPrecision::THOUSANDS:
				return floor($number / 1000) * 1000;
				break;
			default:
				return floor($number);
				break;
		}
	}
}