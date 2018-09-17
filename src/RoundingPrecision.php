<?php
namespace Sellastica\Utils;

class RoundingPrecision
{
	const THOUSANDTH = 'thousandth',
		HUNDREDTHS = 'hundredths',
		TENTHS = 'tenths',
		INTEGERS = 'integers',
		TENS = 'tens',
		HUNDREDS = 'hundreds',
		THOUSANDS = 'thousands';

	/** @var string */
	private $precision;


	/**
	 * @param string $precision
	 */
	private function __construct(string $precision)
	{
		$this->precision = $precision;
	}

	/**
	 * @return string
	 */
	public function getPrecision(): string
	{
		return $this->precision;
	}

	/**
	 * @return float
	 * @throws \UnexpectedValueException
	 */
	public function getExponent(): float
	{
		switch ($this->precision) {
			case self::THOUSANDTH:
				return 0.001;
				break;
			case self::HUNDREDTHS:
				return 0.01;
				break;
			case self::TENTHS:
				return 0.1;
				break;
			case self::INTEGERS:
				return 1;
				break;
			case self::TENS:
				return 10;
				break;
			case self::HUNDREDS:
				return 10;
				break;
			case self::THOUSANDS:
				return 1000;
				break;
			default:
				throw new \UnexpectedValueException('Unknown rounding exponent');
				break;
		}
	}

	/**
	 * @return int
	 */
	public function getFractionDigits(): int
	{
		switch ($this->precision) {
			case self::THOUSANDTH:
				return 3;
				break;
			case self::HUNDREDTHS:
				return 2;
				break;
			case self::TENTHS:
				return 1;
				break;
			case self::INTEGERS:
			case self::TENS:
			case self::HUNDREDS:
			case self::THOUSANDS:
				return 0;
				break;
			default:
				throw new \UnexpectedValueException('Unknown rounding exponent');
				break;
		}
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->precision;
	}

	/**
	 * @param string $precision
	 * @throws \InvalidArgumentException
	 */
	public static function assertPrecision(string $precision): void
	{
		if (!in_array($precision, [self::THOUSANDTH, self::HUNDREDTHS, self::TENTHS, self::INTEGERS, self::TENS,
			self::HUNDREDS, self::THOUSANDS])) {
			throw new \InvalidArgumentException(sprintf('Uknown rounding precision "%s"', $precision));
		}
	}

	/**
	 * @param string $precision
	 * @return RoundingPrecision
	 */
	public static function from(string $precision): RoundingPrecision
	{
		self::assertPrecision($precision);
		return new self($precision);
	}

	/**
	 * @return RoundingPrecision
	 */
	public static function integers(): RoundingPrecision
	{
		return new self(self::INTEGERS);
	}

	/**
	 * @return RoundingPrecision
	 */
	public static function hundredths(): RoundingPrecision
	{
		return new self(self::HUNDREDTHS);
	}
}