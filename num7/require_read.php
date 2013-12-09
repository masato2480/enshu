<?php
require '/Library/Webserver/Document/enshu/num7/formhelper.php';

$files_arr = get_included_files();

foreach ($files_arr as $value) {
  print $value."<br>";
}
?>