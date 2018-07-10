<?php //allahoma sale ala mohammad va ale mohammad
 

class ViewIntTrans
{
    function ViewIntTrans($temp)
    {
		$internetTran = $temp['intTrans'];
		$inf = array('page_title' => 'نمایش پرداخت آنلاین','activeTab' => 'accounting');
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf,'admin_header');
		$inf['title'] = $inf['page_title'] . ' شماره :' . $internetTran->id ;
        //------------------------
		
		//var_dump($internetTran);
        $body = '';
		$acceptorUser = $temp['acceptor']; 
		$accpetorSt = '';

		$bottunSt = '';
		
		if(empty($internetTran->refNum)){
			$bottunSt .= '<div class="alert alert-danger col-lg-4 col-md-6 col-sm-6 pull-right">پرداخت ناموفق بوده است</div>';
		}
		else 
		{
			$bottunSt .= '<div class="alert alert-success col-lg-4 col-md-6 col-sm-6 pull-right">پرداخت موفق بوده است</div>';
		}
		
		$body .= '
		<div class="message-info table-responsive">
		<table dir="rtl" class="table table-striped table-hover" >
		<tbody>
		<tr ><td class="text-right" >کد</td><td>'. $internetTran->id.'</td></tr>
		<tr><td class="text-right">کد پیگیری</td><td>'. $internetTran->refNum.'</td></tr>
		<tr ><td class="text-right">مبلغ</td><td>'. $internetTran->totalAmount.'</td></tr>
		<tr><td class="text-right">روش پرداخت</td><td>'. $internetTran->payment.'</td></tr>
		<tr ><td class="text-right">تاریخ</td><td>'. $internetTran->dateStart.'</td></tr>
		<tr><td class="text-right">ساعت</td><td>'. $internetTran->timeStart.'</td></tr>
		<tr ><td class="text-right">ایمیل</td><td>'. $internetTran->email.'</td></tr>
		<tr><td class="text-right">کد کاربر</td><td>'. $internetTran->adminId.'</td></tr>
		<tr ><td class="text-right">نام کاربر</td><td>'. $internetTran->name.'</td></tr>
		<tr><td class="text-right">تلفن کاربر</td><td>'. $internetTran->phone.'</td></tr>
		<tr ><td class="text-right">کد فاکتور</td><td>'. $internetTran->factureId.'</td></tr>
		<tr><td class="text-right">توضیخات</td><td>'. $internetTran->comment.'</td></tr>
		<tr ><td class="text-right">آی پی</td><td>'. $internetTran->ipAddress.'</td></tr>
		<tr><td class="text-right">آخرین آدرس</td><td>'. $internetTran->lastUrl.'</td></tr>
		';
		$body .= '</tbody></table><br/>'. $bottunSt;
		
		
		
		$body .= '</div>';
		
		$inf['body'] = $body ;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
	}
}
//class
if (!defined("GSMS")) {
    exit("Access denied");
}