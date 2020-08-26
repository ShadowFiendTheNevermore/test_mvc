<?php

namespace App\Controllers;

use Valitron\Validator;
use App\Models\JobsModel;
use ShadowFiend\Core\View\View;
use ShadowFiend\Core\Controller\Controller;

class JobsController extends Controller
{

    protected $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new Validator($_POST);
        $this->validator->rule('required', ['email', 'username']);
        $this->validator->rule('email', 'email');
    }

    public function createform()
    {
        return View::make('job', ['notifications' => $this->getFlashSession(), 'action' => 'create']);
    }

    public function changeform()
    {
        $this->onlyAdminCheck();
        $job = JobsModel::findOrFail($this->get('job_id'));

        return View::make('job', ['notifications' => $this->getFlashSession(), 'action' => 'change', 'job' => $job]);
    }

    public function change()
    {
        $this->onlyAdminCheck();
        $job = JobsModel::findOrFail($this->get('job_id'));
        if (!$this->validator->validate()) {
            return $this->validateFailed($this->validator->errors(), '/jobs/change' . '?job_id=' . $job['id']);
        }

        if ($job->text !== $this->post('text')) {
            $job->is_changed = true;
        }

        $job->username = $this->post('username');
        $job->text = $this->post('text');
        $job->email = $this->post('email');
        $job->is_done = (bool) $this->post('is_done');

        $job->save();

        return $this->successedJob('job has been updated');
    }

    public function create()
    {
        if (!$this->validator->validate()) {
            return $this->validateFailed($this->validator->errors(), '/jobs/create');
        }

        $job = new JobsModel;
        $job->username = $this->post('username');
        $job->text = $this->post('text');
        $job->email = $this->post('email');
        $job->save();

        return $this->successedJob('job has been created');
    }

    public function successedJob(string $message = 'done')
    {
        $_SESSION['_flash']['messages'] = ['job' => [$message]];

        return header('Location: /');
    }
}
