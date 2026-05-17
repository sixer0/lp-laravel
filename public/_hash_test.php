<?php header('Content-Type:text/plain');
echo md5_file(__FILE__) . "\n";
echo "PHP=" . phpversion() . "\nPHP_BIN\n";
?>
