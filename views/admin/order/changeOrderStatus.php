<?php //allahoma sale ala mohammad va ale mohammad
 

class changeOrderStatus
{
	function changeOrderStatus($temp)
	{
		$order= $temp['order'];
		$admin= $temp['admin'];
		$pageTitle = 'تغییر وضعیت سفارش';
		
		$inf['title'] = $pageTitle. ' شماره: '.$order->id;
		$inf['page_title'] = $pageTitle;
		$inf['activeTab'] = 'orders';
		GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'admin_header');
	
       // $inf = array('page_title' => 'تغییر وضعیت سفارش');
        //GSMS::$class['template']->header($inf); 
        //GSMS::$class['template']->load($inf,'panel_header');	 
				
		
		
		$select = '<option value="0" selected>انتخاب کنید</option>';
		$statusTitle = '';
		for($i=0 ; $i<count($temp['status']);$i++)
		{
			$select .='<option value="'.$temp['status'][$i]['id'].'" '
					//.($temp['status'][$i]['id'] == $order->statusId ? ' selected' : '' )
			.'  >'.$temp['status'][$i]['status'].'</option>'."\n";
			
			if ( $order->statusId == $temp['status'][$i]['id'] )
				$statusTitle = $temp['status'][$i]['status'];
		}
		
        $body = '
        <div class="message-info">
		<br/>
		
		<div class="row">
		<form method="POST" onSubmit="return checkForm()">
		<div class="table-responsive">
		<table class="table">
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
			<td><select id="status" name="status" >'.$select.'</select></td>
		</tr> 
		<tr>
			<td>توضیحات </td>
			<td><textarea name="desc"  > </textarea></td>
		</tr>
		<tr>
			<input name="order" type="hidden" value="'.$order->id.'" >
			<td></td>
			<td><input class="btn btn-success" name="submit" type="submit" value="ذخیره" > </td>
		</tr>
		</table>
		</div>
		</form>
		</div>
		<div class="row">
		<a class="btn btn-primary " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewHistory/'.$order->id.'">مشاهده سوابق </a>
		</div>
		<div class="row">
			<div id="checkResult" class="col-sm-6 pull-right"></div>
		</div>
		</div>
		
		<script>  
		$("#checkResult").hide("fast");
		function checkForm() 
		{
			result  = "" ;
			if($("#status").val()  < 1 ){
					result = result + "وضعیت جدید سفارش انتخاب نشده است.<br/>" ;
			}
			if(result.length > 1 )
			{
				$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا های زیر را بررسی کنید : <br/>"+ result) ;
				$("#checkResult").show("slow");
				return false ; 
			} 
			$("#checkResult").hide("slow");
			return true ;
		}
		</script>';

        //$inf = array('title' => 'تغییر وضعیت سفارش ', 'body' => $body );
		$inf['body'] = $body ;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}