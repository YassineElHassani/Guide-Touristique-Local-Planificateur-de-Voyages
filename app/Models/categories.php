<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriesFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];
    
    /**
     * Get the events that belong to this category.
     */
    public function events()
    {
        return $this->hasMany(events::class, 'category_id');
    }
}
