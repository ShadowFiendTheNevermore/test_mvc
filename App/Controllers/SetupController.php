<?php

namespace App\Controllers;

use App\Models\User;
use ShadowFiend\Core\Controller\Controller;
use Illuminate\Database\Capsule\Manager as Capsule;

class SetupController extends Controller
{
    public function index()
    {
        $schema = Capsule::schema();
        $schema->create('users', function ($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('username')->unique();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });

        $schema->create('jobs', function ($table) {
            $table->increments('id');
            $table->string('email');
            $table->string('username');
            $table->integer('status')->default(0);
            $table->text('text')->nullable();
            $table->timestamps();
        });

        $admin = User::createAdmin();
        $admin->save();

        return header('Location: /');
    }
}
