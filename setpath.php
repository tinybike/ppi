<?php
// Slackware Linux development path
$server_root_1 = '/var/www/htdocs/ppi';

// BlueHost server path
$server_root_2 = '/home1/thefuns1/public_html/interacto';

// Windows UniServer development path
$server_root_3 = 'C:\\UniServer\\www\\ppi';

set_include_path(
	get_include_path() . PATH_SEPARATOR . $server_root_1 . PATH_SEPARATOR . 
	$server_root_2 . PATH_SEPARATOR . $server_root_3
);
