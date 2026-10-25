<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use Orderable;

    protected $fillable = ['path', 'caption', 'sort_order', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];
}
