<?php
namespace Sellastica\Utils;

class Images
{
	private const PLACEHOLDER_DOMAIN = 'https://placehold.it';


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

		return self::PLACEHOLDER_DOMAIN . '/' . $width . 'x' . $height . '/f5f5f5?text=+';
	}

	/**
	 * @param string $url
	 * @return bool
	 */
	public static function isPlaceholderUrl(string $url): bool
	{
		return \Nette\Utils\Strings::startsWith($url, self::PLACEHOLDER_DOMAIN);
	}

	/**
	 * Returns placeholder URL if dimensions are unknown
	 * @return string
	 */
	public static function getDefaultPlaceholderUrl(): string
	{
		return self::getPlaceholderUrl(100, 100);
	}

	/**
	 * @param string $mimeType
	 * @return bool
	 */
	public static function isWebImage(string $mimeType): bool
	{
		return in_array($mimeType, [
			'image/png',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/bmp',
			'image/x-windows-bmp',
		]);
	}

	/**
	 * @param string $mimeType
	 * @return string
	 */
	public static function getExtensionByMimeType(string $mimeType): string
	{
		switch ($mimeType) {
			case 'image/png':
				return 'png';
				break;
			case 'image/jpeg':
			case 'image/pjpeg':
				return 'jpg';
				break;
			case 'image/gif':
				return 'gif';
				break;
			case 'image/bmp':
			case 'image/x-windows-bmp':
				return 'bmp';
				break;
			default:
				throw new \InvalidArgumentException("Unknown image mime type $mimeType");
				break;
		}
	}
}