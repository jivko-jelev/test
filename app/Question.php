<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content', 'answer', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
