<?php
namespace Sellastica\Utils;

class Images
{
	/**
	 * @param string $fileName
	 * @param string $path
	 */
	public static function removeImagesByName($fileName, $path)
	{
		foreach (\Nette\Utils\Finder::findFiles($fileName)->from($path) as $file) {
			@unlink($file);
		}
	}

	/**
	 * @param string $path
	 * @return string
	 */
	public static function toBase64(string $path): string
	{
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		return 'data:image/' . $extension . ';base64,' . base64_encode($data);
	}

	/**
	 * @param int|null $width
	 * @param int|null $height
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	public static function getPlaceholderUrl(?int $width, ?int $height): string 
	{
		if (!$width && !$height) {
			throw new \InvalidArgumentException('Width or height must be defined');
		} elseif (!$width || !$height) { //both dimensions must be defined, so lets make a square
			$width = $height = max($width, $height);
		}

		return 'https://placehold.it/' . $width . 'x' . $height . '/f5f5f5?text=no+image';
	}

	/**
	 * Returns placeholder URL if dimensions are unknown
	 * @return string
	 */
	public static function getDefaultPlaceholderUrl(): string
	{
		return self::getPlaceholderUrl(100, 100);
	}
}