<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta content="text/html; charset=<?php echo $info['charset']; ?>" http-equiv="Content-Type">
<link href="<?php echo $info['url']; ?>" rel="schema.DC">
<link href="<?php echo $info['icon']; ?>" rel="shortcut icon">
<link href="<?php echo $info['url']; ?>" rel="canonical">
<meta content="Public" name="Security">
<meta content="<?php echo $info['name']; ?>" name="DC.Publisher">
<meta content="<?php echo $info['describe']; ?>" name="Description">
<meta content="<?php echo $info['abstract']; ?>" name="Abstract">
<meta content="<?php echo $info['keyword']; ?>" name="Keywords">
<meta content="<?php echo $info['url']; ?>" name="Owner">
<meta content="index,follow" name="Robots">
<meta content="<?php echo $info['date']; ?>" scheme="W3CDTF" name="GooyaWeb.Effective">
<meta content="<?php echo $info['date']; ?>" scheme="iso8601" name="DC.Date">
<meta content="© Copyright <?php echo $info['copyright']; ?>" name="DC.Rights">

<title><?php echo $info['page_title']; ?></title>
<link href="<?php echo $info['theme_url']; ?>css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?php echo $info['theme_url']; ?>js/jquery.min.js"></script>
</head>
<body>     
<div align="center" id="all" >
<div id="page_box"> 

<div align="center" id="header">
	<div dir="rtl" align="right" id="welcome">
	<?php 
	if ($info['login']==false)
	{		
		echo '	مهمان عزیزخوش آمديد';
	}else{	
		echo $info['username'].'   عزیزخوش آمديد ';
	}?>
	</div>
	<div id="header_tools">
		<div id="slide_show">
			<div id="slide_animation">
				<div id="pic1"></div>
				<div id="pic2"></div>
				<div id="pic3"></div>
			</div>
			<div id="control_pad">
				<a id="link1" href="javascript:void(0)"><div></div></a>
				<a id="link2" href="javascript:void(0)"><div></div></a>
				<a id="link3" href="javascript:void(0)"><div></div></a>
			</div>
		</div>
		<script type="text/javascript" >
			var d=-1;
			function callc()
			{
			setTimeout("movc()",7000);
			}
			function movc()
			{
				d++;
				if ( d==3)d=0;
				switch (d)
				{
					case 0:
						$('#link1 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/selected_button.png)');
						$('#link2 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
						$('#link3 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
						$('#pic1').fadeIn();
						$('#pic2').fadeOut();
						$('#pic3').fadeOut();
						break;
					case 1:
						$('#link2 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/selected_button.png)');
						$('#link1 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
						$('#link3 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
						$('#pic1').fadeOut();
						$('#pic2').fadeIn();
						$('#pic3').fadeOut();
						break;
					case 2:
						$('#link3 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/selected_button.png)');
						$('#link2 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
						$('#link1 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
						$('#pic1').fadeOut();
						$('#pic2').fadeOut();
						$('#pic3').fadeIn();
						break;
				}//case
				callc();
			}//func
			callc();

		</script>
		<script type="javascript">
		$('#toolbar_red').mouseover(
		function(){
			var properties = {left: 160, opacity: 1};
			var duration = 500;
			var easing = 'easeOutBack';
			this.children('p').stop(true)
				.filter(':eq(0)').animate({opacity: 0}, 000).animate(properties, duration, easing).end()
				.filter(':eq(1)').animate({opacity: 0}, 250).animate(properties, duration, easing).end()
				.filter(':eq(2)').animate({opacity: 0}, 500).animate(properties, duration, easing);
		}
		);
		</script>
		<div id="vector_frame">
			<div id="vector_left_space"></div>
			<div id="vector"></div>
		</div>
		<div id="login_frame">
		
		<div id="loginbox">
			<div style="width:246px;height:44px;float:right;"></div>
			<div id="button_right_space"></div>
			
			<?php
         
		if ($info['login']==true)
		{
			echo '
			<a href="'.$info['logout_url'].'">
				<div class="login_button" align="center"><b>خروج  </b></div>
			</a>
			<form name="input" method="post" action="/user">
				<div style="width:153px;height:42px;float:right;" align="right">
					<br />
				</div>
				<div id="button_right_space"></div>
				<a href="'.$info['admin_url'].'">
					<div class="login_button" align="center"><b>کنترل پنل</b></div>
				</a>
				<div style="width:133px;height:42px;float:right;" align="right">
					<br />
				</div>
			</form>
			';
		}
		else
		{
			echo '
			<a href="'.$info['login_url'].'">
				<div class="login_button" align="center"><b>ورود به سایت</b></div>
			</a>
			<form name="input" method="post" action="/user">
				<div style="width:153px;height:42px;float:right;" align="right">
					<br />
				</div>
				<div id="button_right_space"></div>
				<a href="">
					<div class="login_button" align="center"><b>عضویت</b></div>
				</a>
				<div style="width:133px;height:42px;float:right;" align="right">
					<br />
				</div>
			</form>';
        }//else
		?>
			
		</div>
		</div>
		<div class="horizental_space"></div>
	</div>
</div>
<script language="javascript">
	$('#link1').click(
		function(){
		$('#link1 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/selected_button.png)');
		$('#link2 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
		$('#link3 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
		$('#pic1').fadeIn();
		$('#pic2').fadeOut();
		$('#pic3').fadeOut();
		d=0;
	});
	$('#link2').click(
		function (){
		$('#link2 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/selected_button.png)');
		$('#link1 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
		$('#link3 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
		$('#pic2').fadeIn();
		$('#pic1').fadeOut();
		$('#pic3').fadeOut();
		d=1;
	});
	$('#link3').click(
		function () {
		$('#link3 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/selected_button.png)');
		$('#link2 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
		$('#link1 div').css('background-image','url(<?php echo $info['theme_url']; ?>images/button.png)');
		$('#pic3').fadeIn();
		$('#pic1').fadeOut();
		$('#pic2').fadeOut();
		d=2;
	});
</script>
<div id="menu" align="center">
	<div>
		<a href="<?php echo $info['url']; ?>"><div align="center"><p><b>صفحه اصلی</b></p></div></a>
		<a href="<?php echo $info['index_url']; ?>about"><div align="center"><p><b>درباره سیستم</b></p></div></a>
		<a href="<?php echo $info['index_url']; ?>tools"><div align="center"><p><b>امکانات سیستم</b></p></div></a>
		<a href="<?php echo $info['index_url']; ?>news"><div  align="center"><p><b>سفارش اخبار</b></p></div></a>
	</div>
</div>
<script language="javascript">
var dis=0;
function change(id){
	if(dis==1)return;
	divs=document.getElementById('toolbar').getElementsByTagName('div');
	for(var div ,i=0;div=divs[i++];)
		if(div.id != id){
			$('#'+div.id).animate({width: 210},200);
			$('#'+div.id).find('div').hide(200);
		}//if
	dis=1;
	$('#'+id).animate({width: 367},200,0,function(){dis=0;});
	$('#'+id ).find('div').show(300);
}	
</script>
<script language="javascript">

var dis2=0;
function change_menu(id){
	if(dis2==1)return;
	for(i=1;i<5;i++)
		if(i!=id)
			$('#cx'+i).animate({width: 0},250);
	dis2=1
	$('#cx'+id).animate({width: 367},250,0,function(){dis2=0;});
}	

</script>
<div class="box"> 
	<div id="toolbar">
		<div id="toolbar_red" onmousemove="change('toolbar_red')"><div class="toolbar_space" onmousemove="change('toolbar_red')"></div>
		<div onmousemove="change('toolbar_red')" class="product">		<br/><br/><br/>
			◄قابلیت جستجوی تصاویر<br/>
			◄قابلیت آرشیو کردن تصاویر قبلی<br/>
			◄قابلیت دریافت تصاویر<br/>	
			<ul class="star">
				<li class="selected_li"></li><li class="selected_li"></li><li class="selected_li"></li><li class="selected_li"></li><li class="selected_li"></li>
				<a href="packagered.htm"><div class="continue"></div></a>
			</ul>
			</div></div>
		<div id="toolbar_yellow" onmousemove="change('toolbar_yellow')"><div class="toolbar_space" onmousemove="change('toolbar_yellow')"></div>
		<div  onmousemove="change('toolbar_yellow')" class="product">
				<br/><br/><br/>
			◄قابلیت ثبت عکاس<br/>
			◄سیستم دسترسی مدیر<br/>
			◄سیستم دسترسی جستجوگر<br/>	
			<ul class="star">
				<li class="selected_li"></li><li class="selected_li"></li><li class="selected_li"></li><li class="selected_li"></li><li></li>
			</ul>
			<a href="packageyellow.htm"><div class="continue"></div></a>
		</div></div>
		<div id="toolbar_green" onmousemove="change('toolbar_green')"><div class="toolbar_space" onmousemove="change('toolbar_green')"></div>
		<div onmousemove="change('toolbar_green')" class="product">
				<br/><br/><br/>
			◄امنیت بسیار بالا<br/>
			◄جستجوی بسیا سریع<br/>
			◄پایداری قوی<br/>	
			<ul class="star">
				<li class="selected_li"></li><li class="selected_li"></li><li class="selected_li"></li><li></li><li></li>
			</ul>
			<a href="packagegreen.htm"><div class="continue"></div></a>
		</div></div>
		<div id="toolbar_blue" onmousemove="change('toolbar_blue')"><div class="toolbar_space" onmousemove="change('toolbar_blue')"></div>
		<div onmousemove="change('toolbar_blue')" class="product">
			<br/><br/><br/><br/>
			◄جستجو بر اساس کلمه کلیدی<br/>
			◄جستجو براساس شرح<br/>
			◄جستجو براساس تاریخ<br/>	
			<ul class="star">
				<li class="selected_li"></li><li class="selected_li"></li><li></li><li></li><li></li>
			</ul>
			<a href="packageblue.htm"><div class="continue"></div></a>
		</div></div>
	</div>
</div>
<div id="menu_vasat">
	<div class="box">
		<a href="http://niazy.ir" onmousemove="change_menu(1)"><div id="menu_vasat_red"><p><b>تماس با ما</b></p></div></a>
		<div class="menu_vasat_contex" id="cx1"><p>با ما تماس بگیرید</p></div>
		<a href="http://niazy.ir" onmousemove="change_menu(2)"><div id="menu_vasat_yellow"><p><b>خدمات ما</b></p></div></a>
		<div class="menu_vasat_contex" id="cx2"><p>با خدمات ما آشنا شوید</p></div>
		<a href="mailto:nasservb@gmail.com" onmousemove="change_menu(3)"><div id="menu_vasat_green"><p><b>نامه نگاری</b></p></div></a>
		<div class="menu_vasat_contex" id="cx3"><p>به ما ایمیل بزنید</p></div>
		<a href="http://niazy.ir" onmousemove="change_menu(4)"><div id="menu_vasat_blue"><p><b>محصولات ما</b></p></div></a>
		<div class="menu_vasat_contex" id="cx4"><p>با محصولات ما آشنا شوید</p></div>
	</div>
</div>

<div id="post" align="right" dir="rtl">
	<div id="post_title" align="center"><p><b><?php echo $info['title']; ?></b></p></div>
	<div id="post_box" align="center">
		<div id="post_body"  align="<?php echo $info['align']; ?>" dir="<?php echo $info['dir']; ?>">
		<?php echo $info['body']; ?>
		</div>
	</div>
	<div id="post_footer"></div>
</div>
<div id="footer"align="center">
	<div id="footer_delimiter"></div>
	Copyright : <a href="<?php echo $info['url']; ?>" style="font-size:10pt;text-decoration:none"> <b><?php echo $info['copyright']; ?></b></a> <br/>
	<p face="Tahoma" dir="rtl" style="font-size:9pt"><?php echo $info['footer_text']; ?>  </p>
</div>

</div>
</div>

</body>
</html>
