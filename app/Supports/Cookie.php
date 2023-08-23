<?php

namespace App\Supports;

/**
 * Class Cookie
 *
 * @package App\Core
 */
class Cookie
{
	/**
	 * Cookie constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * @param $name
	 * @return null|mixed
	 */
	public function __get($name)
	{
		if (!empty($_COOKIE[$name])) {
			return $_COOKIE[$name];
		}
		return null;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function __isset($name)
	{
		return $this->has($name);
	}

	/**
	 * @return null|object
	 */
	public function all(): ?object
	{
		return (object)$_COOKIE;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return Cookie
	 */
	public function set(string $key, $value, mixed $expiration = null, bool $serialize = false): Cookie
	{
		$cookieValue = ($serialize) ? serialize($value) : $value;
		$cookieExpiration = ($expiration) ? $expiration : site("cookie_expiration");

		// Set the cookie with the given key and value
		setcookie(
			$key,
			$cookieValue,
			$cookieExpiration,
			'/',
			site("domain"),
			true,
			true
		);

		// Update the $_COOKIE superglobal to reflect the change immediately
		$_COOKIE[$key] = $value;

		return $this;
	}

	/**
	 * @param string $key
	 * @return Cookie
	 */
	public function unset(string $key): Cookie
	{
		// Remove the cookie with the given key
		setcookie($key, "", time() - 3600);

		// Update the $_COOKIE superglobal to reflect the change immediately
		unset($_COOKIE[$key]);

		return $this;
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return isset($_COOKIE[$key]);
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function empty(string $key): bool
	{
		return empty($_COOKIE[$key]);
	}
}
