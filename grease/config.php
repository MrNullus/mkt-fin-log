<?php   
require('utils/require_utils.utils.php');

define("__DIR_ROOT__", "C:\\xampp\htdocs\v4-automotive");
define("URL_BASE", "http://localhost:8080/grease");

require_utils(
	array(
        'require_utils',
		'useController',
		'import_models'
	)
);

