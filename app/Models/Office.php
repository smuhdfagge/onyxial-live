<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use Orderable;

    protected $fillable = ['name', 'address', 'phone', 'email', 'map_query', 'sort_order', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function telHref(): ?string
    {
        if (! $this->phone) {
            return null;
        }

        return 'tel:'.preg_replace('/[^0-9+]/', '', $this->phone);
    }
}
