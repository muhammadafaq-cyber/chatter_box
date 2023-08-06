<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->topics()->delete();
        });
    }
    public function topics(){
        return $this->hasMany(Topic::class);
    }



}
