<?php

$root = $_SERVER['DOCUMENT_ROOT'] . '/';

$paths = array(
	'pages' => ['home', 'error'],
	'user' => ['signup', 'login'],
	'other' => ['other']
);

function call($controller, $action) {
	require_once('controllers/' . ucfirst($controller) . 'Controller.class.php');

	switch($controller) {
		case 'pages':
			$controller = new PagesController();
		break;
		case 'user':
			$controller = new UserController();
		break;
	}
	$controller->{$action}();
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
