<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'Categories';
    protected $fillable = ['Category'];

    public function SubCategories()
    {
    	return $this->hasMany(SubCategory::class, 'Category_id');
    	// return $this->hasMany('App\SubCategory');
    }

    public function Category_score()
    {
    	return $this->hasMany(Category_score::class, 'Category_score_id');
    }
}
