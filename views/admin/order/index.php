<?php //allahoma sale ala mohammad va ale mohammad
 

class index
{
	function index()
	{
		$inf=array();
		$inf=array('page_title'=>'سفارش ها',  'activeTab' => 'orders');
		//$inf ['activeTab'] = 'orders';
		$inf['title'] = 'سفارش ها' ;
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf,'admin_header');
		
		$body = '';
		$body .='<div style="direction: rtl;"> 
		
		<a class="btn btn-info  col-md-4 col-md-3" href="'.
						GSMS::$class['template']->info['admin_url'] 
						.'orders/search" ><div id="search"></div>جستجوی سفارش</a>
				<a class="btn btn-info  col-md-4 col-md-3" href="'.
						GSMS::$class['template']->info['admin_url'] 
						.'orders/ordersArchive" ><div id="archive"></div>آرشیو سفارش ها </a>
		<br/>
		<br/>
		
		';
		
		
		$body .='</div>';
		
		$inf['body'] = $body ;
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
		
	}
}