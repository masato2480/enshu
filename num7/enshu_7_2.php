<?php
  require 'DB.php';
  require 'formhelper.php'; //フォーム要素出力関数をロードする。

  $db = DB::connect('mysqli://nishiyamamasato:nmst0117@localhost/dishes');
  if (DB::isError($db)) { die("Can't connect: " . $db->getMessage()); }
  $db->setErrorHandling(PEAR_ERROR_DIE);
  $db->setFetchMode(DB_FETCHMODE_ASSOC);
  if( $_POST['_submit_check']) {
     if ($form_errors = validate_form()) {
        show_form($form_errors);
     } else {
        process_form();
     }
  } else {
     show_form();
  }
  function show_form($errors = '') {
     if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print 'implode('</li><li>',$errors);
        print '</li></ul>';
     }
     //フォーム始まり
     print '<form method="POST" cation="' . $_SERVER['PHP_SELF'] . '">';
     print '<table>';
     
     //値段
     print '<tr><td>Price:</td><td>';
     input_text('price', $_POST);
     print '</td></tr>';

     //フォーム終了
     print '<tr><td colspan="2"><input type="submit" value="Search Dishes">";
     print '</td></tr>';
     print '</table>';
     print '<input type="hidden" name="_submit_check" value="1"/>";
     print '</form>';
  }
  function validate_form(){
     $errors = array();
     if(! strval(floatval($_POST['price'])) == $_POST['price']){
        $errors[] = 'Please enter a valid price.';
     } elseif ($_POST['price'] <= 0) {
        $errors[] = 'Please enter a price greater than 0.';
     }
     return $errors;
  }
  function process_form(){
     global $db;
     $dishes = $db->getAll('SELECT dish_name,price FROM dishes WHERE price >= ?',array($_POST['price']));
     if (count($dishes) > 0) {
        print '<ul>';
        foreach ($dishes as $dish) {
           print "<li> $dish[dish_name] ($dish[price])</li>";
        }
     } else {
        print 'No dishes match!!!';
     }
  }
?>
