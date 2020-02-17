<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'Id';

    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo('App\Author', 'BooksAuthors', 'Id');
    }

    protected $fillable = ['Name', 'BooksAuthors'];
}
