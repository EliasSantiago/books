<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterUser $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = bcrypt($validated['password']);
            $user = $this->service->register($validated);
            return $user;
        } catch (\Exception $e) {
            return $e->getCode() ?? 500;
        }
    }

    public function login(LoginUser $request)
    {
        try {
            $data = $request->validated();
            $user = $this->service->login($data);
            return $user;
        } catch (AuthenticationException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getCode() ?? 500;
        }
    }
}
