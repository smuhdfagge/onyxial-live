<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Orderable;

    protected $fillable = ['name', 'logo', 'url', 'sort_order', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];
}
