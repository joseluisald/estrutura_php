<?php

namespace App\Supports;

use CoffeeCode\Cropper\Cropper;
use Extension;

/**
 *
 */
class Image extends Cropper
{
	/**
	 * @param string $cachePath
	 * @param int $quality
	 * @param int $compressor
	 * @param bool $webP
	 */
	public function __construct(string $cachePath, int $quality = 75, int $compressor = 5, bool $webP = false)
	{
		parent::__construct($cachePath, $quality, $compressor, $webP);
	}

	/**
	 * @param string $imageUrl
	 * @param int $width
	 * @param int|null $height
	 * @return string|null
	 */
	public function makeFromURL(string $imageUrl, int $width, int $height = null): ?string
	{
		$tempDir = "{$this->cachePath}/temp";

		if (!file_exists($tempDir) || !is_dir($tempDir)) {
			if (!mkdir($tempDir, 0755, true)) {
				throw new Exception("Could not create temp folder");
			}
		}

		$finalFileName = "$width-$height-" . $this->getNameImage($imageUrl);
		$finalFilePath = $tempDir . '/' . $finalFileName;

		if (!file_exists($finalFilePath)) {

			$imageData = file_get_contents($imageUrl);
			if ($imageData === false) {
				return "Failed to fetch image";
			}

			if (file_put_contents($finalFilePath, $imageData) === false) {
				return "Failed to save image";
			}
		} else {
			//            file_put_contents($finalFilePath, $this->createEmptyData());
		}
		return $this->make($finalFilePath, $width, $height);
	}

	/**
	 * @param $url
	 * @return string
	 */
	private function getNameImage($url)
	{
		$path = parse_url($url, PHP_URL_PATH);
		$nomeArquivo = basename($path);
		return $nomeArquivo;
	}

	/**
	 * @return false|string
	 */
	private function createEmptyData()
	{
		$largura = 1;
		$altura = 1;
		$imagem = imagecreatetruecolor($largura, $altura);
		$corFundo = imagecolorallocate($imagem, 255, 255, 255);
		imagefill($imagem, 0, 0, $corFundo);
		imagepng($imagem);
		$bytesImagem = ob_get_clean();
		return $bytesImagem;
	}
}
