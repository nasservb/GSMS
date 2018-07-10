<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class contact
{
    public function contact( $p)
    {
		$inf = array('page_title' => ' تماس با ما    ');
        GSMS::$class['template']->header($inf); 
		
        GSMS::$class['template']->load($inf,($p ==1||$p ==3 ? 'user_header' : 'site_header') );
        $user = GSMS::$class['session']->getUser();
		$body='';
		
		if(!isset($_POST['submit']))
		{
			$body='<div  style="padding: 19px;  line-height: 25px;">
			<div class="message-info">
			 
				چنانچه در استفاده از خدمات سایت به مشکلی برخورد کردید و یا پیشنهاد، انتقاد و نظری دارید می توانید از طریق فرم زیر، با ما تماس بگیرید.<br/>

توجه داشته باشید همه پیام‌های رسیده به ما مورد بررسی قرار می گیرند ولی بر حسب نیاز و صلاحدید به آنها پاسخ داده خواهد شد.<br/>

				  <form action="" method="POST">
			
<div class="row">
	<div class="col-md-12">
		<div class="form-group is-empty">
			<label class="control-label">نام</label>
			<input type="text" class="form-control" name="name" id="name" size="30" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-12">
		<div class="form-group is-empty">
			<label class="control-label">ایمیل</label>
			<input type="text" class="form-control"  name="email" id="email"  size="30" />
		 </div>
	</div>
	<div class="col-md-12">
		<div class="form-group is-empty">
			<label class="control-label">وب سایت</label>
			<input type="text" class="form-control"  name="web" id="web"  size="30" />
		 </div>
	</div>
	<div class="col-md-12">
		<div class="form-group is-empty">
			<label class="control-label">پیام</label>
			<textarea class="form-control"  name="content" id="content"  ></textarea>
		 </div>
	</div>
	<div class="col-md-12">
		<div class="form-group is-empty">
		
			<input class="btn btn-primary" type="submit" name="submit" value="ارسال پیام" />
		 </div>
	</div>
</div>
 			
			 
					 
			</form>
			<br/>
		
			</div>
			</div><br/>
			<a class="btn " href="'.GSMS::$class['template']->info[($p ==1 ? 'user_url' : 'index_url')].'">برگشت</a>
			';
		}
		else
		{
		
			$to = 'nasservb@gmail.com';
			$subject = 'پیام از تماس با ما ';
			ini_set('sendmail_from', 'info@'.GSMS::$siteURL );
			$headers = "From: info@".GSMS::$siteURL ."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "Reply-To: $to";
			$headers .= "X-Mailer: PHP/" . phpversion();

			
			$message2 = '<table><thead><th>عنوان</th> <th>اطلاعات</th></thead>';
			$message2 .= '<tr><td>نام :</td>' . GSMS::$class['input']->post('name') . '<td></td>';
			$message2 .= '<tr><td>ایمیل :</td>' . GSMS::$class['input']->post('email') . '<td></td>';
			$message2 .= '<tr><td>سایت :</td>' .GSMS::$class['input']->post('web')  . '<td></td>';
			$message2 .= '<tr><td>متن :</td>' . str_replace(chr(13), '<br/>', GSMS::$class['input']->post('content')) . '<td></td>';


			$body = '<div style=" background-color: #EBF8F9;background-color: #EBF8F9;
				font-size: 11pt;
				border: 1px solid #0796AE;
				padding: 10px;
				border-radius: 5px;
				font-weight: normal;
				width: 90%;
				box-shadow: 1px 1px 3px 1px #99E9DE;
				direction: rtl;
				text-align: right;">
				<h3>شما یک پیام جدید در سایت   دارید</h3><br/>
				<h4>     همکار گرامی ، سلام</h4><br/>
			فردی در وب سایت  فرم تماس با ما را پر  کرده است . لطفآ بررسی نمائید .<br/>

			<br/>
			' . $message2 . '
			<br/>
			'. GSMS::$siteURL .'</a>
			</div>';
			 
			mail($to, $subject, $body, $headers);
			
			$body =  '<br/><div class="alert alert-success" ><h4>پیام شما با موفقیت ثبت شد . از توجه شما سپاسگذاریم .</h4></div>
			<br/>
			<br/>
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
			';
		}
		
		$inf = array('title' => '  تماس با ما ', 'body' => $body );
		
        GSMS::$class['template']->load($inf,'site_index');
		
        GSMS::$class['template']->load($inf,'site_footer');
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}