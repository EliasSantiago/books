<?php

namespace App\Repositories\Eloquent;

use App\Models\User as Model;
use App\Repositories\AuthRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Hashing\Hasher;

class AuthRepository implements AuthRepositoryInterface
{
  private $model;
  private $hasher;

  public function __construct(Model $model, Hasher $hasher)
  {
    $this->model = $model;
    $this->hasher = $hasher;
  }

  public function register(array $data): ?object
  {
    return $this->model->create($data);
  }

  public function login(array $data): object
  {
    $user = $this->model->where('email', $data['email'])->first();

    if (!$user || !$this->hasher->check($data['password'], $user->password)) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $tokenResult = $user->createToken('api-books');
    $user['token_type'] = 'Bearer';
    $user['token'] = $tokenResult->accessToken;

    return $user;
  }
}
