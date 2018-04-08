<?php
namespace Sellastica\Utils;

/**
 * File tools library
 */
class Files
{
	/**
	 * @param string $filename
	 * @return bool
	 */
	public static function isFilenameValid(string $filename): bool
	{
		return preg_match('~^[a-z0-9\.\(\)_\-]+$~', $filename)
			&& strpos($filename, '..') === false;
	}

	/**
	 * @param string $fileName
	 * @return string
	 */
	public static function sanitizeFileName(string $fileName): string
	{
		$fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME) . ' ';
		$fileNameWithoutExtension = Strings::trim(Strings::webalize($fileNameWithoutExtension, '()_', false), '-');

		$extension = pathinfo($fileName, PATHINFO_EXTENSION);
		if (strpos($extension, '?') !== false) {
			$extension = Strings::before($extension, '?');
		}

		$extension = Strings::trim(Strings::webalize($extension, '_'), '-');

		return $fileNameWithoutExtension . '.' . $extension;
	}

	/**
	 * @param string $path
	 * @return bool
	 */
	public static function truncateDir(string $path): bool
	{
		if (!is_dir($path)) {
			return true;
		}

		$di = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);
		$ri = new \RecursiveIteratorIterator($di, \RecursiveIteratorIterator::CHILD_FIRST);
		foreach ($ri as $file) {
			$file->isDir() ? rmdir($file) : unlink($file);
		}

		return true;
	}

	/**
	 * @param string $filename
	 * @return string
	 */
	public static function extension(string $filename): string
	{
		return pathinfo($filename, PATHINFO_EXTENSION);
	}

	/**
	 * @param string $filename
	 * @return string
	 */
	public static function filename(string $filename): string
	{
		return pathinfo($filename, PATHINFO_FILENAME);
	}

	/**
	 * @param string $url
	 * @return \DateTime|null
	 */
	public static function filemtime(string $url): ?\DateTime
	{
		$headers = @get_headers($url, 1);
		if ($headers && strstr($headers[0], '200') !== false) {
			return new \DateTime($headers['Last-Modified']);
		}

		return null;
	}
}