<?php header("Content-type:text/plain");
echo "OK\n";
file_put_contents(__DIR__."/_pwtest_tr.txt","DONE:".time()."\n");
