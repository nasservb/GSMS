<?php //allahoma sale ala mohammad va ale mohammad
 

class ListInternetTrans
{
	function ListInternetTrans($temp)
	{
		$userInfo = $temp['userInfo']; 
		 
		list($tempTrans, $begin, $count) = $temp['res'];
		
		if($temp==null || count($tempTrans) == 0)
		{
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">پرداختی يافت نشد</div>';			 
			
			GSMS::$class['template']->message( 'ليست پرداخت های آنلاين',$body,'admin','',false,true , array('activeTab' => 'accounting'));
            return;
		}
		
		//var_dump($tempTrans[0]);
		$body = '';
		$body .= '
		<div class="table-responsive">
		<table class="table table-hover" >
		<thead class="text-primary">
		<th class="text-right" >شماره</th>
		<th class="text-right" >نام پرداخت کننده</th>
		<th class="text-right" >نام کاربری</th>
		<th class="text-right" >کد پیگیری</th>
		<th class="text-right">مبلغ</th>
		<th class="text-right">تاریخ پرداخت</th> 
		<th class="text-right">ساعت پرداخت</th> 
		<th class="text-right">وضعیت</th>
		<th class="text-right">شماره تماس</th>
		<th class="text-right">مشاهده صورتحساب</th>
		<th class="text-right">جزییات</th>
		</thead>
		<tbody>
		';
		for ($i = 0; $i < count($tempTrans); $i++) 
		{
			$name = '';
			$userName = '';
			foreach($userInfo as $value){
				if(intval($value['admin_id']) == intval($tempTrans[$i]->adminId))
				{
					$name = $value['name'].' ' . $value['family'];
					$userName = $value['username'];
				}
				
			}
			
			
			
			$body .= '
			<tr>
			<td>'.$tempTrans[$i]->id.'</td>
			<td>'.$name.'</td>
			<td>'.$userName.'</td>
			<td>'.$tempTrans[$i]->refNum.'</td>
			<td>'. number_format($tempTrans[$i]->totalAmount).' ریال</td>
			<td>'.$tempTrans[$i]->dateStart.'</td>
			<td>'.$tempTrans[$i]->timeStart.'</td>
			<td'.(empty($tempTrans[$i]->refNum) ? ' class="text-danger">ناموفق' : ' class="text-success">موفق').' </td>
			<td>'.$tempTrans[$i]->phone.'</td>
			<td>'.'<a  class="btn btn-success" '.(intval($tempTrans[$i]->factureId)>0 ? '' : ' disabled').' href=\''.GSMS::$class['template']->info['admin_url'].'accounting/viewFacture/' 
			. $tempTrans[$i]->factureId . '\'>نمایش</a>'.'</td>'.
			'<td>'.'<a  class="btn btn-primary" href=\''.GSMS::$class['template']->info['admin_url'].'accounting/viewIntTrans/' 
			. $tempTrans[$i]->id . '\'>نمایش</a>'.'</td>		
					
			</tr>';
		}
		
		
		$body .= '</tbody></table><br>';
		
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'accounting/listInternetTrans/', $begin, $count);
		
		$body .= '</div>';
		 
		GSMS::$class['template']->message( 'ليست پرداخت های آنلاين',$body,'admin','',false,false, array('activeTab' => 'accounting'));
		
	}
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}