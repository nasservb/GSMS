<?php //allahoma sale ala mohammad va ale mohammad
//template used for display information with requested format. on model layer start 6-2-91 by nasser niazy in gooya smslearning system
 $info = array();
class template
{
	public $info;
	//for fill info array by default value
	public function __construct()
	{
		global $info;
		$this->info =& $info;
		//for store all template configuration value
		$this->set_default_value();
		GSMS::$class['system_log']->log('debug', "template Class Initialized");
	}//func
	public function header($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'header.php');
	}//fun
		
	public function load($Info,$page)
	{
		$this->fetch_sent_info($Info);
		global $info;
		
		require_once($this->info['theme_path'].$page.'.php');
	}//fun
	
	public function paging($link,$begin,$itemCount)
	{
		$body='';
		if($itemCount > GSMS::$config['page_item_per_page'])
		{
			// paging code 
			
			$mx=round($itemCount / GSMS::$config['page_item_per_page']);
			
			if($begin<(GSMS::$config['page_item_per_page']*5))
			{
				$start =0;
			}
			else
			{
				 $start=( round($begin / GSMS::$config['page_item_per_page']) -5 ) ;
				 $body .='<a class="page_btn" href=\''.$link .'/0/'.GSMS::$config['page_item_per_page'].'\'>1</a>';
			}
			$forcount=0;
			
			
			for($i=$start ; $i<$mx;$i++)
			{
				$forcount++;
				
				$body .=($i!=0 ?  '::':'');
				if(($i * GSMS::$config['page_item_per_page'])==$begin)
				{
					$body .= '<span class="page_btn_disabled">'.($i+1).'</span>' ;
					continue;
				}
				$body .='<a class="page_btn" href=\''.$link.($i* GSMS::$config['page_item_per_page']).
					'/'.($i+1)*GSMS::$config['page_item_per_page'].'\'>'.
					($i+1).'</a>';
				if($forcount>10)
					$i+=round( sqrt($mx));
				if(($i-$mx)>3 )
				{
					$body .='::<a class="page_btn" href=\''.$link.(($mx-1)* (GSMS::$config['page_item_per_page'])).
						'/'.$itemCount.'\'>'.
						($mx)  .'</a>';
				}
			}//for
			
		$body .= '	<script>
						var step = '.GSMS::$config['page_item_per_page'].';
						var url = "'.$link.'";
						function goPage(num)
						{	
							document.location = url + ((num-1)*step )  + "/" +(num*step ); 
						}
					</script>
		::<input type="text" style="width:50px" id="txtGo" value="1" /><a  class="page_btn" href="javascript:void(0)" onclick="goPage(txtGo.value)">Go</a>';
	
			
		}//if
				return $body;
	}
	
	public function message($title,$content,$part,$class="message-info",$format=true,$backLink=true)
	{
		
		
		if($format == true)
		{
			$content  = '<div class="'.$class.'">'.$content.'</div>';
			
		}
		if($backLink == true)
				$content .= '<br><a class="back_btn" href="'. $this->info[$part.'_url']. '">برگشت</a>' ; 	
		$inf=array('title'=>$title,'page_title'=>$title,'body'=>$content);
		
		$this->load($inf,'header');
		
		$this->load($inf,($part == 'user' ? $part : 'admin'). '_header');
		$this->load($inf, 'index');
		$this->load($inf, 'footer');
	}
	
	public function head($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'head.php');
	}//fun
	public function footer($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'footer.php');
	}//fun
	public function index($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'index.php');
	}//fun
	public function intro($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'intro.php');
	}//fun
	public function panel_header($Info)
	{
		$this->fetch_sent_info($Info);
		global $info;
		require_once($this->info['theme_path'].'panel_header.php');
	}//fun
	private function fetch_sent_info($Info)
	{
		//$this->set_default_value();
		$keys=array_keys($Info);
		if (is_array($keys) AND count($keys) > 0)
		{
			foreach ($keys as $key )
			{
				//if (key_exists($key,$this->info))
					$this->info[$key]=$Info[$key];
			}//each
		}//if
		
	}//fun
	private function set_default_value()
	{	
	
		GSMS::load('option','class'); 
		
		list($active_theme) = GSMS::$class['option']->get_optionsByKey('theme_active');
		if(count($active_theme)>0 )
		{
			list($themes) = GSMS::$class['option']->get_optionsByValue($active_theme[0]->value);
			if(count($active_theme)>0 )
			{
				GSMS::$route['theme'] = $active_theme[0]->value;
			}
		}
	
		if ( (!isset(GSMS::$route['theme'])) or
				(GSMS::$route['theme']=='') or
				(GSMS::$route['theme']=='default') )
		{
			$this->info['theme_url']=GSMS::$siteURL.GSMS::$outputDir.'themes/'.'default/';
			$this->info['theme_path']=GSMS::$rootDir.GSMS::$outputDir.'themes/'.'default/';
		}
		else
		{
			$this->info['theme_url']=GSMS::$siteURL.GSMS::$outputDir.'themes/'.GSMS::$route['theme'].'/';
			$this->info['theme_path']=GSMS::$rootDir.GSMS::$outputDir.'themes/'.GSMS::$route['theme'].'/';
		}//if
		
		
		$this->info['url']=GSMS::$siteURL;
		
		if((GSMS::$class['session']->checkLogin())==true)
		{
			$this->info['login']=true;
			$user=GSMS::$class['session']->getUser();
			$this->info['username']=$user['UserName'];
			$this->info['usertype']=$user['UserType'];
		}
		else
		{
			$this->info['login']=false;
			$this->info['login_url']=GSMS::$siteURL.GSMS::$index.'/login';
		}//else
		$this->info['charset']=GSMS::$charset;
		
		GSMS::$class['calendar']->farsiDigits=true;
		$this->info['datetime']= GSMS::$class['calendar']->date(" j F H:i ",time(),GSMS::$config['date_gmt']);
		$this->info['index_url']=GSMS::$siteURL.GSMS::$index.'/index/';
		$this->info['register_url']=GSMS::$siteURL.GSMS::$index.'/index/register';
		$this->info['test_url']=GSMS::$siteURL.GSMS::$index.'/telgroups/register';
		$this->info['index']=GSMS::$siteURL.GSMS::$index.'/';
		$this->info['url']=GSMS::$siteURL;
		$this->info['icon']=$this->info['theme_url'].'images/icon.icn';
		$this->info['name']='سیستم مدیریت چاپخانه پیام رسانه';
		$this->info['describe']='چاپ,نشر,چاپخانه,چاپ لیبل,چاپ صنعتی ,بزرگ ترین چاپخانه,چاپ حرفه ای,چاپ خودکار,چاپ دیجیتال,عظیم ترین چاپخانه';
		 
		$this->info['keyword']='چاپ,نشر,چاپخانه,چاپ لیبل,چاپ صنعتی ,بزرگ ترین چاپخانه,چاپ حرفه ای,چاپ خودکار,چاپ دیجیتال,عظیم ترین چاپخانه';
		GSMS::$class['calendar']->farsiDigits=false;
		$this->info['date']=GSMS::$class['calendar']->date("Y-d-m ",time(),GSMS::$config['date_gmt']);
		$this->info['copyright']='http://www.anichap.com';
		$this->info['page_title']='سیستم مدیریت چاپخانه پیام رسانه';
		$this->info['align']='center';
		$this->info['activeTab']='telgroup';
		$this->info['dir']='rtl';
		$this->info['admin_url']=GSMS::$siteURL.GSMS::$index.'/admin/';
		$this->info['user_url']=GSMS::$siteURL.GSMS::$index.'/user/';
		$this->info['employ_url']=GSMS::$siteURL.GSMS::$index.'/employ/';
		$this->info['logout_url']=$this->info['index_url'].'logout';
		$this->info['footer_text']='کلیه حقوق این وبسایت محفوظ و متعلق به سیستم مدیریت چاپخانه پیام رسانه می باشد.<br/>';
	}
}//class
?>