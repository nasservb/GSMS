<?php //allahoma sale ala mohammad va ale mohammad
 

class extraSevice
{
	function extraSevice($temp)
	{
		$body = '';
          
		$title = 'لیست خدمات تکمیلی فرم  ' . $temp['type'][0]['title'];
		
		$body .= '
		<div class="table-responsive">
		<table class="table table-hover">
		<thead class="text-primary">
		<th class="text-right">#</th>
		<th class="text-right">عنوان</th>
		<th class="text-right">ویرایش</th>
		<th class="text-right">حذف</th>
		</thead>
		<tbody>';
		foreach($temp['service'] as $typeValue)
		{
			$body .= '
			<tr>
			<td>'.$typeValue['id'].'</td>
			<td>'.$typeValue['service'].'</td>
			<td><a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/addExtraService/'.$temp['type'][0]['id'].'/'.
			$typeValue['id'] . '">ویرایش</a></td>
			<td><a class="btn btn-danger btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/delExtraService/'.
			$typeValue['id'] . '">حذف</a></td>
			</tr>
			';
		}
		
		$body .= '</tbody></table>
		<a class="btn btn-success" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/addExtraService/'.$temp['type'][0]['id'].'">افزودن</a>
		</div>';
		
		 
        GSMS::$class['template']->message($title, $body,'admin','',false ,false,array('activeTab'=>'orderform')); 
	}
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}