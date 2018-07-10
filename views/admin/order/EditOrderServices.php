<?php
class EditOrderServices
{
	function EditOrderServices($temp)
	{
		//var_dump($temp);
		//---------------initializing-----------
		$inf = array('page_title' => 'ویرایش سرویس های سفارش','activeTab' => 'orders');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'admin_header');
		//-------------------
		$body = '';
		if($temp==null){
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">سفارشي يافت نشد</div>';
			$inf['body'] = $body ;
			$inf['title'] = 'خطا';
			GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');
			return ;
		}
		$userOrder=$temp['userOrder'];
		$userContent=$temp['userContent'];
		
		$inf['title'] = 'سفارش شماره: '.$userOrder->id;
		if(count($userContent) == 0)
		{
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">سفارش بدون سرویس است</div>';
			$inf['body'] = $body ;
			GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');
			return ;
		}
		$randomSt = '';
		if(is_object($userOrder) && is_array($userContent))
		{
			$body .= '
			<form method ="POST" enctype="multipart/form-data" onSubmit="return checkForm()">
			<div class="table-responsive">
			<table class="table">
				<thead class="text-primary">
					<th class="text-right">نوع سرویس</th>
					<th class="text-right">نام سرویس</th>
					<th class="text-right">تعداد</th>
					<th class="text-right">قیمت پایه (ريال)</th>
					<th class="text-right">هزینه سرویس (ريال)</th>
				</thead>
				<tbody>
			';
			
			foreach($userContent as $contValue) 
			{
				$randomSt .= $contValue['random'].',';
				$price = intval($contValue['count']) * intval($contValue['price']);
				$body.= '
				<tr>
					<td>'.$contValue['type'].'</td>
					<td>'.$contValue['service'].'</td>
					<td><input id="count'.$contValue['random'].'" name="count'.$contValue['random'].'" type="text" class="form-control" value="'.$contValue['count'].'"></td>
					<td><input id="price'.$contValue['random'].'" name="price'.$contValue['random'].'" type="text" class="form-control" value="'.$contValue['price'].'"></td>
					<td><h5 class="text-info">'.$price.'</h5></td>
				</tr>
				<input type="hidden" id="id'.$contValue['random'].'" name="id'.$contValue['random'].'" type="text" class="form-control" value="'.$contValue['id'].'" >
					';
			}
			$body .= '
			</tbody>
			</table>
			</div>
			<input id="randomValue" name="randomValue" type="hidden" value="'.$randomSt.'">
			<div class="row">
				<input name="submit" class="btn btn-primary" value="ثبت" type="submit">
			</div>
			</form>';
        }
		
		$inf['body'] = $body;
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
	}
}


//class
if (!defined("GSMS")) {
    exit("Access denied");
}