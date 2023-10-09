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
    ];

    public function primaryCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function secondaryCategories()
    {
        return $this->belongsToMany(Category::class, 'card_category');
    }

}

