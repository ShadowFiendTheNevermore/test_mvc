<?php

namespace App\Controllers;

use App\Models\User;
use Valitron\Validator;
use ShadowFiend\Core\View\View;
use ShadowFiend\Core\Controller\Controller;

class AuthController extends Controller
{
	public function login()
	{
		$validator = new Validator($_POST);
		$validator->rule('required', ['email', 'password']);
		$validator->rule('email', 'email');

		if (!$validator->validate()) {
			return $this->validateFailed($validator->errors(), '/');
		}

		$user = User::where('email', $_POST['email'])->first();

		if (!$user) {
			return $this->validateFailed([
				'user' => ['user not found']
			], '/');
		}

		if (!password_verify($_POST['password'], $user->password)) {
			return $this->validateFailed([
				'user' => ['incorrect password']
			], '/');
		}

		return $this->loginUser($user);
	}

	public function regform()
	{
		return View::make('auth/reg_form', ['errors' => $this->getFlashSession()['errors']]);
	}

	public function register()
	{
		$validator = new Validator($_POST);
		$validator->rule('required', ['email', 'password', 'username']);
		$validator->rule('email', 'email');

		if (!$validator->validate()) {
			return $this->validateFailed($validator->errors(), '/auth/register');
		}

		$user = new User();
		$user->username = $this->post('username');
		$user->email    = $this->post('email');
		$user->password = password_hash($this->post('password'), PASSWORD_DEFAULT);
		$user->save();

		return $this->loginUser($user);
	}

	public function logout()
	{
		unset($_SESSION['user']);

		return header('Location: /');
	}

	private function loginUser($user)
	{
		$_SESSION['user'] = $user;
		return header('Location: /');
	}

	private function validateFailed($errors, $redirect_location)
	{
		$_SESSION['_flash']['errors'] = $errors;
		return header('Location:' . $redirect_location);
	}
}
