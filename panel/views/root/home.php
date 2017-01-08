<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class home
{
	
    public function home(  )
    {
		$inf = array('page_title' => ' سیستم مدیریت    ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'سیستم مدیریت   ');
        GSMS::$class['template']->load($inf,'site_header');
        $user = GSMS::$class['session']->getUser();
		
		$body='<div  style="padding: 19px;  line-height: 25px;">
		<div class="message-info">
		
		با سلام و احترام <br/>
		به سیستم مدیریت  خوش آمدید . 
		<br/>
		جهت ثبت نام در سیستم یا ورود به پنل  کاربری از لینک زیر استفاده نمائید : <br/><br/>
		 <a class="btn btn-success btn-register" href="'.GSMS::$class['template']->info['index'].'login/register">ورود به پنل کاربری یا ثبت نام در سیستم</a>
		
		</div>
		</div>
		
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		';
		
		
		$inf = array('title' => 'سیستم مدیریت   ', 'body' => $body);
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}