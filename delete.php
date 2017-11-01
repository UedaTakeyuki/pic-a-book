<?php
	$cmd_str = "sudo sh -c '".'echo -e "'.$_GET['line'].'d\\\\nw" | /bin/ed /var/www/html/tools/171002/data/bibliography.csv '."'";
#	echo $cmd_str;
#	`$cmd_str`;
	$file   = file('data/bibliography.csv');
	unset($file[1]);
	file_put_contents('data/bibliography.csv', $file);
	header("Location: " . "index.php");