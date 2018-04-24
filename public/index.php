<?php 

/**
	@author: Nelmin Jay Anoc
	@project: Singapura
	@cliche: Reinventing the wheel
**/

/** 
	Autoload classes
	/core/Autoloader.php
**/
require __DIR__.'/../core/singapura/autoloader.php';

/**
	Make Application
	/core/Singapura.php
**/
$app = new Core\Singapura\Singapura();
$app->load();

?>

