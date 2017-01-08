<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class changeOrderStatus
{
	function changeOrderStatus($temp)
	{
	
        $inf = array('page_title' => 'تغییر وضعیت سفارش');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'admin_header');	 
				
		$order= $temp['order'];
		$admin= $temp['admin'];
		
		$select = '';
		$statusTitle = '';
		for($i=0 ; $i<count($temp['status']);$i++)
		{
			$select .='<option value="'.$temp['status'][$i]['id'].'">'.$temp['status'][$i]['status'].'</option>'."\n";
			
			if ( $order->statusId == $temp['status'][$i]['id'] )
				$statusTitle = $temp['status'][$i]['status'];
		}
		
        $body = '
        <div class="message-info">
		<br/>
		<form method="POST" >
       <table class="table table-bordered table-hover table-striped" dir="rtl">
        <tr>
			<td>عنوان </td>
			<td>'.$order->name.'</td>
		</tr>
		
        <tr>
			<td>سفارش دهنده</td>
			<td>'. $admin->name . ' ' . $admin->family .'</td>
		</tr>
		
        <tr>
			<td>تلفن همراه سفارش</td>
			<td>'.$order->ownerMobile.'</td>
		</tr>
        <tr>
			<td>تیراژ سفارش </td>
			<td>'.$order->count.'</td>
		</tr>
		
		<tr>
			<td>تاریخ ایجاد سفارش </td>
			<td>'.$order->createDate.'</td>
		</tr>
		
		<tr>
			<td>وضعیت فعلی </td>
			<td> '.$statusTitle.' </td>
		</tr> 
		<tr>
			<td>وضعیت جدید سفارش</td>
			<td><select name="status" >'.$select.'</select></td>
		</tr> 
		<tr>
			<td>توضیحات </td>
			<td><textarea name="desc"  > </textarea></td>
		</tr>
		<tr>
			<input name="order" type="hidden" value="'.$order->id.'" >
			<td>ذخیره </td>
			<td><input class="btn btn-success" name="submit" type="submit" value="ذخیره" > </td>
		</tr>
		
		 
		
		</table>
		<br/>
		</form>
		<a class="btn btn-primary " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewHistory/'.$order->id.'">مشاهده سوابق </a>
		<a class=" btn" href="'.GSMS::$class['template']->info['admin_url'].'" >برگشت</a></div>';

        $inf = array('title' => 'تغییر وضعیت سفارش ', 'body' => $body );
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}