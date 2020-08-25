<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    protected $table = 'users';

    public static function createAdmin()
    {
        $admin = new self();
        $admin->email = 'admin@admin.ru';
        $admin->password = password_hash('123', PASSWORD_DEFAULT);
        $admin->is_admin = true;
        $admin->username = 'admin';

        return $admin;
    }
}
