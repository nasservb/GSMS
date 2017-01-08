<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class help
{
	
    public function help(  )
    {
		$inf = array('page_title' => 'راهنمای استفاده از سایت');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'site_header');
		
		$body='
		<div class="message-info"> 
		 
		
	<br/>
	
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		</div>
		';
        
		$inf = array('title' => 'راهنمای استفاده از قاصدک', 'body' => $body, 'dir' => 'rtl');
        GSMS::$class['template']->index($inf);
		$inf = array('title' => 'راهنمای استفاده از قاصدک', 'body' => '', 'dir' => 'ltr');
        GSMS::$class['template']->load($inf,'site_footer');
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}