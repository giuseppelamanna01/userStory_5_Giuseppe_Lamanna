<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
