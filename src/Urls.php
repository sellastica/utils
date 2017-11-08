<?php
namespace Sellastica\Utils;

/**
 * Urls tools library
 */
class Urls
{
	/**
	 * @param $url
	 * @return bool
	 */
	public static function isUrl($url): bool
	{
		return (bool)filter_var($url, FILTER_VALIDATE_URL);
	}

	/**
	 * Removes percent encoding on reserved characters (used with + and # modifiers)
	 * @param string $string String to fix
	 * @return string
	 */
	public static function decodeReserved($string)
	{
		$search = [
			'%3A', '%2F', '%3F', '%23', '%5B', '%5D', '%40', '%21', '%24',
			'%26', '%27', '%28', '%29', '%2A', '%2B', '%2C', '%3B', '%3D'
		];
		$replace = [
			':', '/', '?', '#', '[', ']', '@', '!', '$', '&', '\'', '(', ')', '*', '+', ',', ';', '='
		];
		return str_replace($search, $replace, $string);
	}
}