<?php //allahoma sale ala mohammad va ale mohammad
//main class of gooya smslearning system on model layer start 3-2-91 by nasser niazy in gooya smslearning system
class GSMS
{
    public static $config=array(    //---------database---------------
                                    'db_system'=>'mysql',
                                    'db_hostname'=>'localhost',
                                    'db_databasename'=>'database_name',
                                    'db_databaseuser'=>'database_user',
                                    'db_databasepass'=>'database_pass',
                                    'db_charset'=>'utf8',
                                    'db_return_type'=>'array',
                                    //------------payment-----------------
                                    'payment_defualt'=>'zarinpal',
                                    
                                    'payment_zarinpal_api_key'=>'',
                                    
                                    'payment_payline_api_key'=>'',
                                    
                                    'payment_mellat_terminal'=>'',
                                    'payment_mellat_user'=>'',
                                    'payment_mellat_pass'=>'',
                                    
                                    //----------date time-----------------
                                    'date_format'=>'Y-m-d H:i:s',    //datetime standard format
                                    'date_gmt'=>'12600',                //distance from gmt [iran is 12600][server on web is 0]
                                    //----------log----------------------
                                    'log_path'=>'log',
                                    'log_enabled'=>true,
                                    'log_date_format'=>'Y-m-d__h_i_s a',
                                    'log_level'=>4,                    //'ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4'
                                    //-----------utf8------------------------
                                    'utf8_enabled'=>false,
                                    'utf8_mb_enabled'=>false,
                                    //-----------cookie--------------------input,security needs that config
                                    'cookie_prefix'    => "",
                                    'cookie_domain'    => "",
                                    'cookie_path'=> "/",
                                    'cookie_secure'    => false,
                                    //----------security config----------------
                                    'allow_get_array'=> true,
                                    'global_xss_filtering' => true,//		defualt is FALSE,
                                    'csrf_protection' => false,   // 		defualt is FALSE, add hiden field in post and cookie and verify in distenation
                                    'proxy_ips' => '',
                                    'password_crypt_key' => 'nani',        //this value is used in session encode function [crypt('pass','key')]
                                    'csrf_token_name' => 'csrf_test_name',
                                    'csrf_cookie_name' => 'csrf_cookie_name',
                                    'csrf_expire' => 7200,
                                    //----------url config for config.php------------
                                    'base_url'    => '',
                                    'index_page' => 'index.php',
                                    'uri_protocol'=>'AUTO',
                                    'permitted_uri_chars' => 'a-z 0-9~%.:_\-',
                                    'enable_query_strings' => false,
                                    'url_suffix' => '',
                                    'controller_trigger'    => 'c',
                                    'directory_trigger'        => 'd',        // experimental not currently in use
                                    'function_trigger'        => 'm',        //if enable query string is true we use index.php?c=class&d=directory&m=function
                                    
                                    //------------paging----------------------
                                    'page_item_per_page'    =>15,
                                    //------------photo----------
                                    'audio_format'=>'MP3 mpeg layer 3',
                                    'photo_archive_path'=>'archive',
                                    'photo_resize'=>false,
                                    'photo_thumbs'=>true,
                                    'photo_width' =>1772,//800,
                                    'photo_height' =>1181,//600,
                                    'photo_small_width' =>100,
                                    'photo_small_height' =>80,
                                    'photo_dpi' =>300,//72,
                                    'photo_format' =>'jpg'
                                    );
    public static $route=array(
                                    //------------router-------------------
                                    'default_page' => "index",
                                    '404_override' => '',
                                    'theme'=>'material'//'blue_isar'
                                    );
    public static $rootDir;        //root folder of system
    public static $libsDir;        //librery(Vendor) folder of system
    public static $tempDir;        //temp folder for store temporaty value [session ,..]
    public static $classDir;    //class(model) folder of system
    public static $controllersDir;    //Controllers folder of system
    public static $pluginsDir;    //Controllers folder of system
    public static $outputDir;    //evrythin that user in see in output [view folder]
    public static $siteURL;        //system url on web [http://example.com]
    public static $index;        //index page of system
    public static $charset;        //output charset of system [utf-8 , iso,...]

    public static $soap;        //soap server variable for create soap server[not used]
    public static $class=array();    //list of class[controller] of system ,that is variable in evrytime .
    
    public function __construct()
    {
    
        ini_set('max_execution_time', 500);
        ini_set('memory_limit', '128M');
        ini_set('display_errors', 'on');

        ini_set('file_uploads', 'On');

        // Report simple running errors
        error_reporting(E_ERROR | E_PARSE);
        // error_reporting(E_ALL);

        //--------definding system directoris
		self::$config['photo_directory_spliter']=strstr(realpath("./"), "\\") ? "\\" : "/";
       
        self::$config['log_path'] .= '/';
        self::$config['photo_archive_path'] .= DIRECTORY_SEPARATOR;
        self::$rootDir =  realpath(dirname(__file__)). DIRECTORY_SEPARATOR;
        self::$libsDir = self::$rootDir.'libs'. DIRECTORY_SEPARATOR ;
        self::$tempDir = self::$rootDir.'archive'. DIRECTORY_SEPARATOR .'tmp'. DIRECTORY_SEPARATOR ;
        self::$classDir = self::$rootDir.'models'. DIRECTORY_SEPARATOR ;
        self::$controllersDir = self::$rootDir.'controllers'. DIRECTORY_SEPARATOR ;
        self::$pluginsDir = self::$rootDir.'plugins'. DIRECTORY_SEPARATOR ;
        self::$outputDir=    'public/' ;
        self::$index=self::$config['index_page'];
        self::$charset='UTF-8';
         
        //---------------loading GSMS framework main libraries
        
        //--------system logger  for log all err
        $this->load('system_log', 'core');
            
        //--------system display all error and bug
        $this->load('exceptions', 'core');
		
		
        
        //--------calendar for jalaji date time
        $this->load('calendar', 'core');
        
        //--------database engin for stor all database-side information
        $this->load('DB', 'database', self::$config['db_system']);

        //--------session for control session info .stor and fetch
        $this->load('session', 'core');
		 
        
        //--------input class for process and filter value to standard format
        $this->load('input', 'core');
		
        $this->load('router', 'core');
        //---------redbean orm loading ...
        $this->load('rb', 'database', 'rb', 'require');
        
        R::setup(
        
            'mysql:host='.self::$config['db_hostname'].
                    ';dbname='.self::$config['db_databasename'],
                    self::$config['db_databaseuser'],
                    self::$config['db_databasepass']
        
        ); //for both mysql or mariaDB
           
        R::ext('xdispense', function( $type ){ 
            return R::getRedBean()->dispense( $type ); 
        }); 
                   
        R::exec('SET NAMES utf8');
		
		
		$this->load('template', 'core');
		
        $this->load('plugin', 'core');
		
    }//fun
    
    public function load($className, $directory, $place='', $parameter='')
    {
        if (isset(self::$class[$className])) {
            return ;// class already loaded
        }//if
        
        if ($directory=='plugins') {
            if ($place == '') {
                $directory ='plugins' .DIRECTORY_SEPARATOR .$className;
            } else {
                $directory ='plugins' . DIRECTORY_SEPARATOR .$place;
            }
        }
        
		
		
        
        if ($directory=='core') {
            if ($place == '') {
                $directory ='core' .DIRECTORY_SEPARATOR .$className;
            } else {
                $directory ='core' . DIRECTORY_SEPARATOR .$place;
            }
        }
		
        if ($directory=='core') {
            if ($place == '') {
                $directory ='core' .DIRECTORY_SEPARATOR .$className;
            } else {
                $directory ='core' . DIRECTORY_SEPARATOR .$place;
            }
        }
		
        if ($directory=='libs') {
            if ($place == '') {
                $directory ='libs' .DIRECTORY_SEPARATOR .$className;
            } else {
                $directory ='libs' . DIRECTORY_SEPARATOR .$place;
            }
        }
		
        if ($directory=='payment') {
            if ($place == '') {
                $directory ='libs' .DIRECTORY_SEPARATOR .'payment' .DIRECTORY_SEPARATOR .$className;
            } else {
                $directory ='libs' .DIRECTORY_SEPARATOR .'payment'  . DIRECTORY_SEPARATOR .$place;
            }
        }
        if ($directory=='database') {
            if ($place == '') {
                $directory ='database' .DIRECTORY_SEPARATOR .$className;
            } else {
                $directory ='database' . DIRECTORY_SEPARATOR .$place;
            }
        }
        
        if ($directory=='site_view') {
            $directory ='views'. DIRECTORY_SEPARATOR .'site'. DIRECTORY_SEPARATOR .$place;
        }
        if ($directory=='user_view') {
            $directory ='views'. DIRECTORY_SEPARATOR .'user'. DIRECTORY_SEPARATOR .$place;
        }
        if ($directory=='admin_view') {
            $directory ='views'. DIRECTORY_SEPARATOR .'admin'. DIRECTORY_SEPARATOR .$place;
        }
        if ($directory=='employ_view') {
            $directory ='views'. DIRECTORY_SEPARATOR .'employ'. DIRECTORY_SEPARATOR .$place;
        }
        
        if ($parameter == 'require') {
            require(self::$rootDir.$directory . DIRECTORY_SEPARATOR .$className.'.php');
            return;
        }

        if (file_exists(self::$rootDir.$directory. DIRECTORY_SEPARATOR .$className.'.php')) {
            if (! class_exists($className)) {
                require(self::$rootDir.$directory. DIRECTORY_SEPARATOR .$className.'.php');
                
                if ($parameter =='') {
                    self::$class[$className]=new $className();
                } else {
                    self::$class[$className]=new $className($parameter);
                }
            }//if
        }//if
    }//func
}//class
    define("GSMS", "v2.0 beta");
