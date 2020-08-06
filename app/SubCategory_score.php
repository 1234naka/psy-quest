<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory_score extends Model
{
    protected $table = 'SubCategory_score';
    protected $fillable = ['SubCategory_score', 'SubCategory_id', 'user_id'];

    public function SubCategory_id()
    {
    	return $this->belongsTo(SubCategory::class, 'SubCategory_id');
    }
    public function Category_score_id()
    {
        return $this->belongsTo(Category_score::class, 'Category_score_id');
    }

    public function user_sub()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
