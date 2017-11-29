<?php
namespace Sellastica\Utils;

class ArrayObject implements \ArrayAccess, \IteratorAggregate, \Countable
{
	/**
	 * @param array|object $data
	 */
	public function __construct($data)
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function hasKey(string $key): bool
	{
		return property_exists($this, $key);
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return (array)$this;
	}

	/**
	 * @param mixed $key
	 * @return null
	 */
	public function __get($key)
	{
		return null;
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count((array) $this);
	}

	/**
	 * @param array $data
	 */
	public function modify(array $data)
	{
		foreach ($data as $property => $value) {
			$this->$property = $value;
		}
	}

	/**
	 * @param array $data
	 */
	public function remove(array $data)
	{
		foreach ($data as $property => $value) {
			unset($this->$property);
		}
	}

	/**
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this);
	}

	/**
	 * @param mixed $nm
	 * @param mixed $val
	 */
	public function offsetSet($nm, $val)
	{
		$this->$nm = $val;
	}

	/**
	 * @param mixed $nm
	 * @return mixed|null
	 */
	public function offsetGet($nm)
	{
		return $this->$nm;
	}

	/**
	 * @param mixed $nm
	 * @return bool
	 */
	public function offsetExists($nm)
	{
		return isset($this->$nm);
	}

	/**
	 * @param mixed $nm
	 */
	public function offsetUnset($nm)
	{
		unset($this->$nm);
	}

	/**
	 * @param array|object $data
	 * @return self|mixed
	 */
	public static function from($data): self
	{
		return new self($data);
	}
}
