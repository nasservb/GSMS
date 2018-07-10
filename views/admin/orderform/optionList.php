<?php //allahoma sale ala mohammad va ale mohammad
 

class optionList
{
	function optionList($temp)
	{
		$body = '';
        $serviceTypes = $temp['serviceTypes'];
        $begin = $temp['begin'];
        $itemCount = $temp['itemCount'];
        
		
		$directory = 'optionList' . $temp['type']['id'];
		$title = 'لیست المنت های ' . $temp['type']['title'];
		
		$body .= '
		<div class="table-responsive">
		<table class="table table-hover">
		<thead class="text-primary">
		<th class="text-right">نام</th>
		<th class="text-right">نوع</th>
		<th class="text-right">نمایش جزییات</th>
		<th class="text-right">ویرایش</th>
		<th class="text-right">حذف</th>
		</thead>
		<tbody>';
		foreach($serviceTypes as $typeValue)
		{
			$body .= '
			<tr>
			<td>'.$typeValue['value'].'</td>
			<td>'.($typeValue['type'] == 'combobox' ? 'انتخاب کردنی' : 'تایپ کردنی' ).'</td>
			<td>'.
			($typeValue['type'] == 'combobox' ? 
			'<a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/viewOrderOption/'.
			$typeValue['id'] . '">تنظیم آیتم ها</a>' : '' 
			)
			.'</td>
			<td><a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/editOrderOption/'.
			$typeValue['id'] . '">ویرایش</a></td>
			<td><a class="btn btn-danger btn-sm" href="'.GSMS::$class['template']->info['admin_url'] . 'orderform/deleteOrderOption/'.
			$typeValue['id'] . '">حذف</a></td>
			</tr>
			';
		}
		
		$body .= '</tbody></table>
		<a class="btn btn-success" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/addOrderOption/">افزودن</a>
		</div>';
		
		$body .= GSMS::$class['template']->paging(
		GSMS::$class['template']->info['admin_url'] . 'orderform/'.$directory.'/', $begin, $itemCount);
 
        GSMS::$class['template']->message($title, $body,'admin','',false ,false,array('activeTab'=>'orderform')); 
	}
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}