<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class rule
{
	
    public function rule(  )
    {
		 
		$body='<div  style="padding: 19px;  line-height: 25px;">
		<div class="message-info">
		
		در دست تهیه
		</div>
		</div> 
		
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		';
		GSMS::$class['template']->message('قوانین استفاده از سایت'  ,$body,'site',"",false,false); 
		 
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}