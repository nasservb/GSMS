<?php //allahoma sale ala mohammad va ale mohammad 
//class for control session on model layer start 3-2-91 by nasser niazy in gooya smslearning system
class session 
{
	var $session_encrypt=false;
	var $session_use_database=false;
	var $session_table_name='';
	var $session_expiration=7200;//second
	var $session_expier_on_close=false;
	var $sess_match_ip				= FALSE;
	var $sess_match_useragent		= TRUE;
	var $sess_cookie_name			= 'ci_session';
	var $cookie_prefix				= '';
	var $cookie_path				= '';
	var $cookie_domain				= '';
	var $cookie_secure				= FALSE;
	var $sess_time_to_update		= 300;
	var $session_save_path			="tmp";
	var $encryption_key				= '';
	var $flashdata_key				= 'flash';
	var $time_reference				= 'time';
	
	var $bug_compat_warn	='off';// session bug message is not displayed by call session.bug_compat_warn='off'
	public function __construct()
	{
		ini_set('session.save_path',GSMS::$rootDir.$this->session_save_path);
		//ini_set('register_globals',1);//set to on (generate err in off mode)
		
		if (!isset($_SESSION['session']))//session not started
		{
			session_start();
			$_SESSION['session']="sarted!";
		}
		GSMS::$class['system_log']->log('DEBUG','Session class Initialized');
		//session function list in php extention on php 5.2.3
		/*
		session_cache_expire
		session_cache_limiter
		session_commit
		session_decode
		session_destroy
		session_encode
		session_get_cookie_params
		session_id
		session_is_registered
		session_module_name
		session_name
		session_regenerate_id
		session_register
		session_save_path
		session_set_cookie_params
		session_set_save_handler
		session_start
		session_unregister
		session_unset
		session_write_close
		*/
	}
	public function checkAdmin()
	{
		if(isset($_SESSION['login_UserType']) && ($this->get('login_UserType')==1||$this->get('login_UserType')==3))
		{
			return true;
		}
		return false;
	}
	public function checkLogin()
	{
		$login =false;
		if ( 	($this->is_register('login_login')) && 
				($this->get("login_login")==true) &&
				($this->is_register("login_UserID")) &&
				($this->is_register("login_UserName")) ) $login=true;
		return $login;										 
	}//func
	public function login($username,$pass)
	{
		if( $this->is_register('login_count')==false)
		{
			$this->register('login_count');
			$this->set('login_count',0);
		}//if
		$validcount= $this->get('login_count'); 
		$validcount++;
		if ($validcount>5) return 309;//	try count is out of max
		if ($username=='' || $pass=='' )return 500; //insert user and pass
		$row='';$max=0;
		$res=GSMS::$class['DB']->run("select * from `admin` where (`username`='".$username."')
											and(`password`='".$this->encode($pass)."')",
											'session.php',
											$row,
											$max,
											'check pass');
		if($max==0)
		{
			$this->set('login_count',$validcount);
			return 303;//dont match by any user pass
		}
		elseif($max>1)
		{
			GSMS::$class['DB']->logsql("select * from `admin` where (`username`='".$username."')
													and(`password`='".$pass."')",
													"session.php",
													$this->getUserid($username),
													$username,
													"report injection",
													"",//error_code
													"");//error_message
			$this->set('login_count',$validcount);
			return 304;	//try to injection
		}
		elseif($max==1)
		{
			$this->set("login_login",true);
			$this->set("login_UserID",$row['admin_id']);
			$this->set("login_UserType",$row['admin_type']);
			$this->set("login_UserName",$row['username']);
			return 45;//successfull
		}//if
		return 303;//dont match by any user pass
	}//func
	public function logout()
	{
		$this->unregister('login_login');
		$this->unregister('login_UserID');
		$this->unregister('login_UserName');
		$this->unregister('login_count');
	}//fun
	public function register($key)
	{
		if(isset($_SESSION[$key])==false)
			$_SESSION[$key]='';
	}//fun
	public function is_register($key)
	{
		if(isset($_SESSION[$key])==false)
			return false;
		else
			return true;
	}//func
	public function set($key,$value)
	{
		$this->register($key);
		$_SESSION[$key]=$value;
	}//func
	public function get($key)
	{
		$this->register($key);
		return $_SESSION[$key];
	}//func
	public function unregister($key)
	{
		$_SESSION[$key]=null;
	}//fun
	public function encode($name)
	{
		return crypt($name,GSMS::$config['password_crypt_key']);
	}	
	public function decode($name)
	{
		return $this->decrypt($name,GSMS::$config['password_crypt_key']);
	}
	public function getUser()
	{
		if ($this->checkLogin()==true)
		return array(	'UserName'=>GSMS::$class['session']->get('login_UserName'),
						'UserID'=>GSMS::$class['session']->get('login_UserID'),
						'UserType'=>GSMS::$class['session']->get('login_UserType'));
	}//func
	private function getUserid($username)
	{
		$row='';$max=0;
		GSMS::$class['DB']->run("select * from `admin` where (`username`='".$username."')",'session.php',$username,$row,$max,'check pass');
		if($max==0)
		{
			return -1;
		}elseif($max>1)
		{
			GSMS::$class['DB']->logsql("select * from `admin` where (`username`='".$username."')"
												,"session.php",$username,"select useres injection","","");
			return 0;	
		}elseif($max==1)
		{
			return $row['id'];
		}
	}//fun
	
	/**
	 * Returns an encrypted & utf8-encoded
	 */
	function encrypt($pure_string, $encryption_key) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
		return $encrypted_string;
	}

	/**
	 * Returns decrypted original string
	 */
	function decrypt($encrypted_string, $encryption_key) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
		return $decrypted_string;
	}
}//class
 if ( !defined( "GSMS" ) ) exit( "Access denied" );
 