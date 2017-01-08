<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class resetPass
{
    public function resetPass($arr=array() )
    {
        $inf = array('page_title' => 'بازیابی رمز عبور');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'بازیابی رمز عبور');
        GSMS::$class['template']->load($inf,'site_header');
       
		GSMS::load('Fox_captcha','lib');
		
		$img = new Fox_captcha(120, 30, 5);
		
		$img->lines_amount = 2;
		$img->image_dir = GSMS::$siteURL.'/panel/views/Fox_captcha/images/';// it is in the same page so I need not to add any value
		$img->en_reload = "بارگذاری مجدد";
		
			
		$message = $arr['message'] ; 
		if(isset($arr['success']) ) 
			$message = '<div class="alert alert-success">'.$message.'</div>'; 
		
		if (isset($arr['err']))
			$message = '<div class="alert alert-danger">'.$message.'</div>'; 
		
		
		$body = $message .'
		<div class="message-info" style="    text-shadow: 0px 0px 1px #96ECFF;color: #0F6D73;    font-size: 13pt;line-height: 30px;">
		
				<h4 class="item-title" style="background-image: none;color: rgb(86, 96, 96);">
			با ورود نام کاربری خود و زدن دکمه بازیابی رمز عبور ، رمز عبور جدیدی برای شما ارسال خواهد شد که می توانید با آن وارد پنل کاربری خود شوید . 
				 
				</h4>
				<h4>	 نام کاربری خود را وارد کنید
					</h4><br>
					<form id="form_login" action="'. GSMS::$siteURL.GSMS::$index .'/login/resetPass"  method="post">
						<table dir="rtl">
							<tbody><tr>
								<td>نام کاربری :</td><td>
								<input   dir="ltr" id="Uname" type="text" name="Uname" size="30" data-original-title="" title=""> </td>
							</tr>
							<tr>
								<td></td>
								<td>'. $img->make_it() .'</td>
							</tr>
							<tr>
								<td>عبارت امنیتی</td>
								<td><input type="text" id="captcha" name="captcha" value="" /></td>
							</tr>
							<input type="hidden" name="captcha_enabled" value="1">	
							<tr>
								<td>
									<input type="submit" name="submit" class="btn btn-primary" style="font-size: 10pt;width: 100px;height: 30px" value=" بازیابی رمز عبور"> 
									<a  class="btn "   href="'.GSMS::$siteURL.GSMS::$index .'/login">ورود به سیستم</a> 
								</td>
							</tr>
						</tbody>
						</table>
					</form>
				
	 </div> 
	  ';
			$inf=array('title'=>'بازیابی رمز عبور','body'=>$body,'dir'=>'rtl');
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->load($inf,'site_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
