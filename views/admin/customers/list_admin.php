<?php //allahoma sale ala mohammad va ale mohammad
 

class list_admin
{
	function list_admin($tempAdminArray)
    {
		//var_dump($tempAdminArray);
		list($tempAdmins,$begin,$itemCount) = $tempAdminArray; 
	
		if(count($tempAdmins)==0 || !is_array($tempAdmins))
		{
			$body .='مشتری يافت نشد '; 
			GSMS::$class['template']->message('لیست مدیران و کارمندان' ,$body , 'admin',
			'alert alert-warning',true,false , array('activeTab'=>'customers')  );
			return;
		}
		
		$date = '';
		
		$body ='
		<div class="table-responsive"> 
		<table class="table table-bordered">
		<thead class="text-primary">
		<th class="text-right">شماره</th>
		<th class="text-right">نام کاربري</th>
		<th class="text-right">نام کامل</th>
		<th class="text-right">ايميل</th>
		<th class="text-right">نوع</th>
		<th class="text-right">تاريخ ثبت</th>
		<th class="text-right">همراه</th>
		<th class="text-right">ويرايش</th>
		<th class="text-right">نمايش</th> 
		</thead>
		<tbody>';
		for($i=0;$i<count($tempAdmins);$i++)
		{
			$body .= '<tr >'.
				'<td>'.$tempAdmins[$i]->id.'</td>'.
				'<td>'.$tempAdmins[$i]->username.'</td>'.
				'<td>'.$tempAdmins[$i]->name.' '.$tempAdmins[$i]->family.'</td>'.
				'<td>'.$tempAdmins[$i]->mail.'</td>'.
				'<td>'.($tempAdmins[$i]->admin_type == 1 ? 'ادمین' : 'کارمند').'</td>'.
				'<td>'.$tempAdmins[$i]->date.'</td>'.
				'<td>'.$tempAdmins[$i]->mobile.'</td>'.
				'<td><a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'].'customers/editEmployer/'.$tempAdmins[$i]->id.'">ويرايش</a></td>'.
				'<td><a class="btn btn-success btn-sm" href="'.GSMS::$class['template']->info['admin_url'].'customers/viewEmployer/'.$tempAdmins[$i]->id.'">نمايش </a> </td>';
		}//for
		$body .='</tbody></table><br> ';
		$body .=GSMS::$class['template']->paging(
					GSMS::$class['template']->info['admin_url'].'customers/listEmployer/',$begin,$itemCount);
		$body .='<br/></div>';		 
		
		GSMS::$class['template']->message('لیست مدیران و کارمندان' ,$body , 'admin' ,'',false,false, 
		array('activeTab'=>'customers'));
		
	}
	
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}