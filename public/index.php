<?php

	//ini_set('error_reporting', 'E_STRICT');

	require_once "vendor/autoload.php";

	$dotenv = \Dotenv\Dotenv::createImmutable(file_exists(__DIR__ . '/.env') ? __DIR__ : __DIR__ . '/..');
	$dotenv->safeLoad();

	$route = new \App\Route;
	
?>