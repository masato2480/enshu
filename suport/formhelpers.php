<?php

//テキストボックスを出力
function input_text($element_name, $values) {
  print '<input type="text" name="' . $element_name . '"value="';
  print htmlentities($values($element_name]) . '"/>';
}

//サブミットボタンを出力
function input_submit($element_name, $label) {
  print '<input type="submit" name="' . $element_name . '"value="';
  print htmlentities($label) . '">';
}

//テキストエリアを出力
function input_textarea($element_name, $values) {
  print '<textarea name="' . $element_name . '">';
  print htmlentities($values[$element_name]) . '</textarea>';
}

//<select>メニューを出力
function input_select($element_name, $selected, $options, $multiple = false) {
  //<select>タグを出力
  print '<select name="' . $element_name;
  //複数選択が許されていれば、複数アトリビュートを加え、
  //[]をタグ名の最後に加える。
  if ($multiple) { print '[]" multiple="multiple'; }
  print '">';
  //選択されるもののリストを設定する
  $selected_options = array();
  if ($multiple) {
    foreach ($selected[$element_name] as $val) {
      $selected_options[$val] = true;
    }
  } else {
      $selected_options[ $selected[$element_name] ] = true;
  }
  
  //<option>タグを出力
  foreach ($options as $option => $label) {
    print '<option value = "' . htmlentities($option) . '"';
    if ($selected_options[$option]) {
      print ' selected="selected"';
    }
    print '>' . htmlentities($label) . '</option>';
  }
  print '</select>';
}
?>