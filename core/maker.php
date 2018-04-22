<?php

namespace Core;

class Maker
{

	public static $namespaces = ['Router','View', 'Database as DB'];

	public function create_controller($class_name)
	{
		$content ="<?php \n\n";
		$file = __DIR__.'/../app/controller/'.ucwords($class_name).'.php';

		if(file_exists($file))
			return false;

		$content .="namespace App\Controller \n\n";
		foreach(self::$namespaces as $namespace)
		{
			$content .= sprintf('use namespace Core\%s'."\n",$namespace);
		}

		$content .="\nclass ".ucwords($class_name)."\n";
		$content .="{ \n\n\n";
		$content .='}';
	
		return file_put_contents($file, $content);
	
	}
}


?>