<?php

namespace App\Repositories;

interface BookRepositoryInterface
{
  public function index(string $titulo, string $titulo_do_indice, int $per_page): object;
  public function store(array $data): object;
}