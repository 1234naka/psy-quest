@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          @forelse($Categories as $Catego)
          <li class="nav-item">
            <a class="nav-link active" href="{{ action('CategoryController@Past_result', $Catego) }}">
              <span data-feather="home"></span>
              {{ $Catego->Category }} <span class="sr-only">(current)</span>
            </a>
          </li>
          @empty
            <p>No Categories</p>
          @endforelse
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
      </div>

      @auth
        @if(isset($Category) and isset($Category_History) and isset($SubCategory_History))
        <div>
          <h3 class="text-center">{{ $Category->Category }}のグラフ</h3>
          <div class="m-auto" style="width: 80%">
              <canvas class="my-4 w-100" id="chart" width="900" height="380"></canvas>
          </div>
          <input type="hidden" id='category' value="{{ $Category->Category }}">
            @foreach($Category_History as $Cate_his)
              <input type="hidden" name='day' value="{{ $Cate_his->created_at->format('Y/m/d') }}">
              <input type="hidden" name='score' value="{{ $Cate_his->Category_score }}">
            @endforeach
          </div>
          <div>
            @foreach($SubCategory_History as $key => $value)
              <input type="hidden" name='subcategory' value="{{ $key }}">
              @foreach($value as $Sub_score)
                <input  type="hidden" name="subscore" value="{{ $key }}_{{ $Sub_score->SubCategory_score }}">
              @endforeach
            @endforeach
          </div>
          <div class="mt-5 pl-5 pr-5">
            <p>結果の見方；{{ $Category->result_explain }}</p>
            <p class="card-text">{{ $Category->explain }}{{ $Category->Category }}の詳しい説明は<a href="{{ $Category->reference }}">こちら</a></p>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ action('CategoryController@test', $Category) }}">{{ $Category->Category }}の測定</a>
          </div>
        </div>
        @else
        <div>
          <p>見たいグラフを選んでください</p>
        </div>
        @endif
      @endauth
      @guest
        <p>ユーザー登録すると過去の結果が見れます。</p>
      @endguest

    </main>
  </div>
</div>

<script>
  // 同じNameプロパティを配列として取得
  function NodeToArray(attribute){
    var data = [];
    var Pre = document.getElementsByName(attribute);
    for(i = 0; i < Pre.length; i++){
      data.push(Pre[i].value);
    }
    return data;
  }
  // subscoreがサブカテゴリー名＿点数の形で配列化しているので連想配列にする（サブカテゴリー名=>[点数]）
  function ScoreArray(SubcategoryNumber, Subscore){
    var array = [];
    for(n=0; n<SubcategoryNumber.length; n++){
      var pre_array = [];
      for(i=0; i<Subscore.length; i++){
        if(Subscore[i].includes(SubcategoryNumber[n])){
          var score = ScoreGet(Subscore[i]);
          pre_array.push(score);
        }
      }
      array.push(pre_array);
    }
    //サブカテゴリーと点数を連想配列にする
    var score_array = [];
    for(i=0; i<SubcategoryNumber.length; i++){
      score_array[SubcategoryNumber[i]] = array[i];
    }
    return score_array;
  }

  function ScoreGet(Prescore){
    return Prescore.substring(Prescore.indexOf("_")+1, Prescore.length);
  }
  
  //カテゴリーの名前、テストの日付、点数を配列として取得
  var category = document.getElementById('category');
  var day = NodeToArray('day');
  var score = NodeToArray('score');

  //サブカテゴリー、点数（サブカテゴリー名＿点数）を配列として取得
  var subcategory = NodeToArray('subcategory');
  var subscore = NodeToArray("subscore");
  var score_array = ScoreArray(subcategory, subscore);


  var config = {
    type: 'line',
    data: {
      labels : day,
          datasets : [
          {
            label: category.value,
            borderColor: 'red',
            fill: false, // 追加
            data : score
          },
          ]
    },
    option: {
        responsive : true
      }
  }

  var color = ['blue', 'green', 'orange', 'yellow', 'black', 'pink', 'lightgreen', 'purple', 'gold', 'brown', 'indigo', 'gray', 'violet', 'silver', 'olive', 'aqua', 'lime']

    window.onload = function(){
      var ctx = document.getElementById("chart").getContext("2d");
      var myBar = new Chart(ctx, config);
      
      for(i=0; i<Object.keys(score_array).length; i++){
    var newDatasets = {
      label: subcategory[i],
      borderColor: color[i],
          fill: false,
          data : score_array[subcategory[i]]
    };
    config.data.datasets.push(newDatasets);
    myBar.update();
    }
  }

  
</script>

@endsection