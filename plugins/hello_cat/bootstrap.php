<?php
function hello_cat($arrayBody) {

	$hello_cat = 'Hello user from the IP Address: <strong>' . REMOTE_ADDRESS . '</strong> ';

	$array = [
		'type' => 'global',
		'content' => $hello_cat,
	];

	array_push($arrayBody, $array);

	return $arrayBody;

}