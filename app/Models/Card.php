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
        'category_id',
        'category_id_2',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
