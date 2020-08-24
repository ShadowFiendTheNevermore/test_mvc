<?php

namespace App\Controllers;

use App\Models\JobsModel;
use ShadowFiend\Core\View\View;
use ShadowFiend\Core\Controller\Controller;

class MainController extends Controller
{
    public function index()
    {
        return View::make('index', ['test' => 'testasdsad', 'notifications' => $this->getFlashSession()]);
    }
}
