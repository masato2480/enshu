<?php
$ops = array('+','-','*','/');

if($_POST['_submit_check']){
  if($form_errors = validate_form()){  // validate_form()がエラーを返した場合は、それをshow_form()へ渡す。
     show_form($form_errors);
  }else{
     process_form();
  }
}else{
  show_form();  // フォームがサブミットされなければ、表示をする。
}

function show_form($errors = ''){
  if($errors){
     print 'You need to correct the following errors: <ul><li>';
     print implode('</li><li>',$errors);
     print '</li></ul>';
  }
  print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">'; // エラーがなければ、フォームを表示する。
  
  print '<input type="text" name="operand_1" size="5" value="'; // １つ目のオペランドを挿入する。
  print htmlspecialchars($_POST['operand_1']).'"/>';

  print '<select name="operator">'; //演算子を挿入する。
  foreach($GLOBALS['ops'] as $op){
     print '<option';
     if($_POST['operator'] == $op) { print ' selected = "selected"'; } //選択して、送った演算子（$_POST）が変数（$op）と同じなら、「print ' selected = "selected"';」を出力する。
     print "> $op</option>";
  }
  print '</select>';

  print '<input type="text" name="operand_2" size="5" value="'; // ２つ目のオペランドを挿入する。
  print htmlspecialchars($_POST['operand_2']).'">';
  
  print '<br/><input type="submit" value="calculate"/>'; // 演算の結果をサブミットする。

  print '<input type="hidden" name="_submit_check" value="1"/>'; // ブラウザ上に非表示のデータを送信する。

  print '</form>';
}

function validate_form(){
  $errors = array();

  if(! strlen($_POST['operand_1'])){ // strlenは括弧内の変数をint型で返すので、この場合、パラメータ['operand_1']の値がint型でなかったらエラーが発生するということになる。
     $errors[] = 'Enter a number for the first operand.';
  }elseif(! strval(floatval($_POST['operand_1'])) == $_POST['operand_1']){ // 小数点を含んでいた場合、float型であれば大丈夫。
     $errors [] = 'The first operand must be numeric.';
  }
    
  if(! strlen($_POST['operand_2'])){ // operand1のときとほぼ同じである。
     $errors[] = 'Enter a number for the first operand.';
  }elseif(! strval(floatval($_POST['operand_2'])) == $_POST['operand_2']){
     $errors [] = 'The first operand must be numeric.';
  }
 
  if(! in_array($_POST['operator'], $GLOBALS['ops'])){ // 選択した演算子の値が、用意した演算子と異なる場合はエラーを発生させる。
     $errors[] = 'Please select a valid operator.';
  }

  return $errors;
}

function process_form(){ // 実際に演算を実行する。
  if('+' == $_POST['operator']){
     $total = $_POST['operand_1'] + $_POST['operand_2'];
  }elseif('-' == $_POST['operator']){
     $total = $_POST['operand_1'] - $_POST['operand_2'];
  }elseif('*' == $_POST['operator']){
     $total = $_POST['operand_1'] * $_POST['operand_2'];
  }elseif('/' == $_POST['operator']){
     $total = $_POST['operand_1'] / $_POST['operand_2'];
  }
  print '$_POST[operand_1] $_POST[operator] $_POST[operand_2] = $total';
}


/*疑問*/
//28行目　selected = "selected" の意味が調べてみてもよくわからない。
//→？
//29行目　print構文において、「"」を「'」に変更すると、演算子の部分がうまく表示されなくなってしまう。
//→$opの中身が'+'のように「'」が使用されているため、29行目で「'」を使用してしまうと、うまく画面に表示されなくなってしまう。
?>
