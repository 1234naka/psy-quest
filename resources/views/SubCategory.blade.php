@extends('layouts.app')

@section('content')
<div class="contents">

  <div class="my-3 p-3 bg-white text-left rounded shadow-sm">
    <h1 class="border-bottom border-gray pb-2 mb-0">{{ $Category->Category }}</h1>
    <div class="media text-muted pt-3">
      <form style="width: 50%" method="post" action="{{ action('CategoryController@edit', $Category) }}">
        {{ csrf_field() }}
        {{ method_field('patch') }}
        <p>
          カテゴリーの名前； <input class="" type="text" name="Category" value="{{ old('カテゴリー名', $Category->Category) }}" >
        </p>
        <p>
          説明文； <input style="width: 80%" type="text" name="explain" value="{{ old('説明文', $Category->explain) }}" >
        </p>
        <p>
          参考ページ； <input style="width: 50%" type="text" name="reference" value="{{ old('参考記事', $Category->reference) }}" >
        </p>
        <p>
          結果の説明； <input style="width: 80%" type="text" name="result_explain" value="{{ old('結果の説明', $Category->result_explain) }}" >
        </p>
        <p>
          <input type="submit" value="edit">
        </p>
      </form>
    </div>

    <form method="post" action="{{ action('SubCategoryController@store', $Category) }}">
      {{ csrf_field() }}
      <p>
        サブカテゴリーの追加：
        <input type="text" name="SubCategory" placeholder="SubCategory" >
        <input type="submit" value="Add">
      </p>
    </form>
    
  </div>
  <div class="container mt-5">
    <div class="row">
     @forelse ($Category->SubCategories as $SubCategory)
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">{{ $SubCategory->SubCategory }}</h4>
          </div>
          <div class="card-body">
            @forelse ($SubCategory->Questions as $Question)
              <ul>
                <li class="text-left">
                  <form method="post" action="{{ action('QuestionController@edit', $Question) }}">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                      <input class="" type="text" name="Question" value="{{ old('質問', $Question->Question) }}" >
                      <select name="order">
                        <option value="0" @if($Question->order=='0') selected  @endif>0</option>
                        <option value="1" @if($Question->order=='1') selected  @endif>1</option>
                      </select>
                      <input type="submit" value="edit">
                      <a href="#" class="del" data-id="{{ $Question->id }}" onclick="deleteQuestion(this);">[x]</a>
                  </form>
                  
                  <form method="post" action="{{ action('QuestionController@delete', $Question )}}" id="form_{{ $Question->id }}">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                  </form>
                </li>
              </ul>
            @empty
              <p>No Question</p>
            @endforelse
            <form method="post" action="{{ action('QuestionController@store', $SubCategory) }}">
              {{ csrf_field() }}
              <p>
                <input type="text" name="Question" placeholder="Question" >
                <select name="order">
                  <option value="0">0</option>
                  <option value="1">1</option>
                </select>
                <input type="submit" value="add">
              </p>
            </form>
            <a type="button" href="#" class="btn btn-lg btn-block btn-outline-primary del" data-id="{{ $SubCategory->id }}" onclick="deleteSubCategory(this);">削除</a>
            <form method="post" action="{{ action('SubCategoryController@delete', $SubCategory ) }}" id="form_{{ $SubCategory->id }}">
              {{ csrf_field() }}
              {{ method_field('delete') }}
            </form>
          </div>
        </div>
      </div>
      @empty
        <p>No SubCategory</p>
      @endforelse
    </div>
  </div>

  <script>
    function deleteSubCategory(e){
      if(confirm('削除して良いですか？')){
        document.getElementById('form_' + e.dataset.id).submit();
      }
    }
    function deleteQuestion(e){
      if(confirm('削除して良いですか？')){
        document.getElementById('form_' + e.dataset.id).submit();
      }
    }
  </script>

@endsection