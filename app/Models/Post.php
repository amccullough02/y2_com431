<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model implements CanVisit
{
    use HasFactory;
    use SoftDeletes;
    use HasVisits;

    protected $fillable = [
        'title',
        'image_path',
        'cost',
    ];

    public function comments(): BelongsToMany {
        return $this->belongsToMany(Comment::class);
    }

}
