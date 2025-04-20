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

    // Methods
    public function addCategory()
    {
        return self::create([
            'name' => $this->name,
            'icon' => $this->icon,
        ]);
    }

    public function updateCategory()
    {
        return $this->update([
            'name' => $this->name,
            'icon' => $this->icon,
        ]);
    }
}
