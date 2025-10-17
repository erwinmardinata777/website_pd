<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkTerkait extends Model
{
    protected $fillable = [
        'judul',
        'link',
        'thumb',
    ];
}
