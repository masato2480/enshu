<?php
  require 'DB.php';

  $db = DB::connect('mysqli://nishiyamamasato:nmst0117@localhost/dishes');
  if(DB::isError($db)) { die("Can't connect: " .$db->getMessage()); }
  $db->setErrorHandling(PEAR_ERROR_DIE);
  $db->setFetchMode(DB_FETCHMODE_ASSOC);
  $dishes = $db->getAll('SELECT dish_name,price FROM dishes ORDER BY price');
  if (count($dishes) > 0) {
      print '<ul>';
      foreach ($dishes as $dish) {
          print "<li>$dish[dish_name] ($dish[price])</li>";
      }
      print '</ul>';
  } else {
      print 'No dishes available.';
  }

/*分からないところ。*/
//4行目のDB:connectで指定しているDSNが違うせいか、
//何度試してみても、「Can't connect: DB Error: connect failed」
//と表示がされてしまいます。
//ネットで調べてみたところ、やはりDSNに間違いはないと思うのですが、
//解決策がわからないため、次に進もうと思います。。。



?>
