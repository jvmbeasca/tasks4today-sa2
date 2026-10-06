<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'POST') {
            $username = trim((string) $this->request->getPost('username'));
            $password = (string) $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel
                ->where('username', $username)
                ->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->regenerate();

                session()->set([
                    'user_id'    => $user['id'],
                    'username'   => $user['username'],
                    'isLoggedIn' => true,
                ]);

                return redirect()->to('/tasks');
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        return view('auth/login', [
            'title' => 'Login',
        ]);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'You have been logged out.');
    }
}