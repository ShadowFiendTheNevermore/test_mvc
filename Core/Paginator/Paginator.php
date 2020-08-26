<?php

namespace ShadowFiend\Core\Paginator;

use ShadowFiend\Core\Exceptions\NotFoundException;

class Paginator
{

    protected $model;

    protected $per_page = 15;

    protected $page_index = 'page';

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
        $this->pagination['current_page'] = $page_number;
        $this->pagination['per_page'] = $this->per_page;
        $this->pagination['pages'] = (int) ceil(($this->pagination['count'] / $this->per_page));

        if ($page_number > $this->pagination['pages']) {
            return null;
        }

        $this->pagination['data'] = $this->model->select('*')
            ->skip($this->per_page * ($page_number - 1))
            ->take($this->per_page)->get();

        $this->pagination['next'] = $this->getNextPage();
        $this->pagination['previous'] = $this->getPreviousPage();
        $this->pagination['plain'] = $this->buildPlainPaginationLink($this->getQueries());

        return $this->pagination;
    }

    public function getNextPage()
    {
        $queries = $this->getQueries();
        $next = $this->pagination['pages'] !== $this->getQueries()[$this->page_index] ?
            $this->getQueries()[$this->page_index] + 1 :
            null;

        if (!$next) {
            return null;
        }

        $queries[$this->page_index] = $next;
        return $this->buildPaginationLink($queries);
    }

    public function getPreviousPage()
    {
        $queries = $this->getQueries();
        $previous = $this->pagination['current_page'] !== 1 ?
            $queries[$this->page_index] - 1 :
            null;

        if (!$previous) {
            return null;
        }

        $queries[$this->page_index] = $previous;
        return $this->buildPaginationLink($queries);
    }

    public function buildPlainPaginationLink($queries)
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);
        unset($queries[$this->page_index]);

        return $uri['path'] . '?' . http_build_query($queries) . '&page=';
    }

    protected function buildPaginationLink($queries)
    {
        return parse_url($_SERVER['REQUEST_URI'])['path'] . '?' . http_build_query($queries);
    }

    public function getQueries()
    {
        parse_str($_SERVER['QUERY_STRING'], $queries);

        if (!isset($queries[$this->page_index]))
            $queries[$this->page_index] = 1;

        $queries[$this->page_index] = (int) $queries[$this->page_index];

        return $queries;
    }
}
