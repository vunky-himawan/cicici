<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Authentication\Authentication;

class AuthController extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $auth = service('authentication');

        $credentials = [
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        if (!$auth->attempt($credentials)) {
            return $this->failUnauthorized('Invalid login credentials.');
        }

        $user = auth()->user();
        $token = $user->generateAccessToken('default')->raw_token;

        return $this->respond([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    public function me()
    {
        return $this->respond(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return $this->respond(['message' => 'Logged out successfully']);
    }
}