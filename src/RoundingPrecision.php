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
}