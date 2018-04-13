<?php 

/** 
	Autoload classes
	/core/Autoloader.php
**/
require __DIR__.'/../core/autoloader.php';

/**
	Make Application
	/core/Singapura.php
**/
$app = new Core\Singapura();
$app->make_app();

?>

