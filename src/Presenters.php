<?php
namespace Sellastica\Utils;

class Presenters
{
	/**
	 * @param string $name
	 * @return string Presenter name without module, e.g. Products, Homepage etc.
	 */
	public static function getShortName(string $name)
	{
		$name = Strings::removeFromEnd($name, ':');
		return substr($name, strrpos(':' . $name, ':'));
	}
}