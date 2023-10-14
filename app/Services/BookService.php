<?php

namespace App\Services;

use App\Exceptions\BookNotFoundException;
use App\Models\Indice;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookService
{
  private $repository;

  public function __construct(BookRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function index(): object
  {
    $books = $this->repository->index();

    if ($books->isEmpty()) {
      throw new BookNotFoundException('Nenhum livro encontrado.');
    }

    return $books;
  }

  public function store(array $data): object
  {
    try {
      $data['usuario_publicador_id'] = auth()->id();

      $book = $this->repository->store($data);

      $this->createIndices($data['indices'], $book);

      return $book;
    } catch (\Exception $e) {
      throw new \Exception('Erro ao criar índices: ' . $e->getMessage());
    }
  }

  protected function createIndices(array $indices, $book, $parentIndex = null)
  {
    foreach ($indices as $indexData) {
      $index = new Indice([
        'titulo' => $indexData['titulo'],
        'pagina' => $indexData['pagina'],
      ]);

      if ($parentIndex) {
        $index->indice_pai_id = $parentIndex->id;
      }

      $book->indices()->save($index);

      if (!empty($indexData['subindices'])) {
        $this->createIndices($indexData['subindices'], $book, $index);
      }
    }
  }
}
