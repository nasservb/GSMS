<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class home
{
	
    public function home(  )
    {
		$body='<div  style="padding: 19px;  line-height: 25px;">
		<div class="message-info">
		
		با سلام و احترام <br/>'.GSMS::$class['template']->info['name'].'
		<br/>
		جهت ثبت نام در سیستم یا ورود به پنل  کاربری از لینک زیر استفاده نمائید : <br/><br/>
		 <a class="btn btn-success btn-register" href="'.GSMS::$class['template']->info['index'].'login/register">ورود به پنل کاربری یا ثبت نام در سیستم</a>
		
		</div>
		</div> 
		
		';
		
		 
        GSMS::$class['template']->message(
							GSMS::$class['template']->info['name'] ,$body,'site',"",false,false); 
		
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}