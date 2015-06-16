<?php

define ('BASE_PATH', realpath(__DIR__.'/src'));

function autoloader($class)
{
	if (strpos($class, "Assert") !== false)
		$filename = BASE_PATH.'/Assert/lib/'. str_replace('\\', '/', $class) . '.php';
	else
    	$filename = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';
	
    include($filename);
}

spl_autoload_register('autoloader');