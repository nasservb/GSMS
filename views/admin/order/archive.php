<?php //allahoma sale ala mohammad va ale mohammad
 

class archive
{
	function archive($temp)
	{
		$pageType=$temp['type'];
		$inf=array();
		
		$directory = '';
		
		$inf = array('page_title' => 'آرشیو همه سفارش ها','activeTab' => 'orders');
		$directory = 'ordersArchive';
		
		//-------------------
		$body = '';
		list($tempOrders, $begin, $count) = $temp['res'];
		
		if($temp==null || count($tempOrders) == 0)
		{
			GSMS::$class['template']->message('اطلاعات سفارش يافت نشد' ,'اطلاعات سفارش يافت نشد .' , 'admin');
            return;
		}
		GSMS::$class['template']->header($inf);
		
        GSMS::$class['template']->load($inf, 'admin_header');
		
		$orderTypeArray=$temp['orderTypeArray'];
		$orderServiceArray=$temp['orderServiceArray'];
// 		$orderSizeArray=$temp['orderSizeArray'];
		$orderStatusArray=$temp['orderStatusArray'];

		
		$body .= '
		<div class="message-info">
		<table class="table table-bordered table-hover table-striped" ><tr>
		<td>کد</td>
		<td>عنوان سفارش</td>
		<td>نوع سفارش </td> 
		<td>تاریخ ثبت </td>
		<td>تیراژ </td>
		<td>شماره تماس </td>
		<td>وضعیت </td>
		<td>جزییات</td>
		<td>سوابق</td> 
		</tr>';
        for ($i = 0; $i < count($tempOrders); $i++) 
		{
			$orderTitle='';
			$orderType='';
			$orderSize='';
			$orderStatus='';
			
				for($j = 0; $j < count($orderTypeArray); $j++)
				{
					$tempId=intval($tempOrders[$i]->typeId);
					$tempId2=intval($orderTypeArray[$j]['id']);
					if($tempId2 == $tempId)
						$orderType=$orderTypeArray[$j]['title'];
				}
			
				for($j = 0; $j < count($orderServiceArray); $j++)
				{
					$tempId=intval($tempOrders[$i]->serviceTypeId);
					$tempId2=intval($orderServiceArray[$j]['id']);
					if($tempId2 == $tempId)
						$serviceType=$orderServiceArray[$j]['title'];
				}
			
			
			for($j = 0; $j < count($orderStatusArray); $j++)
			{
				$tempId=intval($tempOrders[$i]->statusId);
				$tempId2=intval($orderStatusArray[$j]['id']);
				if($tempId2 == $tempId)
					$orderStatus=$orderStatusArray[$j]['status'];
			}
			
            $body .= '<tr id="' . ($i % 2 == 0 ? 'tr_even' : 'tr_odd') . '">' .
                '<td>' . $tempOrders[$i]->id . '</td>' .
                '<td>' . $serviceType . '</td>' .
                '<td>' . $orderType . '</td>' . 
                '<td>' . $tempOrders[$i]->createDate . '</td>' .
                '<td>' . $tempOrders[$i]->count . '</td>' .
                '<td>' . $tempOrders[$i]->ownerMobile . '</td>' .
                '<td>'.$orderStatus.'</td>' .
                '<td><a class="btn" href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderDetail/' . $tempOrders[$i]->id . '\'>نمايش</a></td>' ;
			
				$body .= '<td><a class="btn btn-primary " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewHistory/'.$tempOrders[$i]->id.'">مشاهده سوابق </a></td>' . '</tr>';	
				
        }
        //for
		$body .= '</table><br>';
		
		
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'orders/'.$directory.'/', $begin, $count);

        $body .= '<br><a class=" btn" href="'.GSMS::$class['template']->info['admin_url'].'" >برگشت</a></div>';

        $inf['title'] = $inf['page_title'] ;
        $inf['body'] = $body ;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
		
	}
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?>