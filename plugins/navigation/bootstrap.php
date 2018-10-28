<?php
function navigation($arrayBody) {

	$navigation = file_get_contents(ROOT . PLUGINS . 'navigation/navigation.php');

	$navigation = strtr($navigation, ['{{LINK}}' => LINK]);

	$array = [
		'type' => 'global',
		'content' => $navigation,
	];

	array_push($arrayBody, $array);

	return $arrayBody;

}