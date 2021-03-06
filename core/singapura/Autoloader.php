<?php 
	
	
class Autoloader
{

	public static function autoload_register( $class_name ) 
	{
		$paths = array(
			'/../../app/controller/',
			'/../../app/model/',
			'/../../core/singapura/',
			'/../../core/external/'
		);

		foreach($paths as $path)
		{
			$base_class = explode('\\', $class_name);
			$trim_base_class = end($base_class);
			$file = __DIR__ . $path . $trim_base_class . '.php' ; 
			
			if( file_exists( $file )) 
			{
				require $file;
			}
		}
	}
}

spl_autoload_register('Autoloader::autoload_register');

?>