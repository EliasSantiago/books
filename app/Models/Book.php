<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_publicador_id', 'titulo'];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_publicador_id');
    }

    public function indices()
    {
        return $this->hasMany(Indice::class, "book_id");
    }
}
