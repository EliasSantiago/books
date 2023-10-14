<?php

namespace App\Repositories\Eloquent;

use App\Models\Book as Model;
use App\Repositories\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
  private $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function index(): object
  {
    return $this->model->paginate(20);
  }

  public function store(array $data): object
  {
    return $this->model->create($data);
  }
}