<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\SubCategory;
use App\Category;
use App\Question;

class QuestionController extends Controller
{
    public function show(SubCategory $SubCategory){
    	return view('Question', [
			'SubCategory' => $SubCategory
		]);
    }

    public function delete(Question $Question){
    	$Question->delete();
        $Category = $Question->SubCategory->Category;
    	return redirect()->route('show', $Category);
    }

    public function store(SubCategory $SubCategory, Request $request){
    	$Question = new Question();
    	$Question->Question = $request->Question;
        $Question->order = $request->order;
    	$SubCategory->Questions()->save($Question);
        $Category = $SubCategory->Category;
    	// $Question->SubCategory_id = $request->SubCategory_id;
    	// $Question->save();
    	return redirect()->route('show', $Category);
    }

    public function edit(Question $Question, Request $request){
        $Question->Question = $request->Question;
        $Question->order = $request->order;
        $Question->save();
        $Category = $Question->SubCategory->Category;
        // $Question->SubCategory_id = $request->SubCategory_id;
        // $Question->save();
        return redirect()->route('show', $Category);
    }

}
