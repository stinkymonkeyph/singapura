<?php 

function include_template($file)
{
	
	$file_dir = $file;

	if(strpos($file, '.') !== false)
	{
		$file_dir = str_replace('.', '/', $file);
	}

	include __DIR__ . '/../../views/'.$file_dir.'.php';
}


?>
