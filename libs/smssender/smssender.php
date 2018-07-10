<?php //allahoma sale ala mohammad va ale mohammad 
//smssender can send any sms in any class [1000,2000,3000,..] . on model layer start 10-2-91 by nasser niazy in gooya smslearning system

class smssender{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		//--------soap server class for create soap client and server
		if(!isset(GSMS::$class['nusoap']))
			GSMS::load('soapclient','libs','',GSMS::$config['sms_wsdl_url']);
		//		magfa server authentication
		if(GSMS::$config['sms_class']=='magfa')	
		{
			GSMS::$class['soapclient']->setCredentials(GSMS::$config['sms_username'],GSMS::$config['sms_password'], 'basic');
		}
		elseif(GSMS::$config['sms_class']=='tose')
		{
			$client->decodeUTF8(false);
		}
		//end on constructor
		GSMS::$class['system_log']->log('DEBUG','smssender class is Initialized');
	}
	public function getRemaining_charge()
	{
		//call soap server
	}//func
	public function sendSms($message,$to)
	{
		if(GSMS::$config['sms_class']=='magfa')
		{
			$result = GSMS::$class['soapclient']->call(
			/* Method        */		"enqueue",
			/* Parameters    */		array(
			/* Domain        */			GSMS::$config['sms_domain'],
			/* Message array */			array($message),
			/* Destination   */			array($to), // In this example MOBILENUMBER should be same
			/* Originator    */			array(GSMS::$config['sms_number']),
			/* Encoding      */			array(-1,-1), // The system will guess it, itself ;)
			/* UDH arrray    */			array("",""),
			/* MClass        */			array(1,1) // Type of SMS that mobile receives.
			/* End of Params */		)
			/* End of Call   */ );
		}
		elseif(GSMS::$config['sms_class']=='tose')
		{
			$result = $client->call('send', array(
								'username'	=> GSMS::$config['sms_username'], 
								'password'	=> GSMS::$config['sms_password'], 
								'to'		=> $to, 
								'from'		=> GSMS::$config['sms_number'], 
								'message'	=> $message
								));
		}//func
		return 1;	//send succesfull
		
	}//func

// END smssender Class

/* End of file smssender.php */
 if ( !defined( "GSMS" ) ) exit( "Access denied" );
?>