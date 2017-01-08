<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class contact
{
    public function contact( $p)
    {
		$inf = array('page_title' => ' تماس با ما    ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' =>'  تماس با ما  ');
        GSMS::$class['template']->load($inf,($p ==1||$p ==3 ? 'panel_header' : 'site_header') );
        $user = GSMS::$class['session']->getUser();
		
		if(!isset($_POST['submit']))
		{
			$body='<div  style="padding: 19px;  line-height: 25px;">
			<div class="message-info">
			';


			
				$body.=' 
				چنانچه در استفاده از خدمات سایت به مشکلی برخورد کردید و یا پیشنهاد، انتقاد و نظری دارید می توانید از طریق فرم زیر، با ما تماس بگیرید.<br/>

توجه داشته باشید همه پیام‌های رسیده به ما مورد بررسی قرار می گیرند ولی بر حسب نیاز و صلاحدید به آنها پاسخ داده خواهد شد.<br/>

				 ';
			
			


			$body.='<form action="" method="POST">
			<table class="table table-bordered">
				<tr>
					<td>نام :</td>
					<td><input type="text"  name="name" /></td>
				</tr>
				<tr>
					<td>ایمیل :</td>
					<td><input type="text"  name="email" /></td>
				</tr>
				<tr>
					<td>وب سایت :</td>
					<td><input type="text"  name="web" /></td>
				</tr>
				<tr>
					<td>نظر :</td>
					<td><textarea   name="content"></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td><input class="btn btn-primary" type="submit" name="submit" value="ثبت نظر" /></td>
				</tr>
			</table>
			</form>
			<br/>
		
			</div>
			</div><br/>
			<a class="btn " href="'.GSMS::$class['template']->info[($p ==1 ? 'user_url' : 'index_url')].'">برگشت</a>
			';
		}
		else{
		
			$to = 'nasservb@gmail.com';
			$subject = 'پیام از تماس با ما ';
			ini_set('sendmail_from', 'info@mamadar.ir');
			$headers = "From: info@mamadar.ir\r\n";
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
			http://anychap.com</a>
			</div>';
			 
			mail($to, $subject, $body, $headers);
			
			$body =  '<br/><div class="message-success" ><h4>پیام شما با موفقیت ثبت شد . از توجه شما سپاسگذاریم .</h4></div>
			<br/>
			<br/>
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
			';
		}
		
		$inf = array('title' => '  تماس با ما ', 'body' => $body );
        GSMS::$class['template']->index($inf);
		
        GSMS::$class['template']->footer($inf);
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}