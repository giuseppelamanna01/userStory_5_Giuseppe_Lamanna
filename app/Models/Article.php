<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Article extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = [
        'title', 'price', 'description', 'category_id', 'user_id'
    ];
    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function category() : BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function setAccepted($value)
    {
        $this->is_accepted = $value;
        $this->save();
        return true;
    }

    public static function toBeRevisedCount()
    {
        return Article::where('is_accepted', null)->count();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category
        ];
    }

    public function images(): HasMany{
        return $this->hasMany(Image::class);
    }
}
