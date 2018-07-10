<?php //allahoma sale ala mohammad va ale mohammad 

	class plugin
	{
		public function __construct()
		{
			$this->loadPlugins();
		}
		
		public function loadPlugins()
		{
			foreach(scandir(GSMS::$pluginsDir) as $file)  
			{  
				if(is_dir(GSMS::$pluginsDir. $file) && strlen($file) > 2 )
				{
					GSMS::load($file,'plugins'); 
				}
			}  
			
		}
		
		public function listPlugins($isActive=-1)
		{
			
		}
		
		
		
		public function installPlugin()
		{
			
		}
		
		public function uninstallPlugin()
		{
			
		}
		
		public function activePlugin()
		{
			
		}
		
		public function deactivePlugin()
		{
			
		}
		
	}
?>