<?php
$server_root_1 = '/var/www/htdocs/ppi';
$server_root_2 = '/home1/thefuns1/public_html/scrubbins';
$server_root_3 = 'C:\\UniServer\\www\\ppi';
set_include_path(get_include_path().PATH_SEPARATOR.$server_root_1.PATH_SEPARATOR.$server_root_2.PATH_SEPARATOR.$server_root_3);
