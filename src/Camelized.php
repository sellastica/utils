<?php
namespace Sellastica\Utils;

class Camelized
{
	/** @var string */
	private $value;

	/**
	 * @param string $value
	 * @throws \InvalidArgumentException
	 */
	public function __construct(string $value)
	{
		if (!preg_match('~^[a-z0-9_]+$~', $value)) {
			throw new \InvalidArgumentException(sprintf('Value "%s" does not match the pattern', $value));
		}

		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->value;
	}

	/**
	 * @param string $slug
	 * @return Camelized
	 */
	public static function create(string $slug): Camelized
	{
		return new self(Strings::slugify($slug, '_'));
	}
}