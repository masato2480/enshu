<?php
$ops = array('+','-','*','/');
if($_POST['_submit_check']){
  // validate_form()がエラーを返した場合は、それをshow_form()へ渡す
  if($form_errors = validate_form()){
     show_form($form_errors);
  }else{
     process_form();
  }
}else{
  // フォームがサブミットされなければ、表示をする
 show_form();
}

function show_form($errors = ''){
  if($errors){
     print 'You need to correct the following errors: <ul><li>';
     print implode('</li><li>',$errors);
     print '</li></ul>';
  }
  // エラーがなければ↓
  print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">

  // コメントです。
?>
