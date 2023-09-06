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
 * @param Int $id
 * @param String $image
 * @return string|null
 */
function ucImage(Int $id, ?String $image): ?string
{
    if(empty($image) || is_null($image)) return null;

    return api() . "/images/res/courses/$id/$image";
}

/**
 * @param $duration
 * @return string
 */
function formatChapterDuration($duration)
{
    $durationMoment = DateTime::createFromFormat('H:i:s', $duration);
    $durationHours = $durationMoment->format('H');

    if ($durationHours > 0) {
        return $durationMoment->format('H:i') . ' horas';
    } else {
        return $durationMoment->format('i') . ' minutos';
    }
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
function debug($data, bool $dump = false, bool $die = true): void
{
	echo "<pre>";

	if ($dump == true)
		var_dump($data);
	else
		print_r($data);

	echo "</pre>";
    echo "<hr>";
    if($die) die();
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

/**
 * @param $addressObject
 * @param $linebreak
 * @param $tag
 * @return string
 */
function printAddress($addressObject, $linebreak = "-", $tag = "span")
{
	$street = (!empty($addressObject->Street)) ? $addressObject->Street : "";
	$number = (!empty($addressObject->Number)) ? $addressObject->Number : "s/n";
	$neighborhood = (!empty($addressObject->Neighborhood)) ? $addressObject->Neighborhood : "";
	$complement = (!empty($addressObject->Complement)) ? $addressObject->Complement : "";
	$zipCode = (!empty($addressObject->ZipCode)) ? "CEP: " . mask($addressObject->ZipCode, "#####-###") : "";

	if (is_object(@$addressObject->City)) {
		$city = $addressObject->City->Name;
		$state = mb_strtoupper($addressObject->City->State->Code);
	} else {
		$city = (!empty($addressObject->City)) ? $addressObject->City : "";
		$state = (!empty($addressObject->State)) ? $addressObject->State : "";
	}

	$address = "<{$tag}>{$street}, {$number}</{$tag}> - <{$tag}>{$neighborhood}</{$tag}> - <{$tag}>{$city} / {$state} </{$tag}> {$linebreak} <{$tag}>{$zipCode}</{$tag}>";


	return $address;
	// return mb_convert_case($address, MB_CASE_TITLE, 'UTF-8');
}

/**
 * @param $val
 * @param $mask
 * @return string
 */
function mask($val, $mask)
{
	$maskared = '';
	$k = 0;
	for ($i = 0; $i <= strlen($mask) - 1; $i++) {
		if ($mask[$i] == '#') {
			if (isset($val[$k]))
				$maskared .= $val[$k++];
		} else {
			if (isset($mask[$i]))
				$maskared .= $mask[$i];
		}
	}
	return $maskared;
}

/**
 * @param $file
 * @return false|string
 */
function getFileContent($file)
{
	return file_get_contents($file);
}

/**
 * @param $attachment
 * @param $theme
 * @return string
 */
function getFileIcon($attachment, $theme)
{
	$fileExtension = 'generic.png';
	$attachmentExtension = pathinfo($attachment, PATHINFO_EXTENSION);

	$assetDir = SITE["root"] . "/assets/{$theme}/images/file-icons/";
	$fileIconsDir = dirname(__DIR__, 2) . "/assets/{$theme}/images/file-icons/";
	$availableExtensions = [];

	$files = glob($fileIconsDir . '*.{png,jpg,jpeg,svg}', GLOB_BRACE);
	foreach ($files as $file) {
		$extension = pathinfo($file, PATHINFO_FILENAME);
		$availableExtensions[] = $extension;
	}

	if (in_array(trim($attachmentExtension), $availableExtensions)) {
		$fileExtension = $attachmentExtension . '.png';
	}

	$iconPath = $assetDir . $fileExtension;

	return $iconPath;
}

/**
 * @param $data
 * @return string
 * @throws Exception
 */
function dateConclusionCourse($data, $extenso = false)
{
    $dateTime = new DateTime($data);

    $dia = $dateTime->format('d');
    $mes = $dateTime->format('M');
    $ano = $dateTime->format('Y');

    if ($extenso) {
        $strMoth = array(
            'jan' => 'janeiro',
            'feb' => 'fevereiro',
            'mar' => 'março',
            'apr' => 'abril',
            'may' => 'maio',
            'jun' => 'junho',
            'jul' => 'julho',
            'aug' => 'agosto',
            'sep' => 'setembro',
            'oct' => 'outubro',
            'nov' => 'novembro',
            'dec' => 'dezembro'
        );
    } else {
        $strMoth = array(
            'jan' => 'jan',
            'feb' => 'fev',
            'mar' => 'mar',
            'apr' => 'abr',
            'may' => 'mai',
            'jun' => 'jun',
            'jul' => 'jul',
            'aug' => 'ago',
            'sep' => 'set',
            'oct' => 'out',
            'nov' => 'nov',
            'dec' => 'dez'
        );
    }

    if (array_key_exists(strtolower($mes), $strMoth)) {
        $mes = $strMoth[strtolower($mes)];
    }
    return ['dia' => $dia, 'mes' => $mes, 'ano' => $ano];
}

/**
 * @param string $Url
 * @return bool|void
 */
function verifyModule(string $url)
{
    if ($_SESSION['modules'] && !empty($_SESSION['modules']) !== null) {
        $modules = $_SESSION['modules'];

        foreach ($modules as $module) {
            if (isset($module->Url) && $module->Url === $url && $module->Visible) {
                return true;
            }
        }
    } else {
        header('Location:' . site() . "/ops/405");
    }
}

/**
 * @param $chapterProgress
 * @param $chapter
 * @return bool
 */
function showChapterQuiz($chapterProgress, $chapter)
{
    return !empty($chapterProgress) && $chapterProgress->IsFinished && $chapter->HasQuiz;
}