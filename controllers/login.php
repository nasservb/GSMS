<?php //allahoma sale ala mohammad va ale mohammad 
class login
{
	public function __construct()
	{
		//constructor
		if (! isset(GSMS::$class['template']))
			GSMS::load('template','core');
		
		if (!class_exists('Fox_captcha'))
			GSMS::load('Fox_captcha','libs','','require');
	}//fun 
	
	public function resetPass()
	{
		if(isset($_POST['submit']))
		{
			GSMS::load('admin','class');
			
			$img = new Fox_captcha(1,1,1);
			
		
			if((GSMS::$class['input']->post('captcha_enabled')) == 1 && !($img->test(GSMS::$class['input']->post('captcha'))))
			{
				$message='
				خطا در ورود اطلاعات :<br>
				عبارت امنیتی به درستی وارد نشده است . 
				';
				GSMS::load('resetPass','site_view','login',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
				return;
			}
			if(	GSMS::$class['input']->post('Uname') =='')
			{
				GSMS::load('resetPass','site_view','login',array('message'=>'اطلاعات ورودی ناقص است .','err'=>1));
				return;
			}
			$tempAdmin = GSMS::$class['admin']->getAdminByUsername(GSMS::$class['input']->post('Uname'));
			if(!is_object( $tempAdmin))
			{
				$message='
				خطا در ورود اطلاعات :	<br>			
				نام کاربری موجود نیست .<br>	
				 می توانید دوباره ثبت نام کنید . در صورت بروز هرگونه مشکل از لینک تماس با ما در پایین صفحه به ما انتقال دهید .
				';
				
				GSMS::load('resetPass','site_view','login',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
				return;
			}
			$newpass = rand(30000,89000);  
			$tempAdmin->password   = $newpass;
			$tempAdmin->save();
			
			
			
			$to = $tempAdmin->mail;
			$subject = 'پیام از بازیابی رمز عبور در تلگرام گرد';
			ini_set('sendmail_from', 'info@mamadar.ir');
			$headers = "From: info@mamadar.ir\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "Reply-To: $to";
			
			
			$message2 = '<table><thead><th>عنوان</th> <th>اطلاعات</th></thead>';
			$message2 .= '<tr><td>نام کاربری  :</td>' . $tempAdmin->username. '<td></td>';
			$message2 .= '<tr><td>رمز عبور جدید :</td>' . $newpass . '<td></td>';
			

			$body = "نام کاربری: \n". $tempAdmin->username.
					"\n رمز عبور جدید: \n". $newpass.			
			'<div style=" background-color: #EBF8F9;background-color: #EBF8F9;
				font-size: 11pt;
				border: 1px solid #0796AE;
				padding: 10px;
				border-radius: 5px;
				font-weight: normal;
				width: 90%;
				box-shadow: 1px 1px 3px 1px #99E9DE;
				direction: rtl;
				text-align: right;">
				<h3>شما یک پیام جدید در سایت تلگرام گرد دارید</h3><br/>
				<h4>کاربر گرامی ، سلام </h4><br/>
			فردی در وب سایت تلگرام گرد درخواست بازیابی رمز عبور اکانت شما را داشته است. 
			<br/>
			با اطلاعات زیر می توانید وارد پنل کاربری خود شوید :

			<br/>
			' . $message2 . '
			<br/>
			http://mamadar.ir/</a>
			</div>';
			
			mail($to, $subject, $body, $headers);
			mail($to, $subject, $body, $headers);
			$message='
			رمز عبور شما با موفقیت بازیابی شد . لطفآ به آدرس ایمیل خود مراجعه کنید و 
اگر ایمیل حاوی رمز عبور جدید را پیدا نکردید پوشه spam یا هرزنامه را هم بگردید			.<br/>
			
			';
			
			GSMS::load('resetPass','site_view','login',array('message'=>$message , 'success'=>1,'wizard'=>$wizard));
		}
		else 
		{
			
			
			GSMS::load('resetPass','site_view','login',array());
		}
	}
	
	public function register($wizard =0)
	{
		$message = '';
		
		if(!isset($_POST['submit2']))
		{
			
			GSMS::load('register','site_view','login',array('wizard'=>$wizard));
		}
		else 
		{
			GSMS::load('admin','class');
			 
			$img = new Fox_captcha(1,1,1);
			
		
			if((GSMS::$class['input']->post('captcha_enabled')) == 1 && !($img->test(GSMS::$class['input']->post('captcha'))))
			{
				$message='
				خطا در ورود اطلاعات :<br>
				عبارت امنیتی به درستی وارد نشده است . 
				';
				GSMS::load('register','site_view','login',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
				return;
			}
			
			if(		
					GSMS::$class['input']->post('mobile')=='' ||
					GSMS::$class['input']->post('email')=='' 
					)
			{
				GSMS::load('register','site_view','login',array('message'=>'اطلاعات ورودی ناقص است .','err'=>1));
				return;
			}
			
			
			$tempAdmin3 = GSMS::$class['admin']->getAdminByUsername(GSMS::$class['input']->post('email'));
			var_dump($tempAdmin3);
			if(!is_object( $tempAdmin3)|| intval($tempAdmin3->id) > 0 )
			{
				$message='
				خطا در ورود اطلاعات :	<br>			
				نام کاربری قبلآ موجود است .
				';
				
				GSMS::load('register','site_view','login',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
				return;
			}
			
			
			$tempAdmin=new admin();
			$tempAdmin->name=GSMS::$class['input']->post('name');
			$tempAdmin->family=GSMS::$class['input']->post('family');

			$tempAdmin->describe=GSMS::$class['input']->post('desc');

			$tempAdmin->mobile=GSMS::$class['input']->post('mobile');
			$tempAdmin->mail=GSMS::$class['input']->post('email');
			$tempAdmin->username=GSMS::$class['input']->post('email');
			
			$tempAdmin->admin_type=2;
			$newpass = rand(30000,89000);  
			$tempAdmin->password   = $newpass;
			$tempAdmin->save();
			
			
			
			$to = $tempAdmin->mail;
			$subject = '    ثبت نام در سیستم مدیریت چاپخانه ';
			ini_set('sendmail_from', 'info@offtel.ir');
			$headers = "From: info@offtel.ir\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "Reply-To: $to";
			
			 
			$message2 = '<table><thead><th>عنوان</th> <th>اطلاعات</th></thead>';
			$message2 .= '<tr><td>نام کاربری  :</td>' . $tempAdmin->username. '<td></td>';
			$message2 .= '<tr><td>رمز عبور  :</td>' . $newpass . '<td></td>';
			

			  
			$body = "نام کاربری: \n". $tempAdmin->username.
					"\n رمز عبور جدید: \n". $newpass.	
			'<div style=" background-color: #EBF8F9;background-color: #EBF8F9;
				font-size: 11pt;
				border: 1px solid #0796AE;
				padding: 10px;
				border-radius: 5px;
				font-weight: normal;
				width: 90%;
				box-shadow: 1px 1px 3px 1px #99E9DE;
				direction: rtl;
				text-align: right;">
				<h3>شما یک پیام جدید در سایت چاپخانه همدان پیام  دارید</h3><br/>
				<h4>کاربر گرامی ، سلام </h4><br/>
			تشکر از ثبت نام شما . 
			<br/>
			با اطلاعات زیر می توانید وارد پنل کاربری خود شوید :

			<br/>
			' . $message2 . '
			<br/>
			http://offtel.ir/index.php/login</a>
			</div>';
			 
			mail($to, $subject, $body, $headers); 
			
			
			$message='<div dir="rtl" class="alert alert-info" role="alert">
			تبریک ! حساب کاربری شما ایجاد شد <br/>
			<h3>نام کاربری شما : <b>'.GSMS::$class['input']->post('email').'</b></h3>
			<h3> رمز عبور شما : <b>'.$newpass.'</b></h3>
			
			</div>
			رمز عبور به آدرس ایمیل شما ارسال شد . 
			<br/>
			 می توانید وارد حساب کاربری خود شده و اولین سفارش خود را ثبت کنید .
			';
			
			GSMS::load('register','site_view','login',array('message'=>$message , 'success'=>1,'wizard'=>$wizard));
		}
	}
	
	public function index($wizard =0 )
	{
		$message = ''; 
		if (GSMS::$class['session']->checkLogin()==true)
		{
			$user=GSMS::$class['session']->getUser();
			if($user['UserType'] == 1)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/admin/index");
				return;
			}
			elseif($user['UserType'] == 2)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/user/index");
				return;
			}
			elseif($user['UserType'] == 3)
			{
				GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/employ/index");
				return;
			}
		}
		
		
		$UserName = GSMS::$class['input']->post('Uname');
		$Pass= GSMS::$class['input']->post('Pass');
		
		if( isset($_POST['submit'])) 
		{ 
			$img = new Fox_captcha(120, 30, 5);
			$message='';
			if($_POST['captcha_enabled']==1 && !$img->test(GSMS::$class['input']->post('captcha')))
			{
				$message= 'عبارت امنیتی به درستی وارد نشده است <br/>در صورت نامفهوم بودن عبارت امنیتی از گزینه بارگذاری مجدد استفاده کنید .' ; 
				GSMS::load('register','site_view','users',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
				return;
			}
			
			$log=GSMS::$class['session']->login($UserName,$Pass);
			if ($log==45)
			{
				$user=GSMS::$class['session']->getUser();
				
				if($user['UserType'] == 1)
				{
					GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/admin/index");
					return;
				}
				elseif($user['UserType'] == 3)
				{
					GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/employ/index");
					return;
				}
				elseif($user['UserType'] == 2)
				{
					if($wizard == 1) 
						GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/user/accounting/startRace");
					else
						GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index."/user/index");
					return;
				}
				
			}
			
			
			switch ($log){
				case 500: 
						$message='نام کاربری یا رمز عبور مقدار دهی نشده است.';
						
						break;
				case 309: 
						$message='به دلایل امنیتی متاسفانه مجوز های ورود شما موقتآ لغو شده . <br/>
						پس از وقفه ای 15 دقیقه ای می توانید دوباره برای ورود تلاش کنید . در صورت بروز هرگونه مشکل از گزینه تماس با ما در پایین صفحه با ما مکاتبه کنید 
						';
						break;
				case 303: 
						$message= 'نام کاربری یا رمز عبور صحیح نیست<br/>['.GSMS::$class['session']->get('login_count') .'/5]شما از یکی از مجوزهای خود استفاده کردید';
						break;
				case 304:
						$message='سایت در حال بروزرسانی است لطفآ در زمان دیگری تلاش نمایید';
						break;
			}//switch  
			GSMS::load('register','site_view','login',array('message'=>$message,'err'=>1,'wizard'=>$wizard));
			return;
		}
		else
		{
			GSMS::load('register','site_view','login',array('wizard'=>$wizard));
		}//if
	}//func
}//class	
 
?>
