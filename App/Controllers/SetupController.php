<?php

namespace App\Controllers;

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
            $table->string('username');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });

        $schema->create('jobs', function ($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->integer('status')->default(0);
            $table->text('text')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        return 'setuped';
    }
}
