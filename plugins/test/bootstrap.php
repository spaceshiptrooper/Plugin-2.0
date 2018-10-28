<?php
function test($arrayBody) {

	$arrays = [];

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$new = postAction($_POST, $arrays, LINK . 'test');
		print_r($new);

	}

	$test = file_get_contents(ROOT . PLUGINS . 'test/test.php');

	$array = [
		'type' => 'test',
		'content' => $test,
	];

	array_push($arrayBody, $array);

	return $arrayBody;

}