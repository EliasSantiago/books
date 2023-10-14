<?php

namespace App\Repositories;

interface BookRepositoryInterface
{
  public function index(): object;
  public function store(array $data): object;
}