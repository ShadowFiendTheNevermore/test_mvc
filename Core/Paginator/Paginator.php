<?php

namespace ShadowFiend\Core\Paginator;

use ShadowFiend\Core\Exceptions\NotFoundException;

class Paginator
{

    protected $model;

    protected $per_page = 15;

    protected $pagination = [
        'count'    => 0,
        'per_page' => 0,
        'pages'    => 0,
        'data'     => []
    ];

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function paginate(int $page_number = 1, int $per_page = null)
    {
        if (isset($per_page)) {
            $this->per_page = $per_page;
        }

        $this->pagination['count'] = $this->model->selectRaw('count(*) as count')->first()['count'];
        $this->pagination['per_page'] = $this->per_page;
        $this->pagination['pages'] = (int) ceil(($this->pagination['count'] / $this->per_page));
        $this->pagination['data'] = $this->model->select('*')->skip($this->per_page * $page_number)->take($this->per_page)->get();

        if ($page_number > $this->pagination['pages']) {
            throw new NotFoundException;
        }

        return $this->pagination;
    }
}
