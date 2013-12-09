<?php
session_start();

print '<html>';
print '<body bgcolor="$_SESSION[color]">';
print 'This page has your personalized background color.';
print '</body>';
print '</html>';
?>