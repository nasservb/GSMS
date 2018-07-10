<?php //allahoma sale ala mohammad va ale mohammad
 

class completed
{
	function completed($temp)
	{
		$pageType=$temp['type'];
		$inf=array();
		
		$directory = '';
		
		$inf = array('page_title' => 'لیست سفارش های تکمیل  شده','activeTab' => 'orders');
			$directory = 'completedOrder';
		
		
		
		//-------------------
		$body = '';
		list($tempOrders, $begin, $count) = $temp['res'];
		
		GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'admin_header');
		$inf['title'] = $inf['page_title'] ;
		
		if($temp==null || count($tempOrders) == 0)
		{
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">سفارشی يافت نشد</div>';
			$inf['body'] = $body ;
			GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');
            return;
		}
		
		$orderTypeArray=$temp['orderTypeArray'];
		$orderTitleArray=$temp['orderTitleArray'];
// 		$orderSizeArray=$temp['orderSizeArray'];
		$orderStatusArray=$temp['orderStatusArray'];

		
		$body .= '
		<div class="table-responsive">
		<table class="table" >
		<thead class="text-primary">
		<th class="text-right">کد</th>
		<th class="text-right">عنوان سفارش</th>
		<th class="text-right">نوع سفارش </th> 
		<th class="text-right">تاریخ ثبت </th>
		<th class="text-right">تیراژ </th>
		<th class="text-right">شماره تماس </th>
		<th class="text-right">وضعیت </th>
		<th class="text-right">تراکنش مالی</th>
		<th class="text-right">جزییات</th>
		<th class="text-right">سوابق</th>
		</thead>
		<tbody>';
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
                '<td>تکمیل شده</td>' .
				'<td><a class="btn btn-success" href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderFinancialDetail/' . $tempOrders[$i]->id . '\'>نمايش</a></td>
                <td><a class="btn btn-primary" href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderDetail/' . $tempOrders[$i]->id . '\'>نمايش</a></td>' ;
			
				$body .= '<td><a class="btn btn-success " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewHistory/'.$tempOrders[$i]->id.'">مشاهده سوابق </a></td>' . '</tr>';	
				
        }
        //for
		$body .= '</tbody></table><br>';
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'orders/'.$directory.'/', $begin, $count);
		
        $body .= '</div>';
		
        $inf['body'] = $body ;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
		
	}
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?>