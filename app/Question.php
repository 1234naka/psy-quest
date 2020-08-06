<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'Questions';
    protected $fillable = ['Question', 'SubCategory_id'];

    public function SubCategory()
    {
    	return $this->belongsTo(SubCategory::class, 'SubCategory_id');
    }
}
