<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use Orderable;

    protected $fillable = ['question', 'answer', 'sort_order', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];
}
