<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Category;
use App\SubCategory;

class SubCategoryController extends Controller
{
    public function show(Category $Category){
    	return view('SubCategory', [
			'Category' => $Category
		]);
    }

    public function store(Category $Category, Request $request){
    	$SubCategory = new SubCategory();
    	$SubCategory->SubCategory = $request->SubCategory;
    	$SubCategory->Category_id = $Category->id;
    	$SubCategory->save();
    	return redirect()->route('show', $Category);
    }

    public function delete(SubCategory $SubCategory){
    	$SubCategory->delete();
        return redirect()->route('show', $SubCategory->Category);
    }
}
