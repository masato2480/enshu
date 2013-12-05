<?php
  require 'formhelpers.php'; // フォームの要素を出力するヘルパー関数をロードする。

  $us_states = array('AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona',
                     'AR' => 'Arkansas', 'CA' =>'California', 'CO' => 'Colorado',
                     'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida',
                     'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
                     'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa',
                     'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana',
                     'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts',
                     'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
                     'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska',
                     'NV' => 'Nevada', 'NH' => 'New Hampshire',
                     'NJ' => 'New Jersey', 'NM' => 'New Mexico',
                     'NY' => 'New York', 'NC' => 'North Carolina',
                     'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
                     'OR' => 'Oregon', 'PA' => 'Pennsylvania',
                     'RI' => 'Rhode Island', 'SC' => 'South Carolina',
                     'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas',
                     'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia',
                     'WA' => 'Washington', 'DC' => 'Washington D.C.',
                     'WY' => 'Wyoming');

  if($_POST['_submit_check']){
     if($form_errors = validate_form()){
        show_form($form_errors);
     }else{
        process_form();
     }
  }else{
     show_form();
  }
  
  function show_form($errors = ''){
     if($errors){
        print 'You need to correct the following errors: <ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
     }

     print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
     print '<table>';

     //１番目の住所
     print '<tr><th colspan="2">From</th></tr>';
     print '<td>Name:</td><td>';
     input_text('name_1', $_POST);
     print '</td></tr>';
     print '<tr><td>Street Address:</td><td>';
     input_text('address_1', $_POST);
     print '</td></tr>';
     print '<tr><td>City, State, Zip:</td><td>';
     input_text('city_1', $_POST);
     print ', ';
     input_select('state_1', $_POST, $GLOBALS['us_states']);
     input_text('zip_1', $_POST);
     print '</td></tr>';
     
     //２番目の住所
     print '<tr><th colspan="2">From</th></tr>';
     print '<td>Name:</td><td>';
     input_text('name_2', $_POST);
     print '</td></tr>';
     print '<tr><td>Street Address:</td><td>';
     input_text('address_2', $_POST);
     print '</td></tr>';
     print '<tr><td>City, State, Zip:</td><td>';
     input_text('city_2', $_POST);
     print ', ';
     input_select('state_2', $_POST, $GLOBALS['us_states']);
     input_text('zip_2', $_POST);
     print '</td></tr>';

     //荷物の情報
     print '<tr><th colspan="2">Package</th></tr>';
     print '<tr><td>Height:</td><td>';
     input_text('height', $_POST);
     print '</td></tr>';
     print '<tr><td>Width</td><td>';
     input_text('width', $_POST);
     print '</td></tr>';
     print '<tr><td>Length:</td><td>';
     input_text('length',$_POST);
     print '</td></tr>';
     print '<tr><td>Weight:</td><td>';
     input_text('weight',$_POST);
     print '</td></tr>';

     //フォーム終了
     print '<tr><td colspan="2"><input type="submit" value="Ship Package"></td></tr>';
     print '</table>';
     print '<input type="hidden" name="_submit_check" value="1"/>';
     print '</form>';
  }

  function validate_form(){
     $errors = array();
     
     //１番目の住所：
     //name,street,address,cityのすべてが必要になる。
     if(! strlen(trim($_POST['name_1']))){
        $errors[] = 'Enter a From name';
     }
     if(! strlen(trim($_POST['address_1']))){
        $errors[] = 'Enter a From street address'; 
     }
     if(! strlen(trim($_POST['address_1']))){
        $errors[] = 'Enter a valid From state';
     }
     //stateが正しくなければならない
     if(! array_key_exists($_POST['state_1'], $GLOBALS['us_states'])){
        $errors[] = 'Select a valid From state';
     }
     //zipは5桁の数字かZIP+4でなければならない。
     if(!preg_match('/^\d{5}(-\d{4})?$/', $_POST['zip_1'])){
        $errors[] = 'Enter a valid From Zip code';
     }
     
     //２番目の住所
     //name,street,address,cityのすべてが重要になる。
     if(! strlen(trim($_POST['name_2']))){
        $errors[] = 'Enter a From name';
     }
     if(! strlen(trim($_POST['address_2']))){
        $errors[] = 'Enter a From street address';
     }
     if(! strlen(trim($_POST['address_2']))){
        $errors[] = 'Enter a valid From state';
     }
     //stateが正しくなければならない
     if(! array_key_exists($_POST['state_2'], $GLOBALS['us_states'])){
        $errors[] = 'Select a valid From state';
     }
     //zipは5桁の数字かZIP+4でなければならない。
     if(!preg_match('/^\d{5}(-\d{4})?$/', $_POST['zip_2'])){
        $errors[] = 'Enter a valid From Zip code';
     }
      
     //荷物：
     //各辺の長さは36以下でなければならない。
     if(! strlen($_POST['height'])){
        $errors[] = 'Enter a height.';
     }
     if($_POST['height'] > 36){
        $errors[] = 'Height must be no more than 36 inches.';
     }
     if(! strlen($_POST['length'])){
        $errors[] = 'Enter a length';
     }
     if($_POST['length'] > 36){
        $errors[] = 'Length must be no more than 36 inches.';
     }
     if(! strlen($_POST['width'])){
        $errors[] = 'Enter a width';
     }
     if($_POST['width'] > 36){
        $errors[] = 'Width must be no more than 36 inches.';
     }
     //重さは150以下でなければならない。
     if(! strlen($_POST['weight'])){
        $errors[] = 'Enter a weight.';
     }
     if($_POST['weight'] > 150){
        $errors[] = 'Weight must be no more than 150 pounds.';
     }
     return $errors;
  }

  function process_form(){
     print 'The package is going from: <br/>';
     print htmlentities($_POST['name_1']).'<br/>';
     print htmlentities($_POST['address_1']).'<br/>';
     print htmlentities($_POST['city_1']).', '.$_POST['state_1'].''.$_POST['zip_1'].'<br/>';

     print 'The package is going to: <br/>';
     print htmlentities($_POST['name_2']).'<br/>';
     print htmlentities($_POST['address_2']).'<br/>';
     print htmlentities($_POST['city_2']).', '.$_POST['state_2'].''.$_POST['zip_2'].'<br/>';

     print 'The package is '.htmlentities($_POST['length']).' × '.htmlentities($_POST['width']).' × '.htmlentities($_POST['height']);
     print ' and weighs '.htmlentities($_POST['weight']).' lbs. '; 
?>
