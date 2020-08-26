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
        $page_path = parse_url($_SERVER['REQUEST_URI'])['path'];
        $page_number = $this->get('page') ?? 1;
        $sort_direction = $this->get('sort_direction') ?? 'desc';

        $jobs = (new JobsModel)->sortBy($this->get('sort'), $sort_direction);
        $paginator = new Paginator;
        $paginator->setModel($jobs);
        $jobs = $paginator->paginate($page_number, 3);

        $jobs['filters'] = JobsModel::getFiltersForPage($page_path);
        $sort_direction = $sort_direction === 'desc' ? 'asc' : 'desc';
        $jobs['reverse_link'] = $page_path . '?' .
            http_build_query(array_merge($_GET, ['sort_direction' => $sort_direction]));

        return View::make('index', ['jobs' => $jobs, 'notifications' => $this->getFlashSession()]);
    }
}
