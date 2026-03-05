<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnValue;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','content'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopeCategorySearch($query, $category_id){
        if(!empty($category_id)){
            return $query->where('category_id', $category_id);
        }
    }

    public function scopeKeywordSearch($query, $keyword){
        if(!empty($keyword)){
            return $query->where('content','LIKE','%'. $keyword . '%');
        }
        return $query;
    }
}
