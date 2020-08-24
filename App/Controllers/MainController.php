<?php

namespace App\Controllers;

use App\Models\JobsModel;
use ShadowFiend\Core\View\View;
use ShadowFiend\Core\Paginator\Paginator;
use ShadowFiend\Core\Controller\Controller;

class MainController extends Controller
{
    public function index()
    {
        $page_number = $this->get('page') ?? 0;

        $paginator = new Paginator;
        $paginator->setModel(new JobsModel);

        $jobs = $paginator->paginate($page_number, 3);

        return View::make('index', ['jobs' => $jobs, 'notifications' => $this->getFlashSession()]);
    }
}
