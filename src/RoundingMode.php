<?php
namespace Sellastica\Utils;

class RoundingMode
{
	const NONE = 'none',
		UP = 'up',
		DOWN = 'down',
		MATHEMATICALLY = 'mathematically',
		STATISTICAL = 'statistical',
		BATA = 'bata';

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
	 * @return bool
	 */
	public function isNone(): bool
	{
		return $this->mode === self::NONE;
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
		$rc = new \ReflectionClass(self::class);
		if (!in_array($mode, $rc->getConstants())) {
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