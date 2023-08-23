<?php

namespace App\Supports;

use Dompdf\Dompdf;
use Dompdf\Options as PdfOptions;
use Exception;

/**
 *
 */
class Pdf
{
    /**
     * @var string
     */
    private $htmlContent;
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var string
     */
    private $size;
    /**
     * @var string
     */
    private $orientation;
    /**
     * @var Dompdf
     */
    private $pdf;

    /**
     * @param string $htmlContent
     * @param string $fileName
     * @param string $size
     * @param string $orientation
     * @throws Exception
     */
    public function __construct(string $htmlContent, string $fileName, string $size = "A4", string $orientation = "landscape")
	{
		$this->htmlContent = $htmlContent;
		$this->fileName = $fileName;
		$this->size = $size;
		$this->orientation = $orientation;
		$this->pdf = $this->preparePdf();
	}

    /**
     * @return void
     */
    public function render()
	{
		$this->pdf->stream($this->fileName, ['Attachment' => 0]);
	}

    /**
     * @param bool $vardump
     * @return void
     */
    public function debug(bool $vardump = false)
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_erros', 1);
		error_reporting(E_ALL);
		debug(error_get_last(), $vardump);
	}

    /**
     * @return Dompdf
     * @throws Exception
     */
    private function preparePdf(): Dompdf
	{
		$options = new PdfOptions();
		$options->set('isRemoteEnabled', TRUE);
        $tempDir = dirname(__DIR__, 2). '/assets/common/temp_pdf';

		if (!file_exists($tempDir) || !is_dir($tempDir)) {
			if (!mkdir($tempDir, 0755, true)) {
				throw new Exception("Could not create temp folder");
			}
		}

		$options->setTempDir($tempDir);

		$dompdf = new Dompdf($options);

		$dompdf->loadHtml($this->htmlContent);
		$dompdf->setPaper($this->size, $this->orientation);

		$dompdf->render();

		return $dompdf;
	}
}
