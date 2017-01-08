<?php //allahoma sale ala mohammad va ale mohammad
//index page for view in general. on view layer start 6-2-91 by nasser niazy in gooya smslearning system

class index
{
	public function __construct()
	{
		//constructor
		if (! isset(GSMS::$class['template']))
			GSMS::load('template','lib');
		GSMS::$class['system_log']->log('DEBUG', 'index controller started successfull');
	}//fun
		
	public function logout()
	{
		GSMS::$class['session']->logout();
		GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
	}	
	
	public function index($begin=0, $end=30)
	{
		$begin=($begin < 0  ? 0 : $begin) ; 
		$end=($end < 1  ? 30 : $end) ; 
	
		if (GSMS::$class['session']->checkLogin()==true)
		{
			$user=GSMS::$class['session']->getUser();
			
			if($user['UserType'] == 1)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/admin/index");
				return;
			}
			elseif($user['UserType'] == 2)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/user/index");
				return;
			}
			elseif($user['UserType'] == 3)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/employ/index");
				return;
			}
			else
			{
				$this->logout();
			}
			
		}
		
		//GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/telgroups");
		GSMS::load('home','site_view','root');
	}
	
	
	public function coverView($id=0,$type=1)
	{
		
		GSMS::load('template','lib');
		
		$photo =R::dispense('picture');
		$photo = R::load('picture',$id);
			
		$path='';
		
		if($photo == 404 ||$id== 0)
		{
			switch($type)
			{ 
				case 1: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupCover.jpg";break;
				case 2: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telidCover.jpg";break;
				case 9: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/adsCover.jpg";break;
			}
		}
		else
		{
			$path=GSMS::$config['photo_archive_path'].$photo->picture_path;
		}
		
		 return $this->loadImage($path);
	}
	
	public function iconView($id=0,$type=1)
	{
		GSMS::load('template','lib');
		GSMS::load('picture','class');
		
		$photo =R::dispense('picture');
		$photo = R::load('picture',$id);
		
		$path='';
		
		if($photo == 404 ||$id== 0)
		{
			switch($type)
			{
				case 1: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupIcon.png";break;
				case 2: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telidIcon.png";break;
				case 3: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telstickerIcon.png";break;
				case 4: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telrobotIcon.png";break;
				case 7: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telchannelIcon.png";break;
				case 9: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/adsIcon.png";break;
				default: $path=GSMS::$rootDir . GSMS::$outputDir."views/images/telgroupIcon.png";break;
			}
		}
		else
		{
			$path=GSMS::$config['photo_archive_path'].$photo->picture_path;
		}
		
		if($type ==11 )
			return $this->loadImage($path,false);
		else  
			return $this->loadImage($path,($id!=6767));
		
		
	}
	
	private function loadImage($path,$mini =false)
	{
		
		//ini_set('display_errors', 'off'); 
		// Report simple running errors 
		//error_reporting(E_ALL );
	   // File Exists? 
	   if( file_exists($path) )
	    {
			
			//$im = imagecreatefrompng($path);
			$im=null;
			$gis        = getimagesize($path );
			$type        = $gis[2];
			header("Cache-Control: private, max-age=10800, pre-check=10800");
			header("Pragma: private");
			header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
			switch($type)
			{
				 case "1": 
					header('Content-type: image/gif');
					$im = imagecreatefromgif($path); 
					break;
				 case "2": 
					header('Content-type: image/jpeg');
					$im = imagecreatefromjpeg($path);
					break;
				 case "3": 
					
					header('Content-type: image/png');
					$im = imagecreatefrompng($path); 
					imagealphablending($im, true);
					
					break;
				 default: continue ;
			}
			if($mini == true)
			{
				$new_width=GSMS::$config['photo_small_width'];
				$new_height=GSMS::$config['photo_small_height'];
				
				$width = imagesx($im); 
				$height = imagesy($im);
				
				$thumb = imagecreatetruecolor($new_width, $new_height);
				imagealphablending($thumb, true);
				imagesavealpha($im, true);
				
				//$new_image = imagecreatetruecolor($new_width,$new_height); 
				
				
				//ImageCopyResized($new_image, $im,0,0,0,0, $new_width, $new_height, $width, $height);
				imagecopyresampled($thumb, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagepng($thumb );
				
				header("Content-Disposition: inline; filename=".basename($path));
				imagedestroy($new_image);
				imagedestroy($im);
				return;
			}
		
			header("Content-Disposition: inline; filename=".basename($path));
			imagepng($im );
			imagedestroy($im);

		} else 
			die('File Not Found:'.$path);
	}
	
	
	function help()
    {
		GSMS::load('help','site_view','root');
    }

	public function rule()
	{
		GSMS::load('rule','site_view','root');
	}
	
	public function about()
	{
		GSMS::load('about','site_view','root');
	}
	
	public function question()
	{
		GSMS::load('question','site_view','root');
	}
	
	public function contact($p='')
	{
		$p= (GSMS::$class['session']->checkLogin()==true) ? 1 : '' ;
		GSMS::load('contact','site_view','root',$p);
		
	}
	
	public function requestVip()
	{
		
		GSMS::load('contact','site_view','root',3);
		
	}
	 
	function getShahr($ostan=0,$json=false)
    {
	
		if($ostan == 0 )
		{
			return '<option value=0>همه شهر ها</option>';
		}
		
		$tempShahr = R::dispense('shahr');
		$tempShahr = R::getAll('select * from shahr where ostan_id = '. $ostan);
		$shahrs = array();
		$shahrs_body='';
		
		for($i=0 ; $i<count($tempShahr);$i++)
		{
			
			if($json == true)
			{
				$shahrs[$i] = array('id'=>$tempShahr[$i]['id'] , 'name'=>$tempShahr[$i]['name']);
			}
			else
			{
				$shahrs_body.='<option value='.$tempShahr[$i]['id'].'>'.$tempShahr[$i]['name'].'</option>';
			}
		}
		
		
		if($json == true)
			echo json_encode($shahrs);
		else 
			echo $shahrs_body;
    }
 
	
}//class
?>