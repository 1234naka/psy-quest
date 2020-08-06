<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'SubCategories';
    protected $fillable = ['SubCategory', 'Category_id'];

    public function Questions()
    {
    	return $this->hasMany(Question::class, 'SubCategory_id');
    }

    public function Category()
    {
    	return $this->belongsTo(Category::class, 'Category_id');
    	// return $this->belongsTo('App/Category');
    }

    public function SubCategory_score()
    {
        return $this->hasMany(SubCategory_score::class, 'SubCategory_score_id');
    }
}
