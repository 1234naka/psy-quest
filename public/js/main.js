'use strict';

function deleteCategory(e){
  if(confirm('削除して良いですか？')){
    document.getElementById('form_' + e.dataset.id).submit();
  }
}
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
function GetResult(e){
  if(confirm(' submitして良いですか？')){
    document.getElementById('form_' + e.dataset.id).submit();
  }
}




  
