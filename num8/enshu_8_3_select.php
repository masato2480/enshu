<?php

//走らない原因
//formhelpers.phpとうまく連携ができてない。

include 'formhelpers.php';

session_start();

$colors = array('#ff0000' => 'red', '#ff6600' => 'orange', '#ffff00' => 'yellow', '#0000ff' => 'green', '#00ff00' => 'blue', '#ff00ff' => 'purple');

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
  print '<form method="POST" action="http://localhost/enshu/num8/enshu_8_3_change.php">';
  
  if ($errors) {
    print '<ul><li>';
    print implode('</li><li>',$errors);
    print '</li></ul>';
  }
  
  print 'Color: ';
  input_select('color', $_POST, $GLOBALS['colors']);
  print '<br/>';
  input_submit('submit','Select Color');
  print '<input type="hidden" name="_submit_check" value="1"/>';
  print '</form>';
}

function validate_form() {
  $errors = array();
  
  if (! array_key_exists($_POST['color'], $GLOBALS['colors'])) {
    $errors[] = 'please select a valid color.';
  }
  return $errors;
}

function process_form() {
  $_SESSION['color'] = $_POST['color'];
  print "Your favorite color is: " . $GLOBALS['colors'][ $_SESSION['color'] ];
}

?>