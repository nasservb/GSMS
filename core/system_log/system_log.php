<?php //allahoma sale ala mohammad va ale mohammad 

	require_once('constants.php');
	 if ( ! function_exists('is_really_writable'))
	{
		function is_really_writable($file)
		{
			// If we're on a Unix server with safe_mode off we call is_writable
			if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE)
			{
				return is_writable($file);
			}

			// For windows servers and safe_mode "on" installations we'll actually
			// write a file then read it.  Bah...
			if (is_dir($file))
			{
				$file = rtrim($file, '/').'/'.md5(mt_rand(1,100).mt_rand(1,100)).'.txt';
				if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
				{
					return FALSE;
				}

				fclose($fp);
				@chmod($file, DIR_WRITE_MODE);
				@unlink($file);
				return TRUE;
			}
			elseif ( ! is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
			{
				return FALSE;
			}

			fclose($fp);
			return TRUE;
		}
	}
class system_log
{
	protected $log_path	;
	protected $level	= 3;// loging  level
	protected $enabled	= True;
	protected $date_fmt='y-m-d H_i_s';
	protected $levels	= array('ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4');
	

	/**
	 * Constructor
	 */	
	 public function __construct()
	{

			

		$this->log_path = (GSMS::$config['log_path'] != '') ? GSMS::$config['log_path'] : '';
		$this->log_path =GSMS::$rootDir . $this->log_path;

//$filename3=$this->log_path.'database_backup_'.date('Y-d-m').'.sql';

//$result=exec('mysqldump mamadari_db --password=mamadari_user@123 --user=mamadari_user --single-transaction //>'.$filename3,$result);
			
		if ( ! is_dir($this->log_path)  OR (!GSMS::$config['log_enabled']) OR ! is_really_writable($this->log_path))
		{
			$this->enabled = FALSE;
		}//if
		if (is_numeric(GSMS::$config['log_level']))
		{
			$this->level = GSMS::$config['log_level'];
		}//if

		if (GSMS::$config['log_date_format'] != '')
		{
			$this->date_fmt = GSMS::$config['log_date_format'];
		}//if
		$this->log('DEBUG','=======================================new runing');
		$this->log('DEBUG','system_log classs Initialized');
	}//fun
// --------------------------------------------------------------------

	/**
	 * Write Log File
	 *
	 * Generally this function will be called using the global log_message() function
	 *
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 */
	public function log($level = 'error', $msg, $php_error = FALSE)
	{
	if ($this->enabled === FALSE)
		{
			return FALSE;
		}

		$level = strtoupper($level);

		if($level == "INFO" )
		{
		//loging
		} 
		else//if ( ! isset($this->levels[$level]) OR ($this->levels[$level] > $this->level))// error level is lower than log level
		{
			return FALSE;
		}
		

		$filepath = $this->log_path.'log-'.date('Y-d-m').'.php';
		$message  = '';
		if ( ! file_exists($filepath))
		{
			
			$message .= "<"."?php  if ( !defined( 'GSMS' ) )exit( 'Access denied' ); ?".">\n بسم الله الرحمن الرحیم  \n";
			
			
		}

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}

		$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->date_fmt). ' --> '.$msg."\n";

		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
	}
	public function getLogs($startLine=0,$finishLine=0)
	{
		$filepath = $this->log_path.'log-'.date('Y-d-m').'.php';
		$message  = array();
		$i=0;
		if($finishLine==0)$finishLine=GSMS::$config['page_item_per_page'];
		if (  file_exists($filepath))
		{
			$message[$i]= " بسم الله الرحمن الرحیم  ";
			if ( ! $fp = @fopen($filepath, FOPEN_READ))
			{
				return FALSE;
			}
			else
			{
				$offset=0;
				$end=$startLine;
				$temp='';
				$temp=fgets($fp);
				$temp=fgets($fp);
				if ($startLine!=0)//---------seeking-----------
					while(!feof($fp) && ($offset<=$startLine))
					{	
						$temp=fgets($fp);
						$offset++;
					}	
				//----------------------
				while(!feof($fp) && $end<=$finishLine)
				{
					$message[++$i]=fgets($fp);
					$end++;
				}//while
				return $message;
			}//else
		}
		else
		{
			return 404;
		}//else
	}//func

}
// END Log Class

/* End of file Log.php */
if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
?>
