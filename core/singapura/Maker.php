<?php

namespace Core\Singapura;

class Maker
{

	private $namespaces = ['Router', 'View', 'Database as DB'];
	private $start= "<?php \n\n";
	private $upper_brace = "{\n";
	private $lower_brace = "\n}";
	private $extension = '.php';
	private $constructor = "\tpublic function __construct()\n\t{\n\n\t}";

	public function create_controller($class_name)
	{
		$content = $this->start;
		$file = __DIR__.'/../app/controller/'.ucwords($class_name).$this->extension;

		if(file_exists($file))
			return false;

		$content .="namespace App\Controller \n\n";
		$content .="// Default namespace used \n";

		foreach($this->namespaces as $namespace)
		{
			$content .= sprintf('use namespace Core\Singapura\%s'."\n",$namespace);
		}

		$content .= "\nclass ".ucwords($class_name)."\n";
		$content .= $this->upper_brace;
		$content .= $this->constructor;
		$content .= $this->lower_brace;
	
		return file_put_contents($file, $content);
	}

	public function create_model($class_name)
	{
		$content = $this->start;
		$file = __DIR__.'/../app/model/'.ucwords($class_name).$this->extension;

		if(file_exists($file))
			return false;

		$content .= "namespace App\Model \n\n";
		$content .= "\nclass ".ucwords($class_name)."\n";
		$content .= $this->upper_brace;
		$content .= $this->constructor;
		$content .= $this->lower_brace;

		return file_put_contents($file, $content);
	}
}


?>