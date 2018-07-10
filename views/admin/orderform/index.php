<?php //allahoma sale ala mohammad va ale mohammad
 

class index
{
	function index($data)
	{
		$body = '';
		$body .='<div style="direction: rtl;">
		<h4>فرم ساز سفارش ها </h4>
		';

		foreach ($data as $key ) {
			$body .='<div class="pull-right col-lg-4 col-md-6 col-sm-6" >
		<a class="btn btn-info" href="'.
		GSMS::$class['template']->info['admin_url'] .'orderform/optionList/'.$key['id'].'" >
		<div id="insert"></div>فرم ساز '.$key['title'].'</a>
		</div>';

		}
		
		
		
		$body .='</div>
		<br/>
		<br/>
		<hr style="width:100%"/>
		<br/>
		<h4>خدمات تکمیلی</h4>
		
		
		
		';
		
		foreach ($data as $key ) {
			$body .='<div class="pull-right col-lg-4 col-md-6 col-sm-6" >
		<a class="btn btn-info" href="'.
		GSMS::$class['template']->info['admin_url'] .'orderform/extraSevice/'.$key['id'].'" >
		<div id="insert"></div>خدمات تکمیلی '.$key['title'].'</a>
		</div>';

		}
		
		GSMS::$class['template']->message('فرم ساز سفارش ها',$body,'admin','',true, false, array('activeTab' => 'orderform'));
		
	}
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}