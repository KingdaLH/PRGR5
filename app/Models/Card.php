<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'imageName',
        'description',
        'user_id',
        'is_enabled'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

