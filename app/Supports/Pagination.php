<?php

namespace App\Supports;

/**
 *
 */
class Pagination
{
	/**
	 * @var
	 */
	protected $currentPage;
	/**
	 * @var
	 */
	protected $totalPages;
	/**
	 * @var int|mixed
	 */
	protected $range;

	/**
	 * @param $currentPage
	 * @param $totalPages
	 * @param $range
	 */
	public function __construct($currentPage, $totalPages, $range = 2)
	{
		$this->currentPage = $currentPage;
		$this->totalPages = $totalPages;
		$this->range = $range;
	}

	/**
	 * @return string
	 */
	public function getLinks()
	{
		$firstPage = 1;
		$lastPage = $this->totalPages;

		$paginate = "
            <nav aria-label='Page navigation'>
               <ul class='pagination m-0 p-0'>";

		if ($this->currentPage > $this->range + 1) {
			$paginate .= "<li class='page-item'><a class='page-link' href='?page=$firstPage'>Primeira</a></li>";
		}

		if ($this->currentPage > 1) {
			$paginate .= "<li class='page-item'><a class='page-link' href='?page=" . ($this->currentPage - 1) . "'>Anterior</a></li>";
		}

		for ($i = max($firstPage, $this->currentPage - $this->range); $i <= min($lastPage, $this->currentPage + $this->range); $i++) {
			if ($i === $this->currentPage) {
				$paginate .= "<li class='page-item active'><a class='page-link' href='?page=$i'>$i</a></li>";
			} else {
				$paginate .= "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
			}
		}

		if ($this->currentPage < $this->totalPages) {
			$paginate .= "<li class='page-item'><a class='page-link' href='?page=" . ($this->currentPage + 1) . "'>Próxima</a></li>";
		}

		if ($this->currentPage < $this->totalPages - $this->range) {
			$paginate .= "<li class='page-item'><a class='page-link' href='?page=$lastPage'>Última</a></li>";
		}
		$paginate .= "</ul>
                </nav>";

		if ($this->totalPages > 1)
			return $paginate;
		else
			return '';
	}
}
