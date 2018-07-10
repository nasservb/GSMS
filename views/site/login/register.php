<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class register
{
	
    public function register($arr=array() )
    {
		//var_dump($arr);
        $inf = array('page_title' => 'ورود به سایت');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'site_header');
       
		if (!class_exists('Fox_captcha'))
			GSMS::load('Fox_captcha','libs','','require');
		
		$img = new Fox_captcha(120, 30, 5);
		
		$img->lines_amount = 2;
		$img->image_dir = GSMS::$siteURL . 'views/site/Fox_captcha/images/';// it is in the same page so I need not to add any value
		$img->en_reload = "بارگذاری مجدد";
		$message = $arr['message'] ; 
		if(isset($arr['success']) ) 
			$message = '<div class="alert alert-success">'.$message.'</div>'; 
		
		if (isset($arr['err']))
			$message = '<div class="alert alert-danger">'.$message.'</div>'; 
		
		$body =  ' <br/>
				' .$message .'
		 
		
			<div class="col-md-6">
				<h2  class="alert alert-info">ورود</h2>
				<h4>قبلآ عضو <font color="#20b2aa">سیستم </font>هستم.<br></h4><br>
				
				<form id="form_login" action="'. GSMS::$siteURL.GSMS::$index .'/login/index/"  method="post">
					<div class="well">
					نام کاربری اگر ایمیل است با حروف کوچک و اعداد با حروف انگلیسی وارد شود.
					</div>
					<div class="row">
					
						<div class="col-md-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">نام کاربری </label>
								<input type="text" name="Uname" size="30" class="form-control">
								<span class="material-input"></span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group  label-floating is-empty">
								<label class="control-label">رمز عبور</label>
								<input type="password" name="Pass" size="20" class="form-control">
								<span class="material-input"></span>
							</div>
						</div>'.
						(isset($arr['err'])  ? '
						
						<div class="col-md-6">
							'. $img->make_it() .'
						</div>
						
						<div class="col-md-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">عبارت امنیتی </label>
								<input type="text" id="captcha" name="captcha" class="form-control">
								<span class="material-input"></span>
							</div>
						</div>
						
						<input type="hidden" name="captcha_enabled" value="1">
						': 
						'<input type="hidden" name="captcha_enabled" value="0">	' 
						) .'
						<div class="col-md-12">
							<div class="form-group   is-empty">
								<input type="submit" name="submit" class="btn btn-primary"   value=" ورود">
								<a class="btn" style="font-size: 11pt" href="'. GSMS::$siteURL.GSMS::$index .'/login/resetPass">بازیابی رمز عبور</a>
								<span class="material-input"></span>
							</div>
						</div>			  
					</div>	
				</form>			 
			</div> 									
				
			<div class="col-md-6" style="border-left: 1px dashed #8BDADA;">
				<h2 class="alert alert-success">ثبت نام </h2>
				<h4 >به جمع کاربران <font color="#20b2aa">ما </font>بپیوندید.<br></h4><br>
				<form id="form_register" action="' .GSMS::$siteURL.GSMS::$index.'/login/register/" method="post" method="post">
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">نام</label>
								<input type="text" name="name" size="30" class="form-control">
							<span class="material-input"></span></div>
						</div>
						<div class="col-md-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">نام خانوادگی</label>
								<input type="text" name="family" size="30" class="form-control">
							<span class="material-input"></span></div>
						</div>
						<div class="col-md-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">شماره موبایل</label>
								<input type="text" name="mobile" size="20" class="form-control">
							<span class="material-input"></span></div>
						</div>
						<div class="col-md-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">ایمیل</label>
								<input type="text" name="email" size="30" class="form-control">
							<span class="material-input"></span></div>
						</div> 
						'.
						(isset($arr['err'])  ? '
						
						<div class="col-md-6">
							'. $img->make_it() .'
						</div>
						<div class="col-md-12">
							<div class="form-group label-floating is-empty">
								<label class="control-label">عبارت امنیتی </label>
								<input type="text" id="captcha" name="captcha" class="form-control">
								<span class="material-input"></span>
							</div>
						</div>
							<input type="hidden" name="captcha_enabled" value="1">	': 
							'<input type="hidden" name="captcha_enabled" value="0">	' 
						) .'
							
						<div class="col-md-12">
							<div class="form-group   is-empty">
								<input type="submit" name="submit2" class="btn btn-success"   value=" ثبت نام">
								 <input onchange="if(this.checked)submit2.disabled=false;else submit2.disabled=true" type="checkbox" name="agree" checked="">
									<a href="'.GSMS::$siteURL.GSMS::$index  .'/index/rule"> قوانین </a> را می پذیرم
								<span class="material-input"></span>
							</div>
						</div>
					</div>
				</form>
			</div>';
			
			$inf=array('title'=>'ورود به سایت','body'=>$body,'dir'=>'rtl');
			GSMS::$class['template']->load($inf,'site_index');
			$inf=array('footer_text'=>'');
			GSMS::$class['template']->load($inf,'site_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}