<?php
  $page_count = $_COOKIE['page_count'] + 1;
  
  if($page_count == 20){
    setcookie('page_count','');
    print "return 0";
  }else{
    setcookie('page_count',$page_count);
    print "number of views: $page_count";
    if($page_count == 5){
      print "5";
    }elseif($page_count == 10){
      print "10";
    }elseif($page_count == 15){
      print "15";
    }
  }
?>