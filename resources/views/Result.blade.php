@extends('layouts.app')

@section('content')
<div class="contents">
  <h1  class="pb-4">{{ $Category->Category }}の結果</h1>
  <div>
  	<input type="hidden" name='one_category' value="{{ $Category->Category }}">
  	<input type="hidden" name='one_score' value="{{ $Cate_score }}">
  	@foreach($Sub_score as $key => $value)
  	<input type="hidden" name='one_category' value="{{ $key }}">
  	<input type="hidden" name='one_score' value="{{ $value }}">
  	@endforeach
  </div>
  <div class="m-auto" style="width: 50%">
	    <canvas class="m-auto" id="one_chart" height="450" width="600"></canvas>
　</div>
  

	<!-- <table class="table-bordered">
		<tr>
			<th>
				{{ $Category->Category }}
			</th>
			@foreach($Sub_score as $key => $value)
		      <th>
		      	{{$key}}
		  	  </th>
		    @endforeach
		</tr>
		<tr>
			<td>
				{{ round($Cate_score,1) }}
			</td>
			@foreach($Sub_score as $key => $value)
		      <td>
		      	{{ round($value,1) }}
		  	  </td>
		    @endforeach
		</tr>
	</table> -->
　

  <div>
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
</div>

@auth
	<h3 class="text-center mt-5">{{ $Category->Category }}のグラフ</h3>
	<div class="m-auto" style="width: 50%">
	    <canvas class="m-auto" id="chart" height="450" width="600"></canvas>
	</div>
	<div class="mr-auto ml-auto" style="width: 50%">
		<p class="text-center blockquote mt-5">{{ $Category->Category }}の説明；{{ $Category->result_explain }}詳しくは<a href="{{ $Category->reference }}">こちら</a></p>
		<p class="mt-4 text-center">
		    <a href="{{ action('CategoryController@Dashboard') }}" class="btn btn-primary my-2">過去の結果を見る</a>
		    <a href="https://www.naka-style-blog.com/" class="btn btn-secondary my-2">ブログを見に行く</a>
	    </p>
	</div>

@endauth
@guest
	<p>ログインするとグラフ化できます。</p>
@endguest


<script>
	
	function NodeToArray(attribute){
		var data = [];
		var Pre = document.getElementsByName(attribute);
		for(i = 0; i < Pre.length; i++){
			data.push(Pre[i].value);
		}
		return data;
	}

	var color = ['red', 'blue', 'green', 'orange', 'yellow', 'black', 'pink', 'lightgreen', 'purple', 'gold', 'brown', 'indigo', 'gray', 'violet', 'silver', 'olive', 'aqua', 'lime']

	//過去のグラフ用の設定
	//カテゴリーの名前、テストの日付、点数を配列として取得
	var category = document.getElementById('category');
	var day = NodeToArray('day');
	var score = NodeToArray('score');

	//サブカテゴリー、点数（サブカテゴリー名＿点数）を配列として取得
	var subcategory = NodeToArray('subcategory');
	// var subday = NodeToArray("{{ $key }}_day");
	var subscore = NodeToArray("subscore");
	//サブカテゴリー毎の点数を配列として取得
	var array = [];
	for(n=0; n<subcategory.length; n++){
		var pre_array = [];
		for(i=0; i<subscore.length; i++){
			if(subscore[i].includes(subcategory[n])){
				pre_array.push(subscore[i].substring(subscore[i].indexOf("_")+1, subscore[i].length));
			}
		}
		array.push(pre_array);
	}
	//サブカテゴリーと点数を連想配列にする
	var score_array = [];
	for(i=0; i<subcategory.length; i++){
		score_array[subcategory[i]] = array[i];
	}

 	var config = {
 		type: 'line',
 		data: {
 			labels : day,
	        datasets : [
	        {
	          label: category.value,
	          borderColor: color[0],
	          fill: false, // 追加
	          data : score
	        },
	        ]
 		},
 		option: {
	      responsive : true
	    }
 	}

 	//今回の結果用のグラフ設定
 	var one_category = NodeToArray('one_category');
	var one_score = NodeToArray('one_score');

	var one_config = {
 		type: 'bar',
 		data: {
 			labels : one_category,
	        datasets : [
	        {
	          backgroundColor: color,
	          data : one_score
	        },
	        ]
 		},
 		options: {
	      responsive : true,
	      legend: {  
      		display: false
           },
          scales: {                          //軸設定
                yAxes: [{                      //y軸設定
                    display: true,             //表示設定
                    ticks: {                      //最大値最小値設定
                        fontSize: 18,             //フォントサイズ
                    },
                }],
                xAxes: [{                         //x軸設定
                    display: true,                //表示設定
                    categoryPercentage: 0.4,      //棒グラフ幅
                    ticks: {
                        fontSize: 18             //フォントサイズ
                    },
                }],
            }
	    }
 	}
 	console.log(one_category);
 	console.log(one_score);

 	//読み込み
  	window.onload = function(){
      var ctx = document.getElementById("chart").getContext("2d");
      var myBar = new Chart(ctx, config);
      
      for(i=0; i<Object.keys(score_array).length; i++){
		var newDatasets = {
			label: subcategory[i],
			borderColor: color[i+1],
	        fill: false,
	        data : score_array[subcategory[i]]
		};
		config.data.datasets.push(newDatasets);
		myBar.update();
		}
		var one_ctx = document.getElementById("one_chart").getContext("2d");
      	var one_myBar = new Chart(one_ctx, one_config);
	}


</script>


@endsection