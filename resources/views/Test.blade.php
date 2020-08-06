@extends('layouts.app')

@section('content')
<div class="contents">
  <h1  class="">{{ $Category->Category }}</h1>
  <div class="slider">
    <form  action="{{ action('CategoryController@Calculate', $Category) }}" method="post">
      @csrf
      
        @forelse ($Category->SubCategories as $SubCategory)
          @forelse ($SubCategory->Questions as $Question)
          <p class="mt-sm-5">
            {{ $Question->Question }}
          </p>
          @if($Question->order == "0")
            <p>
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="5"/>当てはまる
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="4"/>少し当てはまる
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="3" checked="checked"/>どちらとも言えない
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="2"/>少し違う
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="1"/>違う
            </p>
          @elseif($Question->order == "1")
            <p>
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="1"/>当てはまる
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="2"/>少し当てはまる
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="3" checked="checked"/>どちらとも言えない
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="4"/>少し違う
              <input id="{{$SubCategory->id}}" class="mr-2 ml-4 Question" type="radio" name="{{$SubCategory->id}}_{{$loop->iteration}}" value="5"/>違う
            </p>
          @endif
          @empty
          <li>No Question</li>
          @endforelse
        @empty
        <li>No SubCategory</li>
        @endforelse
      <button type="submit" class="btn btn-outline-dark mt-5">結果をみる</button>
    </form>
  </div> 
  <!-- <div class="submit" id="submit" onclick="GetResult()"><p>結果を見る</p></div> -->
</div>
@endsection