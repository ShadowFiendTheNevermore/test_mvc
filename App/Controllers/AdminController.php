<?php

namespace App\Controllers;

use ShadowFiend\Core\Controller\Controller;

class AdminController extends Controller
{

	public function index()
	{
		return header('Location: /');
		// if ($this->session()['user']['type'] !== 'admin') {

		// }

		// return View::make('dashboard/index', ['reviews' => $reviews]);
	}
}
