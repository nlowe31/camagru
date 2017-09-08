<?php
$paths = array(
	'pages' => ['home', 'error'],
	'other' => ['other'];
);

function call($controller, $action) {
	require_once('controllers/' . $controller . 'Controller.php');
	switch($controller) {
		case 'pages':
			$controller = new PagesController();
		break;
	}
	call_user_func('$controller->' . $action);
}

if (array_key_exists($controller, $paths)) {
	if (in_array($action, $paths[$controller])) {
		call($controller, $action);
	}
	else {
		call('pages', 'error');
	}
}
else {
	call('pages', 'error');
}
?>
