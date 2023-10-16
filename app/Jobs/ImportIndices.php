<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Indice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportIndices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $xml;
    protected $bookId;

    public function __construct($xml, $bookId)
    {
        $this->xml = $xml;
        $this->bookId = $bookId;
    }

    public function handle()
    {
        $xmlData = simplexml_load_string($this->xml);
        $book = Book::findOrFail($this->bookId);
        $this->saveItem($book, $xmlData->item);
    }

    public function saveItem(Book $book, $items, $parentIndex = null)
    {
        foreach ($items as $item) {
            $index = new Indice([
                'titulo' => (string) $item['titulo'],
                'pagina' => (int) $item['pagina'],
            ]);

            if ($parentIndex) {
                $index->indice_pai_id = $parentIndex->id;
            }

            $book->indices()->save($index);

            if (isset($item->item) && count($item->item) > 0) {
                $this->saveItem($book, $item->item, $index);
            }
        }
    }
}
