<?php

use App\Supports\Image;

/**
 * @param string|null $param
 * @return string
 */
function site(string $param = null): string
{
	if ($param && !empty(SITE[$param]))
		return SITE[$param];

	return SITE["root"];
}


/**
 * @return array
 */
function extractParamUrl(): stdClass
{
	$url = $_SERVER['REQUEST_URI'];
	$parsedUrl = parse_url($url);

	if (isset($parsedUrl['path'])) {
		$path = trim($parsedUrl['path'], '/');
		$params = explode('/', $path);
		return (object) $params;
	} else {
		return [];
	}
}

/**
 * @param string|null $param
 * @return string
 */
function api(string $param = null): string
{
	if ($param && !empty(API[$param]))
		return API[$param];

	return API["url"];
}

/**
 * @param $size
 * @param $text
 * @return string
 */
function placeholder($size, $text = null)
{
	if (!is_null($text)) {
		return "https://placehold.co/{$size}?text={$text}";
	}
	return "https://placehold.co/{$size}";
}

/**
 * @param $w Largura
 * @param $h Altura
 * @param $image Imagem
 * @param $text Texto
 * @return string|null
 */
function opImage($w, $h, $image = null, $text = null)
{
	$cropper = new Image("assets/web/images/cache", 75, 5, true);

	if (is_null($image)) {
		if (!is_null($text)) {
			$image = "https://placehold.co/{$w}x{$h}?text={$text}.jpg";
		} else {
			$image = "https://placehold.co/{$w}x{$h}.jpg";
		}
		return site() . '/' . $cropper->makeFromURL($image, $w, $h);
	}

	return site() . '/' . $cropper->makeFromURL($image, $w, $h);
}

/**
 * @param string $theme
 * @param string $path
 * @param bool $time
 * @param bool $returnPath
 * @return string
 */
function asset(string $theme, string $path, bool $time = true, bool $returnPath = false): string
{
	$file = SITE["root"] . "/assets/{$theme}/{$path}";
	$fileOnDir = dirname(__DIR__, 2) . "/assets/{$theme}/{$path}";
	if ($time && file_exists($fileOnDir)) {
		$file .= "?time=" . filemtime($fileOnDir);
	}

	return ($returnPath == true) ? $fileOnDir : $file;
	// return $file;
}

/**
 * @param $data
 * @param bool $dump
 * @return void
 */
function debug($data, bool $dump = false): void
{
	echo "<pre>";

	if ($dump == true)
		var_dump($data);
	else
		print_r($data);

	echo "</pre>";
	die();
}

/**
 * @param $doc
 * @return string
 */
function formatarCpf($doc)
{
	$doc = preg_replace("/[^0-9]/", "", $doc);
	$qtd = strlen($doc);

	if ($qtd >= 11) {

		$docFormatado = substr($doc, 0, 3) . '.' .
			substr($doc, 3, 3) . '.' .
			substr($doc, 6, 3) . '-' .
			substr($doc, 9, 2);

		return $docFormatado;
	} else {
		return 'Documento invalido';
	}
}

/**
 * @param $value
 * @param $showCurrency
 * @return string
 */
function printMoney($value = 0, $showCurrency = false)
{
	$currency = $showCurrency == true ? "R$ " : "";
	return $currency . number_format($value, 2, ',', '.');
}

/**
 * @param $date
 * @param $printTime
 * @return false|string
 */
function printDate($date, $printTime = true)
{
	$date = date_create($date);
	return $printTime == true ? date_format($date, 'd/m/Y') . " às " . date_format($date, 'H:i') : date_format($date, 'd/m/Y');
}

/**
 * @param $number
 * @return string
 */
function brandCsreditCard($number)
{
	$brands = array(
		"elo" => '/^4011(78|79)|^43(1274|8935)|^45(1416|7393|763(1|2))|^50(4175|6699|67[0-6][0-9]|677[0-8]|9[0-8][0-9]{2}|99[0-8][0-9]|999[0-9])|^627780|^63(6297|6368|6369)|^65(0(0(3([1-3]|[5-9])|4([0-9])|5[0-1])|4(0[5-9]|[1-3][0-9]|8[5-9]|9[0-9])|5([0-2][0-9]|3[0-8]|4[1-9]|[5-8][0-9]|9[0-8])|7(0[0-9]|1[0-8]|2[0-7])|9(0[1-9]|[1-6][0-9]|7[0-8]))|16(5[2-9]|[6-7][0-9])|50(0[0-9]|1[0-9]|2[1-9]|[3-4][0-9]|5[0-8]))/',
		"amex" => "/^3[47][0-9]{13}$/",
		"aura" => "/^((?!504175))^((?!5067))(^50[0-9])/",
		"diners" => "/^3(?:0[0-5]|[68][0-9])[0-9]/",
		"discover" => "/^6(?:011|5[0-9]{2})[0-9]{12}/",
		'visa'       => '/^4[0-9]{15}$/',
		'mastercard' => '/^(5[1-5]\d{4}|677189)\d{10}$/',
		'hipercard'  => '/^(606282\d{10}(\d{3})?)|(3841\d{15})$/',
	);

	$brand = 'undefined';

	foreach ($brands as $_brand => $regex) {
		if (preg_match($regex, $number)) {
			$brand = $_brand;
			break;
		}
	}

	return $brand;
}