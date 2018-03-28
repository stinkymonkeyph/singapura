<?php 

function extend_template($file)
{
	load_file($file);
}

function load_file($file)
{
	$file_dir = $file;

	if(strpos($file, '.') !== false)
	{
		$file_dir = str_replace('.', '/', $file);
	}

	include __DIR__ . '/../views/'.$file_dir.'.php';
}

function include_template($file)
{
	load_file($file);
}



?>