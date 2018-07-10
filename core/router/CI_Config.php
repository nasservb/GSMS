<?php //allahoma sale ala mohammad va ale mohammad

/**
* Loads the main config.php file
*
* This function lets us grab the config file even if the Config class
* hasn't been instantiated yet
*
* @access	private
* @return	array
*/
//-----neccesury config item from 

// ------------------------------------------------------------------------

class CI_Config {


	/**
	 * List of all loaded config files
	 *
	 * @var array
	 
	var $is_loaded = array();
	
	 * List of paths to search when trying to load a config file
	 *
	 * @var array
	
	var $_config_paths = array(APPPATH);

	
	 * Constructor
	 *
	 * Sets the $config data from the primary config.php file as a class variable
	 *
	 * @access   public
	 * @param   string	the config file name
	 * @param   boolean  if configuration values should be loaded into their own section
	 * @param   boolean  true if errors should just return false, false if an error message should be displayed
	 * @return  boolean  if the file was successfully loaded or not
	 */
	public function __construct()
	{
		//GSMS::$config =& get_config();
		GSMS::$class['system_log']->log('debug', "Config Class Initialized");

		// Set the base_url automatically if none was provided
		if (GSMS::$config['base_url'] == '')
		{
			if (isset($_SERVER['HTTP_HOST']))
			{
				$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
				$base_url .= '://'. $_SERVER['HTTP_HOST'];
				$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
			}

			else
			{
				$base_url = 'http://localhost/';
			}
			GSMS::$siteURL=$base_url;
			$this->set_item('base_url', $base_url);
			
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a config file item
	 *
	 *
	 * @access	public
	 * @param	string	the config item name
	 * @param	string	the index name
	 * @param	bool
	 * @return	string
	 */
	public function item($item, $index = '')
	{
		if ($index == '')
		{
			if ( ! isset(GSMS::$config[$item]))
			{
				return FALSE;
			}

			$pref = GSMS::$config[$item];
		}
		else
		{
			if ( ! isset(GSMS::$config[$index]))
			{
				return FALSE;
			}

			if ( ! isset(GSMS::$config[$index][$item]))
			{
				return FALSE;
			}

			$pref = GSMS::$config[$index][$item];
		}

		return $pref;
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a config file item - adds slash after item (if item is not empty)
	 *
	 * @access	public
	 * @param	string	the config item name
	 * @param	bool
	 * @return	string
	 */
	public function slash_item($item)
	{
		if ( ! isset(GSMS::$config[$item]))
		{
			return FALSE;
		}
		if( trim(GSMS::$config[$item]) == '')
		{
			return '';
		}

		return rtrim(GSMS::$config[$item], '/').'/';
	}

	// --------------------------------------------------------------------

	/**
	 * Site URL
	 * Returns base_url . index_page [. uri_string]
	 *
	 * @access	public
	 * @param	string	the URI string
	 * @return	string
	 */
	public function site_url($uri = '')
	{
		if ($uri == '')
		{
			return $this->slash_item('base_url').$this->item('index_page');
		}

		if ($this->item('enable_query_strings') == FALSE)
		{
			$suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');
			return $this->slash_item('base_url').$this->slash_item('index_page').$this->_uri_string($uri).$suffix;
		}
		else
		{
			return $this->slash_item('base_url').$this->item('index_page').'?'.$this->_uri_string($uri);
		}
	}

	// -------------------------------------------------------------

	/**
	 * Base URL
	 * Returns base_url [. uri_string]
	 *
	 * @access public
	 * @param string $uri
	 * @return string
	 */
	public function base_url($uri = '')
	{
		return $this->slash_item('base_url').ltrim($this->_uri_string($uri),'/');
	}

	// -------------------------------------------------------------

	/**
	 * Build URI string for use in Config::site_url() and Config::base_url()
	 *
	 * @access protected
	 * @param  $uri
	 * @return string
	 */
	protected function _uri_string($uri)
	{
		if ($this->item('enable_query_strings') == FALSE)
		{
			if (is_array($uri))
			{
				$uri = implode('/', $uri);
			}
			$uri = trim($uri, '/');
		}
		else
		{
			if (is_array($uri))
			{
				$i = 0;
				$str = '';
				foreach ($uri as $key => $val)
				{
					$prefix = ($i == 0) ? '' : '&';
					$str .= $prefix.$key.'='.$val;
					$i++;
				}
				$uri = $str;
			}
		}
	    return $uri;
	}

	// --------------------------------------------------------------------

	/**
	 * System URL
	 *
	 * @access	public
	 * @return	string
	 */
	public function system_url()
	{
		$x = explode("/", preg_replace("|/*(.+?)/*$|", "\\1", GSMS::$rootDir));
		return $this->slash_item('base_url').end($x).'/';
	}

	// --------------------------------------------------------------------

	/**
	 * Set a config file item
	 *
	 * @access	public
	 * @param	string	the config item key
	 * @param	string	the config item value
	 * @return	void
	 */
	public function set_item($item, $value)
	{
		GSMS::$config[$item] = $value;
	}

	// --------------------------------------------------------------------

	/**
	 * Assign to Config
	 *
	 * This function is called by the front controller (CodeIgniter.php)
	 * after the Config class is instantiated.  It permits config items
	 * to be assigned or overriden by variables contained in the index.php file
	 *
	 * @access	private
	 * @param	array
	 * @return	void
	 */
	public function _assign_to_config($items = array())
	{
		if (is_array($items))
		{
			foreach ($items as $key => $val)
			{
				$this->set_item($key, $val);
			}
		}
	}
}

// END CI_Config class

/* End of file Config.php */
 if ( !defined( "GSMS" ) ) exit( "Access denied" );
?>