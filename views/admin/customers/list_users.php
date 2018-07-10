<?php //allahoma sale ala mohammad va ale mohammad
 

class list_users
{
   
    function list_users($tempAdminArray)
    {
		list($tempAdmins,$begin,$itemCount) = $tempAdminArray;
		
	
		if(count($tempAdmins)==0 || !is_array($tempAdmins))
		{
			$body .='مشتری يافت نشد '; 
			GSMS::$class['template']->message('لیست مشتریان' ,$body , 'admin','alert alert-warning',true,true , array('activeTab'=>'customers')  );
			return;
		}
		
		$date = '';
		
		$body ='
		<div class="table-responsive"> 
		<table class="table table-hover" >
		<thead class="text-primary">
		<th class="text-right">#</th>
		<th class="text-right">نام کاربري</th>
		<th class="text-right">نام کامل</th>
		<th class="text-right">ايميل</th>
		<th class="text-right">همراه</th>
		<th class="text-center">ويرايش</th>
		<th class="text-center">سفارشات</th>
		</thead>
		<tbody>';
		for($i=0;$i<count($tempAdmins);$i++)
		{
			$body .= '<tr >'.
				'<td>'.$tempAdmins[$i]->id.'</td>'.
				'<td>'.$tempAdmins[$i]->username.'</td>'.
				'<td>'.$tempAdmins[$i]->name.' '.$tempAdmins[$i]->family.'</td>'.
				'<td>'.$tempAdmins[$i]->mail.'</td>'.
				'<td>'.$tempAdmins[$i]->mobile.'</td>'.
				'<td class="text-center"><a class="btn btn-primary btn-success" href="'.GSMS::$class['template']->info['admin_url'].'customers/editCustomer/'.$tempAdmins[$i]->id.'">ويرايش</a></td>'.
				'<td class="text-center"><a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'].'orders/listOrdersByUser/'.$tempAdmins[$i]->id.'">نمايش سفارشات</a></td>';
		}//for
		$body .='</tbody></table><br> ';
		$body .=GSMS::$class['template']->paging(
					GSMS::$class['template']->info['admin_url'].'customers/listCustomers/',$begin,$itemCount);
		$body .='<br/></div>';	
		GSMS::$class['template']->message('لیست مشتریان' ,$body , 'admin' ,'',false,false ,array('activeTab'=>'customers') ) ;
		
	}
	
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}