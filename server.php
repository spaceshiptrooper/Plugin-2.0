<?php
function postAction($array = [], $newArray = [], $callBack = NULL) {

	foreach($array AS $key => $item) {

		$newArray[$key] = $item;

	}

	return $newArray;

}

function server() {

	// Check to see what URL scheme the current URL uses
	if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {

		$protocol = 'https://'; // The current URL scheme uses https

	} else {

		$protocol = 'http://'; // The current URL scheme uses http

	}

	define('HTTP', $protocol); // Create a constant called HTTP and append the $protocol variable to it.
	define('SERVER_NAME', $_SERVER['SERVER_NAME']); // Create a constant called SERVER_NAME and append $_SERVER['SERVER_NAME'] to it
	define('REQUEST_URI', $_SERVER['REQUEST_URI']); // Create a constant called REQUEST_URI and append $_SERVER['REQUEST_URI'] to it

	$uri = strtr($_SERVER['PHP_SELF'], ['/index.php' => '']);

	define('LINK', HTTP . SERVER_NAME . $uri); // Create a constant called LINK and append both HTTP and SERVER_NAME
	define('AUTHOR', '<br><br> &copy; 2019 <a href="https://sitepoint.com/community/u/spaceshiptrooper">spaceshiptrooper</a>');
	define('SEPARATOR', '<span class="separator p-r-10"></span>');

}