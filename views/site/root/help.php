<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class help
{
	
    public function help(  )
    {
		 
		$body='
		<div class="message-info"> 
		در حال ساخت
	<br/>
	
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		</div>
		';
         
        GSMS::$class['template']->message('راهنمای استفاده از سایت'  ,$body,'site',"",false,false); 
		
		  
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}