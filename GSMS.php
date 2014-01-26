<?php //allahoma sale ala mohammad va ale mohammad
//main class of gooya smslearning system on model layer start 3-2-91 by nasser niazy in gooya smslearning system
class GSMS
{
	public static $config=array(	//---------database---------------
									'db_system'=>'mysql',
									'db_hostname'=>'localhost',     
									'db_databasename'=>'gsms',
									'db_databaseuser'=>'root',
									'db_databasepass'=>'',
									'db_charset'=>'utf8',
									//----------date time-----------------
									'date_format'=>'Y-m-d H:i:s',	//datetime standard format 
									'date_gmt'=>'12600',				//distance from gmt [iran is 12600][server on web is 0] 
									//----------log----------------------
									'log_path'=>'log/',
									'log_enabled'=>true,
									'log_date_format'=>'Y-m-d__h_i_s a',
									'log_level'=>4,					//'ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4'
									//-----------utf8------------------------
									'utf8_enabled'=>false,
									'utf8_mb_enabled'=>false,
									//-----------cookie--------------------input,security needs that config
									'cookie_prefix'	=> "",
									'cookie_domain'	=> "",
									'cookie_path'=> "/",
									'cookie_secure'	=> FALSE,
									//----------security config----------------
									'allow_get_array'=> TRUE,
									'global_xss_filtering' => true,//		defualt is FALSE,
									'csrf_protection' => false,   // 		defualt is FALSE, add hiden field in post and cookie and verify in distenation
									'proxy_ips' => '',
									'password_crypt_key' => 'nani',		//this value is used in session encode function [crypt('pass','key')]
									'csrf_token_name' => 'csrf_test_name',
									'csrf_cookie_name' => 'csrf_cookie_name',
									'csrf_expire' => 7200,
									//----------url config for config.php------------
									'base_url'	=> '',
									'index_page' => 'index.php',
									'uri_protocol'=>'AUTO',
									'permitted_uri_chars' => 'a-z 0-9~%.:_\-',
									'enable_query_strings' => FALSE,
									'url_suffix' => '',
									'controller_trigger'	=> 'c',
									'directory_trigger'		=> 'd',		// experimental not currently in use
									'function_trigger'		=> 'm',		//if enable query string is true we use index.php?c=class&d=directory&m=function
									
									//------------smssender----------------
									'sms_number'			=>'3000324322',
									'sms_username'			=>'',
									'sms_password'			=>'',
									'sms_class'				=>'tose', //['magfa','tose','fara',..]
									'sms_wsdl_url'			=>'http://mihansmscenter.ir/webservice/?wsdl',//[magfa ='http://webservice.magfa.com/services/urn:SOAPSmsQueue?wsdl']
									'sms_domain'			=>'ts.co.ir',		//in sunoptic that is seted by 'magfa.com'
									//------------paging----------------------
									'page_item_per_page'	=>30
									);	
	public static $route=array(		
									//------------router-------------------
									'default_page' => "index",
									'404_override' => '',
									'theme'=>'default'
									);
	public static $rootDir;		//root folder of system	
	public static $libsDir;		//librery(Model) folder of system
	public static $tempDir;		//temp folder for store temporaty value [session ,..]
	public static $classDir;	//class(Controller) folder of system 
	public static $outputDir;	//evrythin that user in see in output [view folder]
	public static $siteURL;		//system url on web [http://example.com] 
	public static $index;		//index page of system
	public static $charset;		//output charset of system [utf-8 , iso,...]

	public static $soap;		//soap server variable for create soap server[not used]
	public static $class=array();	//list of class[controller] of system ,that is variable in evrytime .
	
	/* for multi instance classes
	public static function init( )
    {
		static $instance = null;
		if ( isset( $instance ) )
		{
		$instance = new self( );
		}
    }
	*/
	public function __construct( )
	{
	
		// Turn off all error reporting
		//error_reporting(0);

		// Report simple running errors
		//error_reporting(E_ERROR | E_WARNING | E_PARSE);

		// Reporting E_NOTICE can be good too (to report uninitialized
		// variables or catch variable name misspellings ...)
		//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

		// Report all errors except E_NOTICE
		// This is the default value set in php.ini
		//error_reporting(E_ALL ^ E_NOTICE);

		// Report all PHP errors (see changelog)
		error_reporting(E_ALL);

		// Report all PHP errors
		//error_reporting(-1);

		// Same as error_reporting(E_ALL);
		//ini_set('error_reporting', E_ALL);

		//--------definding system directoris	
		self::$rootDir = rtrim( realpath( dirname( __file__ ) ), "\\/" )."/";
		self::$libsDir = self::$rootDir."libs/";
		self::$tempDir = self::$rootDir."temp/";
		self::$classDir = self::$rootDir."class/";
		self::$outputDir=	"panel/";
		self::$index=self::$config['index_page'];
		self::$charset="UTF-8";
		
		//---------------loading GSMS framework main libraries
		
		//--------system logger  for log all err
		$this->load('system_log','lib');
			
		//--------system display all error and bug
		$this->load('exceptions','lib');
		
		//--------calendar for jalaji date time 
		$this->load('calendar','lib');
		
		//--------database engin for stor all database-side information
		$this->load('DB','database/'.self::$config['db_system']);

		//--------session for control session info .stor and fetch
		$this->load('session','lib');
		
		//--------input class for process and filter value to standard format
		$this->load('input','lib');
	}//fun
	public function load($className,$directory,$parameter='')
	{
		if (isset(self::$class[$className]))
		{
			return ;// class already loaded
		}//if
		if (($className=='soapserver')||($className=='soapclient'))
		{
			if( file_exists(self::$rootDir.'libs/nusoap/nusoap.php'))
			{
				if (! class_exists ($className))
				{
					require(self::$rootDir.'libs/nusoap/nusoap.php');
					
					if($className =='soapserver')
					{	
					// parameter can have a wsdl file url or wsdl class that is instance of wsdl class in nusoap file
						self::$class[$className]=new soapserver($parameter); 
					}
					else
					{
					// parmeter is a webservice adress thats read from configuration 
						self::$class[$className]=new soapclient($parameter,'wsdl');
					}//else
				}
				else
				{
					self::$class['system_log']->log('ERROR','the soap class is already exist');
				}//if	
			}
			else
			{
				self::$class['system_log']->log('ERROR','the nusoap is not exist');
			}//if
			return ;
		}//if
		
		//		especial condition 
		if ($directory=='lib')	$directory ='libs/'.$className;
		if ($directory=='view') $directory = self::$outputDir.$directory;
		if( file_exists(self::$rootDir.$directory.'/'.$className.'.php'))
		{
			if (! class_exists ($className))
			{
				require(self::$rootDir.$directory.'/'.$className.'.php');
				
				if($parameter =='')
				{
					self::$class[$className]=new $className();
				}
				else
					self::$class[$className]=new $className($parameter);
			}//if	
		}//if
	}//func
}//class
	define( "GSMS", "v1.0 beta" );
