<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indice extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'indice_pai_id', 'titulo', 'pagina'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function parentIndex()
    {
        return $this->belongsTo(Indice::class, 'indice_pai_id');
    }

    public function indexesChildren()
    {
        return $this->hasMany(Indice::class, 'indice_pai_id');
    }
}
