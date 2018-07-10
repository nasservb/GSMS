<?php
class home
{
    function home()
    {
		//---------------initializing-----------
		$inf = array('page_title' => 'در دست ساخت');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'panel_header');
		//-------------------
		$body = '';
		$body .= '        
		<div class="message-info" style="   height: 500px; text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		<br/><br/><br/><br/><br/><br/><br/><br/>
		<h1  style="text-align: center;">
		در دست ساخت
		</h1></di>
		';
		
		$body .= '</div>';
		$inf = array('title' =>  'پرداخت', 'body' => $body);
		GSMS::$class['template']->index($inf);
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
