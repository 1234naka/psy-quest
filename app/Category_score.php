<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_score extends Model
{
    protected $table = 'Category_score';
    protected $fillable = ['Category_score', 'Category_id', 'user_id'];

    public function Category_id()
    {
    	return $this->belongsTo(Category::class, 'Category_id');
    }

    public function SubCategory_score_id()
    {
        return $this->hasMany(Category_score::class, 'Category_score_id');
    }

    public function user_cate()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
