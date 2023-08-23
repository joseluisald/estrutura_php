<?php

namespace App\Supports;

/**
 * Class Input
 */
class Input
{
	/**
	 * @return array|mixed|null
	 * Método para obter dados enviados via POST no formato JSON
	 */
	public function post()
	{
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$payload = file_get_contents('php://input');
			$data = json_decode($payload, true);

			$data = $this->sanitizeArray($data);

			return $data;
		}
		return null;
	}

	/**
	 * @return array|mixed|null
	 * Método para obter dados enviados via GET
	 */
	public function get()
	{
		if ($_SERVER["REQUEST_METHOD"] === "GET") {
			$data = $_GET;

			$data = $this->sanitizeArray($data);

			return $data;
		}
		return null;
	}

	/**
	 * @return array|mixed|null
	 * Método para obter dados enviados via PUT no formato JSON
	 */
	public function put()
	{
		if ($_SERVER["REQUEST_METHOD"] === "PUT") {
			$payload = file_get_contents('php://input');
			$data = json_decode($payload, true);

			$data = $this->sanitizeArray($data);

			return $data;
		}
		return null;
	}

	/**
	 * @return array|mixed|null
	 *  Método para obter dados enviados via DELETE no formato JSON
	 */
	public function delete()
	{
		if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
			$payload = file_get_contents('php://input');
			$data = json_decode($payload, true);

			$data = $this->sanitizeArray($data);

			return $data;
		}
		return null;
	}

	/**
	 * @param $key
	 * @return mixed
	 * Método para obter um valor específico do array $_POST
	 */
	public function postValue($key)
	{
		return filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	/**
	 * @param $key
	 * @return mixed
	 *  Método para obter um valor específico do array $_GET
	 */
	public function getValue($key)
	{
		return filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	/**
	 * @param $key
	 * @return mixed
	 * Método para obter um valor específico do array $_REQUEST
	 */
	public function requestValue($key)
	{
		return filter_input(INPUT_REQUEST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	/**
	 * @param $key
	 * @return mixed
	 *  Método para obter um valor específico do array $_SERVER
	 */
	public function serverValue($key)
	{
		return filter_input(INPUT_SERVER, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	/**
	 * @param string $param
	 * @param array $values
	 * @return void
	 * Função para retornar dados após uma requisisção Ajax
	 */
	public function ajaxResponse(string $param, array $values): void
	{
		echo json_encode([$param => $values]);
	}

	/**
	 * @param string $message
	 * @return mixed
	 * @throws \Exception
	 */
	public function exception(string $message)
	{
		throw new \Exception($message);
	}

	/**
	 * @param $data
	 * @return array|mixed
	 * Função para filtrar um array recursivamente usando FILTER_SANITIZE_FULL_SPECIAL_CHARS
	 */
	private function sanitizeArray($data)
	{
		if (is_array($data)) {
			return array_map(array($this, 'sanitizeArray'), $data);
		}

		return filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
}
