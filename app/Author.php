<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = ['Name'];
}
