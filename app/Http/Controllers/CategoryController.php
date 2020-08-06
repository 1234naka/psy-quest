<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Category;
use App\SubCategory;
use App\Category_score;
use App\SubCategory_score;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function show()
	{
		// $Categories = \DB::table('Categories')->get();
		$Categories = Category::get();
		return view('questionnaire', [
			'Categories' => $Categories
		]);
	}

	public function store(Request $request)
	{
		$Category = new Category();
		$Category->Category = $request->Category;
    	$Category->explain = $request->explain;
    	$Category->reference = $request->reference;
    	$Category->result_explain = $request->result_explain;
    	$Category->save();
    	return redirect()->route('Category_show');
	}

	public function edit(Category $Category, Request $request)
	{
		$Category->Category = $request->Category;
    	$Category->explain = $request->explain;
    	$Category->reference = $request->reference;
    	$Category->result_explain = $request->result_explain;
    	$Category->save();
    	return redirect()->route('show', $Category);
	}

	public function delete(Category $Category){
    	$Category->delete();
        return redirect()->route('Category_show');
    }

	public function test(Category $Category)
	{
		return view('Test', [
			'Category' => $Category
		]);
	}

	public function Result(Category $Category)
	{
		return view('Result', [
			'Category' => $Category
		]);
	}

	public function Dashboard()
	{

		$Categories = Category::get();
		return view('Past_result', [
			'Categories' => $Categories
		]);
	}

	public function Past_result(Category $Category)
	{
		$Categories = Category::get();
		if(Auth::check()){
			//過去のカテゴリーデータ取得
			$Category_History = $this->CategoryHistory($Category);
			//過去のサブカテゴリーデータ取得
			$SubCategory_History = $this->SubCategoryHistory($Category);
			// dd($SubCategory_History);
		}else{
			$Category_History = [];
			$SubCategory_History = [];
		}

		return view('Past_result', compact('Category', 'Categories', 'Category_History', 'SubCategory_History'));
	}

	public function Calculate(Category $Category, Request $request)
	{
		//バリデーション
		
		//アンケートの結果を取得
		$all = $request->all();
		$all = collect( $all )->except('_token'); //リクエストにトークンが入っているので削除
		//全体の平均を取得
		$Cate_score = $all->avg();
		//サブカテゴリーの質問数($q)を取得し、平均を計算しscoresへ配列化
		$Sub_max = $Category->SubCategories;
		for($i = 0; $i < count($Sub_max); $i++){
			$q = $Category->SubCategories[$i]->Questions->count();
			$scores[] = $all->take($q)->avg();
			$all = $all->splice($q);
		}
		
		//サブカテゴリーのタイトルを配列化し、$scoresと結びつける
		$Sub_array = SubCategory::where('Category_id', $Category->id)->pluck('SubCategory');
		$Sub_score = $Sub_array->combine($scores);

		//保存
		//もし、ユーザーがログインしていたら
		if(Auth::check()){
		//カテゴリースコア、サブカテゴリースコアのテーブルを呼び出し
		//カテゴリースコア、サブカテゴリースコアの代入。ユーザーidとカテゴリーidとサブカテゴリーidも代入
			$Category_score = new Category_score();
			$Category_score->Category_score = $Cate_score;
			$Category_score->user_id = Auth::user()->id;
			$Category_score->Category_id = $Category->id;
			// dd($Category_score);
			$Category_score->save();

			for($i=0; $i<count($scores); $i++){
				$SubCategory_score = new SubCategory_score();
				$SubCategory_score->SubCategory_score = $scores[$i];
				$SubCategory_score->user_id = Auth::user()->id;
				$SubCategory_score->SubCategory_id = $Category->SubCategories[$i]->id;
				// dd($SubCategory_score);
				$SubCategory_score->save();
			}
			
		}
		if(Auth::check()){
			//過去のカテゴリーデータ取得
			$Category_History = $this->CategoryHistory($Category);
			//過去のサブカテゴリーデータ取得
			$SubCategory_History = $this->SubCategoryHistory($Category);
		}else{
			$Category_History = [];
			$SubCategory_History = [];
		}
		$request->session()->regenerateToken();
		
		return view('Result', compact('Sub_score', 'Cate_score', 'Category', 'Category_History', 'SubCategory_History'));
		// return redirect(route('Result', [
		// 	'Category' => $Category, 
		// 	'Sub_score' => $Sub_score,
		// 	'Cate_score' => $Cate_score,
		// 	'Category_History' => $Category_History,
		// 	'SubCategory_History' => $SubCategory_History
		// ]));
	}

	public function CategoryHistory($Category){
		return Category_score::where('user_id', Auth::user()->id)->where('Category_id', $Category->id)->get();
	}

	public function SubCategoryHistory($Category){
		for($i=0; $i<count($Category->SubCategories); $i++){
			$SubCategory_History[] = SubCategory_score::where('user_id', Auth::user()->id)->where('SubCategory_id', $Category->SubCategories[$i]->id)->get();
		}
		//サブカテゴリー名の入った連想配列を作る
		$Sub_array = SubCategory::where('Category_id', $Category->id)->pluck('SubCategory');

		return $Sub_array->combine($SubCategory_History);
	}

	
}
