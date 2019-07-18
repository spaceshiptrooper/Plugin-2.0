<?php
function template($bodys, $url = NULL) {

	$bod = [];

	$url = removePeroid($url);

	foreach($bodys AS $key => $body) {

		if(is_array($body[0]['type'])) {

			foreach($body[0]['type'] AS $keys => $value) {

				if($body[0]['type'] == 'global') {

					$bod[$key] = $body[0]['content'];

				} else {

					if($url == $value OR $value == 'home' AND $url == NULL OR $value == 'index' AND $url == NULL) {

						$bod[$key] = $body[0]['content'];

					} else {

						unset($body[$key]);

					}

				}

			}

		} else {

			if($body[0]['type'] == 'global') {

				$bod[$key] = $body[0]['content'];

			} else {

				if($url == $body[0]['type']) {

					$bod[$key] = $body[0]['content'];

				} else {

					unset($bodys[$key]);

				}

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

	if(!defined('CURRENT_THEME')) {
		define('CURRENT_THEME', 'default' . DS);
	}

	if(!defined('TITLE')) {
		define('TITLE', 'Project');
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
	} else {
		return '{{' . $m[1] . '}}';
	}

}

function removePeroid($url) {

	$url = explode('.', $url);

	return $url[0];

}

function defaultTemplate($bodys) {

	$header = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'header.php');
	$header = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $header);

	$regex = [
		'/\{\{BODY\}\}/is',
	];

	$return = [
		$bodys,
	];

	$body = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'body.php');
	$body = preg_replace($regex, $return, $body);
	$body = strtr($body, [' {{BODY}} ' => '', ' {{BODY}}' => '', '{{BODY}} ' => '', '{{BODY}}' => '']);
	$body = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $body);

	$footer = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'footer.php');
	$footer = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $footer);

	return $header . $body . $footer;

}

function dynamicTemplate($bodys, $url) {

	$header = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'header.php');
	$header = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $header);

	if(file_exists(ROOT . THEMES . CURRENT_THEME . $url . '.php')) {

		$regex = [
			'/\{\{BODY\}\}/is',
		];

		$return = [
			$bodys,
		];

		$body = file_get_contents(ROOT . THEMES . CURRENT_THEME . $url . '.php');
		$body = preg_replace($regex, $return, $body);
		$body = strtr($body, [' {{BODY}} ' => '', ' {{BODY}}' => '', '{{BODY}} ' => '', '{{BODY}}' => '']);
		$body = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $body);

	} else {

		$regex = [
			'/\{\{BODY\}\}/is',
		];

		$return = [
			$bodys,
		];

		$body = file_get_contents(ROOT . THEMES . CURRENT_THEME . '404.php');
		$body = preg_replace($regex, $return, $body);
		$body = strtr($body, [' {{BODY}} ' => '', ' {{BODY}}' => '', '{{BODY}} ' => '', '{{BODY}}' => '']);
		$body = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $body);

	}

	$footer = file_get_contents(ROOT . THEMES . CURRENT_THEME . 'footer.php');
	$footer = preg_replace_callback('/\{\{(.*?)\}\}/is', 'callConstant', $footer);

	return $header . $body . $footer;

}
