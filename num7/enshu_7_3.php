<?php
  require 'DB.php';
  require 'formhelpers.php';

  $db = DB::connect('mysqli://nishiyamamasato:nmst0117@localhost/dishes');
  if (DB::isError($db)) { die("Can't connect: " . $db->getMessage()); }
  $db->setErrorHandling(PEAR_ERROR_DIE);
  $db->setFetchMode(DB_FETCHMODE_ASSOC);
  
  $dish_name = array();
  $res = $db->query('SELECT dish_name FROM dishes');
  while ($row = $res->fetchRow()) {
     $dish_names[] = $row['dish_name'];
  }
  if ($_POST['_submit_check']) {
     if ($form_errors = validate_form()) {
        show_form($form_errors);
     } else {
        process_form();
     }
  } else {
     show_form();
  }
  function show_form($errors = '') {
     global $db;
     if ($errors) {
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
     }
    
     //フォーム開始！
     print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
     print '<table>';

     //料理選択！
     print '<tr><td>Dish:</td><td>';
     input_select('dish_name', $_POST, $GLOBALS['dish_names']);
     print '</td></tr>';

     //フォーム終了！
     print '<tr><td colspan="2"><input type="submit" value="Search Dishes">';
     print '</td></tr>';
     print '</table>';
     print '<input type="hidden" name="_submit_check" value="1"/>';
     print '</form>';
  }
  function validate_form() {
     $errors = array();
     if (! array_key_exists($_POST['dish_name'], $_GLOBALS['dish_names'])) {
        $errors[] = 'Please select a valid dish.';
     }
     return $errors;
  }
  function process_form() {
     global $db;

     $dish_name = $GLOBALS['dish_names'][$_POST['dish_name]];
     $dish_info = $db->getRow('SELECT dish_id, dish_name, price, is_spicy FROM dishes WHERE dish_name = ?', array($dish_name));

     if (count($dish_info) > 0) {
        print '<ul>';
        print "<li> ID: $dish_info[dish_id]</li>";
        print "<li> Name: $dish_info[dish_name]</li>";
        print "<li> Price: $dish_info[price]</li>";
        print "<li> Is Spicy: $dish_info[is_spicy]</li>";
        print '</ul>';
     } else {
        print 'No dish matches.';
     }
  }
?>
