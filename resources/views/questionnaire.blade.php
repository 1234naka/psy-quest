@extends('layouts.app')

@section('content')
<main role="main">
  <section class="jumbotron text-center">
    <div class="container">
      <h1>Psy-quest</h1>
      <p class="lead text-muted">科学に基づいた心理学テストを行います。</p>
      <p>
        <a href="{{ action('CategoryController@Dashboard') }}" class="btn btn-primary my-2">過去の結果を見る</a>
        <a href="https://www.naka-style-blog.com/" class="btn btn-secondary my-2">ブログを見に行く</a>
      </p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
      	@foreach ($Categories as $Category)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <h2 class="progress-bar p-3" href="{{ action('CategoryController@test', $Category) }}">{{ $Category->Category }}</h2>
            <div class="card-body">
              <p class="card-text">{{ $Category->explain }}{{ $Category->Category }}の詳しい説明は<a href="{{ $Category->reference }}">こちら</a></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a type="button" class="btn btn-lg btn-block btn-outline-primary" href="{{ action('CategoryController@test', $Category) }}">Start</a>
                </div>
	              @can('system-only')
	              <div class="mr-0">
	                  <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ action('SubCategoryController@show', $Category) }}">Edit</a>

	                  <a type="button" href="#" class="del btn btn-sm btn-outline-secondary" data-id="{{ $Category->id }}" onclick="deleteCategory(this);">削除</a>

			          <form method="post" action="{{ action('CategoryController@delete', $Category ) }}" id="form_{{ $Category->id }}">
			          {{ csrf_field() }}
			          {{ method_field('delete') }}
			          </form>
		       	  </div>
	              @endcan
                
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      
    </div>
  </div>
  <section class="jumbotron">
  	@can('system-only')
		<form method="post" action="{{ action('CategoryController@store', $Category) }}">
	      {{ csrf_field() }}
		    <p>
	          カテゴリーの名前； <input class="" type="text" name="Category" value="カテゴリー名" >
	        </p>
	        <p>
	          説明文； <input style="width: 80%" type="text" name="explain" value="説明文" >
	        </p>
	        <p>
	          参考ページ； <input style="width: 50%" type="text" name="reference" value="参考記事" >
	        </p>
	        <p>
	          結果の説明； <input style="width: 80%" type="text" name="result_explain" value="結果の説明" >
	        </p>
	        <p>
	          <input type="submit" value="store">
	        </p>
	    </form>
	 @endcan
  </section>

</main>

<script>
  function deleteCategory(e){
    if(confirm('削除して良いですか？')){
      document.getElementById('form_' + e.dataset.id).submit();
    }
  }
</script>

@endsection