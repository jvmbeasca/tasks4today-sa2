<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        return view('profile/index', [
            'title' => 'Profile',
            'user'  => $userModel->first(),
        ]);
    }
}