<?php //allahoma sale ala mohammad va ale mohammad
 

class ready
{
	function ready($temp)
	{
		$pageType=$temp['type'];
		$inf=array();
		
		$directory = '';
		
		$inf = array('page_title' => 'لیست سفارش های آماده تحویل','activeTab' => 'orders');
		$directory = 'readyOrder';
		
		
		
		//-------------------
		$body = '';
		list($tempOrders, $begin, $count) = $temp['res'];
		
		if($temp==null || count($tempOrders) == 0)
		{
			GSMS::$class['template']->message('اطلاعات سفارش يافت نشد' ,'اطلاعات سفارش يافت نشد .' , 'admin');
            return;
		}
		GSMS::$class['template']->header($inf);
		
        GSMS::$class['template']->load($inf, 'panel_header');
		
		$orderTypeArray=$temp['orderTypeArray'];
		$orderTitleArray=$temp['orderTitleArray'];
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
		<td>تغییر</td>
		</tr>';
        for ($i = 0; $i < count($tempOrders); $i++) 
		{
			$orderTitle='';
			$orderType='';
			$orderSize='';
			$orderStatus='';
			if(intval($tempOrders[$i]->typeId)>0)
			{
				for($j = 0; $j < count($orderTypeArray); $j++)
				{
					$tempId=intval($tempOrders[$i]->typeId);
					$tempId2=intval($orderTypeArray[$j]['id']);
					if($tempId2 == $tempId)
						$orderType=$orderTypeArray[$j]['title'];
				}

			}
			else 
			{
				for($j = 0; $j < count($orderTitleArray); $j++)
				{
					$tempId=intval($tempOrders[$i]->titleId);
					$tempId2=intval($orderTitleArray[$j]['id']);
					if($tempId2 == $tempId)
						$orderType=$orderTitleArray[$j]['title'];
				}

			}
			
			 
			
            $body .= '<tr id="' . ($i % 2 == 0 ? 'tr_even' : 'tr_odd') . '">' .
                '<td>' . $tempOrders[$i]->id . '</td>' .
                '<td>' . $tempOrders[$i]->name . '</td>' .
                '<td>' . $orderType . '</td>' . 
                '<td>' . $tempOrders[$i]->createDate . '</td>' .
                '<td>' . $tempOrders[$i]->count . '</td>' .
                '<td>' . $tempOrders[$i]->ownerMobile . '</td>' .
                '<td>آماده تحویل</td>' .
                '<td><a class="btn" href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderDetail/' . $tempOrders[$i]->id . '\'>نمايش</a></td>' ;
			
				$body .= '<td><a  class="btn btn-primary" href=\''.GSMS::$class['template']->info['admin_url'].'orders/changeOrderStatus/' 
					. $tempOrders[$i]->id . '\'>تغییر وضعیت</a></td>' . '</tr>';
        }
        //for
		$body .= '</table><br>';
		
		
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'orders/'.$directory.'/', $begin, $count);

        $body .= '<br><a class=" btn" href="'.GSMS::$class['template']->info['admin_url'].'" >برگشت</a></div>';

        $inf['title'] = $inf['page_title'] ;
        $inf['body'] = $body ;
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
		
	}
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?>