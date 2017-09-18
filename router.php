<?php

$root = $_SERVER['DOCUMENT_ROOT'] . '/';

$paths = array(
	'pages' => ['home', 'error'],
	'user' => ['signup', 'login'],
	'other' => ['other']
);

function call($controller, $action) {
	if (file_exists('controllers/' . ucfirst($controller) . 'Controller.class.php'))
		require_once('controllers/' . ucfirst($controller) . 'Controller.class.php');
	else {
		$controller = 'pages';
		$action = 'error';
	}

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

$uri = explode('/', $_SERVER['REQUEST_URI']);
$controller = ucfirst(array_shift($uri));
$action = array_shift($uri);
foreach ($uri as $element) {
	$get = explode(':', $element);
	$params[$get[0]] = $get[1];
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
