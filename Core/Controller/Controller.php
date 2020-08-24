<?php

namespace ShadowFiend\Core\Controller;

class Controller
{
	protected $user;

	public function __construct()
	{
		$this->user = isset($this->session()['user']) ? $this->session()['user'] : null;
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
}
