<?php
namespace Sellastica\Utils;

class RoundingMode
{
	const NONE = 'none',
		UP = 'up',
		DOWN = 'down',
		MATHEMATICALLY = 'mathematically';

	/** @var string */
	private $mode;


	/**
	 * @param string $mode
	 */
	private function __construct(string $mode)
	{
		$this->mode = $mode;
	}

	/**
	 * @return string
	 */
	public function getMode(): string
	{
		return $this->mode;
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->mode;
	}

	/**
	 * @param string $mode
	 * @throws \InvalidArgumentException
	 */
	public static function assertMode(string $mode): void
	{
		if (!in_array($mode, [self::NONE, self::UP, self::DOWN, self::MATHEMATICALLY])) {
			throw new \InvalidArgumentException(sprintf('Uknown rounding mode "%s"', $mode));
		}
	}

	/**
	 * @param string $mode
	 * @return RoundingMode
	 */
	public static function from(string $mode): RoundingMode
	{
		self::assertMode($mode);
		return new self($mode);
	}

	/**
	 * @return RoundingMode
	 */
	public static function none(): RoundingMode
	{
		return new self(self::NONE);
	}

	/**
	 * @return RoundingMode
	 */
	public static function mathematically(): RoundingMode
	{
		return new self(self::MATHEMATICALLY);
	}
}