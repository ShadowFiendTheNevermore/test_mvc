<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ShadowFiend\Core\Exceptions\NotFoundException;

class JobsModel extends Model
{

    const FILTER_FIELDS = [
        'username' => 'username',
        'is_done' => 'completed',
        'email' => 'email',
    ];

    protected $table = 'jobs';

    public function sortBy($field = null, $direction = 'desc')
    {
        if (isset($field)) {
            return $this->orderBy($field, $direction);
        }

        return $this;
    }

    public static function findOrFail($job_id)
    {
        $job = self::find($job_id);

        if (!$job) {
            throw new NotFoundException;
        }

        return $job;
    }

    public static function getFiltersForPage($page_path)
    {
        $filters = [];
        foreach (JobsModel::FILTER_FIELDS as $filterKey => $filterName) {
            $filters[$filterKey] = [
                'name' => $filterName,
                'link' => $page_path . '?' . http_build_query(array_merge($_GET, ['sort' => $filterKey]))
            ];
        }
        return $filters;
    }
}
