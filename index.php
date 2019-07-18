<?php
define('DS', '/'); // Define the Directory Separator
define('ROOT', realpath(__DIR__) . DS); // Define the root folder and append DS after it
define('THEMES', 'themes' . DS); // Define the themes folder and append DS after it
define('PLUGINS', 'plugins' . DS); // Define the plugins folder and append DS after it
define('REMOTE_ADDRESS', $_SERVER['REMOTE_ADDR']);

// Search through all the folders within the plugin folder for the bootstrap files.
$bootstraps = glob(ROOT . PLUGINS . '*' . DS . 'bootstrap.php');

require_once ROOT . 'hook.php'; // Require the hook file
require_once ROOT . 'server.php'; // Require the hook file
require_once ROOT . 'constants.php'; // User defined constants

server();

$arrayBody = [];

// Since glob is an array, you'll need foreach for this.
// So throw it in a foreach loop and append an item value to it.
foreach($bootstraps as $bootstrap) {

	// Check to see if the file exists first. If it doesn't, we are not going to require/ include it.
	if(file_exists($bootstrap)) {

		// Explode the bootstrap file by the directory separator.
		$explode = explode(DS, $bootstrap);

		// Go to the end of the array.
		$end = end($explode);

		// Go back one from the end of the array.
		// This should go from /bootstrap.php to /{function_name}.
		$name = prev($explode);

		// This method is a lot easier to implement than the older one
		// since there is no need for any manual character stripping.

		// The plugin_hook function works as is.
		// {full_path_to_file}, {function+filename}
		$bodys[$name] = plugin_hook($bootstrap, $name, $arrayBody);

	}

}

// Move the navigations array to the front of the main array.
$bodys = array_merge(array('navigation' => $bodys['navigation']), $bodys);

require_once ROOT . 'template.php'; // Require the template file. This file is needed to actually display the layout.

if(isset($_GET['url'])) {

	print template($bodys, $_GET['url']); // Call the template function.

} else {

	print template($bodys); // Call the template function.

}