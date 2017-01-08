<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class rule
{
	
    public function rule(  )
    {
		$inf = array('page_title' => ' قوانین استفاده از سایت     ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => ' قوانین استفاده از سایت    ');
        GSMS::$class['template']->load($inf,'site_header');
        $user = GSMS::$class['session']->getUser();
		
		$body='<div  style="padding: 19px;  line-height: 25px;">
		<div class="message-info">
		
		در دست تهیه
		</div>
		</div> 
		
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		';
		
		
		$inf = array('title' => '  قوانین استفاده از سایت    ', 'body' => $body);
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}