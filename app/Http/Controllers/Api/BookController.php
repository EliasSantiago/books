<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BookNotFoundException;
use App\Exceptions\ItemNotFoundException;
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
    public function index(Request $request)
    {
        try {
            $books = $this->service->index(
                titulo: $request->titulo ?? "",
                titulo_do_indice: $request->titulo_do_indice ?? "",
                per_page: $request->per_page ?? 20
            );
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

    public function importIndex(Request $request, $bookId)
    {
        $xmlDataString = $request->getContent();
        $xmlData = simplexml_load_string($xmlDataString);

        if (!$xmlData->item->count()) {
            throw new ItemNotFoundException();
        }

        $this->service->importXml($xmlDataString, $bookId);
        return response()->json(['message' => 'Importação iniciada']);
    }
}
