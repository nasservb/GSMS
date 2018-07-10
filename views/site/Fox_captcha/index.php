<?php
	session_start();
	require_once('Fox_captcha.php');
	$img = new Fox_captcha(120, 30, 5);
	$img->lines_amount = 2;
	$img->image_dir = 'images/';// it is in the same page so I need not to add any value
	$img->en_reload = "بارگذاری مجدد";


?>
<html>
<head>
	<meta charset = utf8>
	<title></title>


</head>
<body>

<form action = "form.php" method = "POST">
	Your name :<br/> <input type = "text" name = "name" value = ""/> <br/>
	Code :<br/>
	<lable style = "display:inline"><input type = "text" name = "code"/> | <?php $img->make_it(); ?></lable>
	<br/>
	<input type = "submit" value = "Validate!"/>
</form>

</body>
</html>