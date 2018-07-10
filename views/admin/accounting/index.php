<?php //allahoma sale ala mohammad va ale mohammad
 

class index
{
	function index()
	{
		$inf=array();
		$inf=array('page_title'=>'حسابداری',  'activeTab' => 'accounting');
		//$inf ['activeTab'] = 'orders';
		$inf['title'] = 'حسابداری' ;
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf,'admin_header');
		
		$body = '';
		$body .='<div style="direction: rtl;">
		<div class="pull-right col-lg-4 col-md-6 col-sm-6" >
		<a class="btn btn-info" href="'.
		GSMS::$class['template']->info['admin_url'] .'accounting/listInternetTrans" >
		<div id="insert"></div>لیست پرداخت های آنلاین</a>
		</div>
		 
		<div class="pull-right col-lg-4 col-md-6 col-sm-6">
		<a class="btn btn-info" href="'.
		GSMS::$class['template']->info['admin_url'] .'accounting/listNotPaidFactures" >
		<div id="insert"></div>لیست فاکتورهای پرداخت نشده</a>
		</div>
		
		<div class="pull-right col-lg-4 col-md-6 col-sm-6">
		<a class="btn btn-info" href="'.
		GSMS::$class['template']->info['admin_url'] .'accounting/listPaidFactures" >
		<div id="insert"></div>لیست فاکتورهای پرداخت شده</a>
		</div>
		
		 
		
		';
		
		$body .='</div>';
		
		$inf['body'] = $body ;
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
		
	}
}