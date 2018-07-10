<?php //allahoma sale ala mohammad va ale mohammad
 

class current
{
	function current($temp)
	{
		$pageType=$temp['type'];
		$directory = '';
		$inf = array('page_title' => 'ليست سفارش ها');
		if($pageType==1)
		{
			$tempTitle = 'لیست سفارش های در دست اجرا';
			$directory = 'currentOrders';
		}
		elseif ($pageType==2) 
		{
			$tempTitle = 'لیست سفارش های قبلی';
			$directory = 'prevOrders';
		}
		elseif ($pageType==3) 
		{
			$tempTitle = 'لیست سفارش های در صف انتظار';
			$directory = 'queueOrders';
		}
		elseif ($pageType==4) 
		{
			$tempTitle = 'لیست سفارش های تازه ثبت شده';
			$directory = 'newOrders';
		}
		elseif ($pageType==5) 
		{
			$tempTitle = 'لیست سفارش های تایید شده';
			$directory = 'acceptedOrders';
		}
		elseif ($pageType==6) 
		{
			$tempTitle = 'لیست سفارش های کاربر:' . $temp['customerName'];
			$id=$temp['id'];
			$directory = 'listOrdersByUser/'.$id;
		}
		
		$inf['activeTab']= 'orders';
		//-------------------
		$body = '';
		list($tempOrders, $begin, $count) = $temp['res'];
		
		if($temp==null || count($tempOrders) == 0)
		{
			GSMS::$class['template']->message('خطا','سفارشی يافت نشد.','admin',
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'orders'));
			return ;
		}
		
		GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'admin_header');
		$inf['title'] = $inf['page_title'] ;
		
		
		
		
		$orderTypeArray=$temp['orderTypeArray'];
		$serviceTypeArray=$temp['serviceTypeArray'];
// 		$orderSizeArray=$temp['orderSizeArray'];
		$orderStatusArray=$temp['orderStatusArray'];

		
		$body .= '
		<div class="table-responsive">
		<table class="table" >
		<thead class="text-primary">
		<th class="text-right" >کد</th>
		<th class="text-right">عنوان سفارش</th>
		<th class="text-right">نوع سفارش</th> 
		<th class="text-right">تاریخ ثبت</th>
		<th class="text-right">تیراژ</th>
		<th class="text-right">شماره تماس</th>
		<th class="text-right">وضعیت</th>
		<th class="text-right">تراکنش مالی</th>
		<th class="text-right">جزییات</th>
		'.
		($pageType == 1 ? '<th class="text-right">تکمیل</th>' : '')
		.'
		<th class="text-right">تغییر</th>
		</thead>
		<tbody>';
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

			
				for($j = 0; $j < count($serviceTypeArray); $j++)
				{
					$tempId=intval($tempOrders[$i]->serviceTypeId);
					$tempId2=intval($serviceTypeArray[$j]['id']);
					if($tempId2 == $tempId)
						$serviceType=$serviceTypeArray[$j]['title'];
				}

			
// 			for($j = 0; $j < count($orderSizeArray); $j++){
// 				$tempId=intval($tempOrders[$i]->sizeId);
// 				$tempId2=intval($orderSizeArray[$j]['id']);
// 				if($tempId2 == $tempId)
// 					$orderSize=$orderSizeArray[$j]['size'];
// 			}
			
			for($j = 0; $j < count($orderStatusArray); $j++)
			{
				$tempId=intval($tempOrders[$i]->statusId);
				$tempId2=intval($orderStatusArray[$j]['id']);
				if($tempId2 == $tempId)
					$orderStatus=$orderStatusArray[$j]['status'];
			}
			
            $body .= '
			<tr id="' . ($i % 2 == 0 ? 'tr_even' : 'tr_odd') . '">' .
                '<td>' . $tempOrders[$i]->id . '</td>' .
                '<td>' . $serviceType . '</td>' .
                '<td>' . $orderType . '</td>' . 
                '<td>' . $tempOrders[$i]->createDate . '</td>' .
                '<td>' . $tempOrders[$i]->count . '</td>' .
                '<td>' . $tempOrders[$i]->ownerMobile . '</td>' .
                '<td>' . $orderStatus . '</td>' .
                '<td><a class="btn btn-success btn-sm" href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderFinancialDetail/' . $tempOrders[$i]->id . '\'>نمايش</a></td>
				<td><a class="btn btn-primary btn-sm" href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderDetail/' . $tempOrders[$i]->id . '\'>نمايش</a></td>' ;
			if($pageType == 1 )
				$body .= '<td><a  class="btn btn-success btn-sm" href=\''.GSMS::$class['template']->info['admin_url'].'orders/completeOrder/' 
					. $tempOrders[$i]->id . '\'>تکمیل</a></td>' .
					'<td><a  class="btn btn-primary btn-sm" href=\''.GSMS::$class['template']->info['admin_url'].'orders/changeOrderStatus/' 
					. $tempOrders[$i]->id . '\'>تغییر وضعیت</a></td>' . '</tr>';	
			elseif($pageType == 4 )
				$body .= '<td><a class="btn btn-success btn-sm" href=\''.GSMS::$class['template']->info['admin_url'].'orders/acceptOrder/' 
					. $tempOrders[$i]->id . '\'>تایید سفارش </a></td>' . '</tr>';
			elseif($pageType == 2)
				$body .= '<td><a class="btn btn-primary btn-sm" href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewHistory/'.$tempOrders[$i]->id.'">مشاهده سوابق </a></td>' . '</tr>';	
			elseif($pageType == 5 )
				$body .= '<td><a class="btn btn-success btn-sm" href=\''.GSMS::$class['template']->info['admin_url'].'orders/startOrder/' 
					. $tempOrders[$i]->id . '\'>شروع انجام </a></td>' . '</tr>';
			else 
				$body .= '<td><a  class="btn btn-primary btn-sm" href=\''.GSMS::$class['template']->info['admin_url'].'orders/changeOrderStatus/' 
					. $tempOrders[$i]->id . '\'>تغییر وضعیت</a></td>' . '</tr>';		
        }
        //for
		$body .= '</tbody></table><br>';
		
		
		
		
		
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'orders/'.$directory.'/', $begin, $count);
		

        $body .= '</div>';
		 $inf = array('title' => $tempTitle, 'body' => $body);
        //$inf['body'] = $body ;
        //GSMS::$class['template']->index($inf);
        //GSMS::$class['template']->footer($inf);
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
	}
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?>