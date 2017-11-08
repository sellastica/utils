<?php
namespace Sellastica\Utils;

/**
 * File tools library
 */
class Files
{
	/**
	 * @param string $fileName
	 * @return string
	 */
	public static function sanitizeFileName(string $fileName): string
	{
		$fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME) . ' ';
		$fileNameWithoutExtension = Strings::trim(Strings::webalize($fileNameWithoutExtension, '()_', false), '-');

		$extension = pathinfo($fileName, PATHINFO_EXTENSION);
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
}