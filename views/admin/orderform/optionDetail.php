<?php //allahoma sale ala mohammad va ale mohammad
 

class optionDetail
{
	function optionDetail($temp)
	{
		$body = '';
        $option = $temp['option'];
        $optionItems = $temp['optionItems'];
        
		$body .= '<div class="table-responsive">';
		
		$body .= '
		<table class="table table-bordered">
			<tr><td>نام</td><td>'.$option[0]['value'].'</td></tr>
			<tr><td>نوع</td><td>'.($option[0]['type'] == 'combobox' ? 'انتخاب کردنی' : 'تایپ کردنی' ).'</td></tr>		
		</table>
		<br/>
		';
		
		if($option[0]['type'] == 'combobox')
		{
			$body .= '
			<table class="table table-bordered">
			<thead class="text-primary">
			<th class="text-right">آیتم ها</th>
			<th class="text-right">ویرایش</th>
			<th class="text-right">حذف</th>
			</thead>
			<tbody>';
			foreach($optionItems as $item)
			{
				$body .= '
				<tr>
				<td>'.$item['value'].'</td>
				<td><a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/editOptionItem/'.
				$item['id'] . '">ویرایش</a></td>
				<td><a class="btn btn-danger btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/deleteOptionItem/'.
				$item['id'] . '">حذف</a></td>
				</tr>
				';
			}
			$body .= '</tbody></table>';
		
			$body .= '<br/>
			<a class="btn btn-primary" href="'.GSMS::$class['template']->info['admin_url'] .'orderform/addOptionItem/'.$option[0]['id'].'">افزودن آینم</a>';
		}
		
		
		$body .= '</div>';
 
        GSMS::$class['template']->message('جزییات المنت', $body,'admin','',false ,false,array('activeTab'=>'orderform')); 
	}
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}