<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BookNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBook;
use App\Models\Book;
use App\Models\Indice;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = $this->service->index();
            return $books;
        } catch (BookNotFoundException $e) {
            return $e->getMessage() ?? 500;
        } catch (\Exception $e) {
            return $e->getCode() ?? 500;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBook $request)
    {
        try {
            $validated = $request->validated();
            $book = $this->service->store($validated);

            return $book;
        } catch (\Exception $e) {
            return $e->getCode() ?? 500;
        }
    }
}
