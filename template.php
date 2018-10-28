<?php
function template($bodys, $url = NULL) {

	$bod = [];

	$url = removePeroid($url);

	foreach($bodys AS $key => $body) {

		if($body[0]['type'] == 'global') {

			$bod[$key] = $body[0]['content'];

		} else {

			if($url == $body[0]['type']) {

				$bod[$key] = $body[0]['content'];

			} else {

				unset($bodys[$key]);

			}

		}

		if(count($bod) > 1) {
		} else {

			if(isset($bodys[$key])) {
				$bodys = $bodys[$key];
			}

		}

	}

	if(count($bod) > 1) {

		$bodys = implode("\r\n", $bod);
		$bodys = $bodys . '{{BODY}}';

	} else {

		$bodys = $bodys[0]['content'] . '{{BODY}}';

	}

	if($url == NULL) {

		return defaultTemplate($bodys);

	} else {

		return dynamicTemplate($bodys, $url);

	}

}

function callConstant($m) {

	if(defined($m[1])) {
		return constant($m[1]);
	}

}

function removePeroid($url) {

	$url = explode('.', $url);

	return $url[0];

}

function defaultTemplate($bodys) {

	$header = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'header.php');
	$header = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $header);

	$body = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'body.php');
	$body = preg_replace('/\{\{(.*?)\}\}/is', $bodys, $body);
	$body = strtr($body, [' {{BODY}} ' => '', ' {{BODY}}' => '', '{{BODY}} ' => '', '{{BODY}}' => '']);

	$footer = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'footer.php');
	$footer = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $footer);

	return $header . $body . $footer;

}

function dynamicTemplate($bodys, $url) {

	$header = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'header.php');
	$header = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $header);

	if(file_exists(ROOT . THEMES . CURRENT_THEME . $url . '.php')) {

		$body = file_get_contents(ROOT . THEMES . CURRENT_THEME . $url . '.php');
		$body = preg_replace('/\{\{(.*?)\}\}/is', $bodys, $body);
		$body = strtr($body, [' {{BODY}} ' => '', ' {{BODY}}' => '', '{{BODY}} ' => '', '{{BODY}}' => '']);

	} else {

		$body = file_get_contents(ROOT . THEMES . CURRENT_THEME . '404.php');
		$body = preg_replace('/\{\{(.*?)\}\}/is', $bodys, $body);
		$body = strtr($body, [' {{BODY}} ' => '', ' {{BODY}}' => '', '{{BODY}} ' => '', '{{BODY}}' => '']);

	}

	$footer = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'footer.php');
	$footer = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $footer);

	return $header . $body . $footer;

}