<?php
	
	//session_start();
	require '../../../../GSMS.php';
	$gsms = new GSMS();
	
	if (empty($_SESSION['FoxCaptchaFilePath'])) die('Fox_Captcha Error: missing session for image.');
	include($_SESSION['FoxCaptchaFilePath']);
	$img = new Fox_captcha(120, 30, 5);
	$img->lines_amount = $_SESSION['Fox_CaptchaSSim_linesAmount'];
	$img->make_it('JPG');
?>