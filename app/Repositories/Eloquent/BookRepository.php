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

  public function index(string $titulo = '', string $titulo_do_indice = '', int $per_page): object
  {
    $books = $this->model
      ->where(function ($query) use ($titulo, $titulo_do_indice) {
        if ($titulo) {
          $query->where('titulo', 'like', "%{$titulo}%");
        }
        if ($titulo_do_indice) {
          $query->orWhereHas('indices', function ($query) use ($titulo_do_indice) {
            $query->where('titulo', 'like', "%{$titulo_do_indice}%");
          });
        }
      })
      ->with([
        'user' => function ($query) {
          $query->select('id', 'name');
        },
        'indices',
      ])
      ->paginate($per_page);
    return $books;
  }

  public function store(array $data): object
  {
    return $this->model->create($data);
  }
}
