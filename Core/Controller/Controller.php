<?php

namespace ShadowFiend\Core\Controller;

use ShadowFiend\Core\Exceptions\AuthException;
use ShadowFiend\Core\Exceptions\NotFoundException;

class Controller
{
	protected $user;

	public function __construct()
	{
		$this->user = isset($this->session()['user']) ? $this->session()['user'] : null;
	}

	/**
	 * Return $_GET data
	 *
	 * @param string $key
	 * @return void
	 */
	protected function get(string $key)
	{
		if (isset($_GET[$key])) {
			return $this->escapeVar($_GET[$key]);
		}

		return null;
	}

	/**
	 * Return $_POST data
	 *
	 * @param string $key
	 * @return void
	 */
	protected function post(string $key)
	{
		if (isset($_POST[$key])) {
			return $this->escapeVar($_POST[$key]);
		}

		return null;
	}


	protected function session()
	{
		return $_SESSION;
	}

	public function getFlashSession()
	{
		$flash = $_SESSION['_flash'];

		$_SESSION['_flash'] = [
			'errors' => [],
			'messages' => []
		];

		return $flash;
	}


	/**
	 * Mini escaping html tags
	 *
	 * @param string $var
	 * @return string
	 */
	protected function escapeVar(string $var)
	{
		return htmlspecialchars($var);
	}

	protected function validateFailed($errors, $redirect_location)
	{
		$_SESSION['_flash']['errors'] = $errors;
		return header('Location:' . $redirect_location);
	}

	protected function isAdmin()
	{
		return isset($this->session()['user']) && $this->session()['user']['is_admin'];
	}

	public function onlyAdminCheck()
	{
		if (!$this->isAdmin())
			throw new AuthException("Only admin can do this");
		return;
	}
}
