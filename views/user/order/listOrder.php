<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listOrder
{
	function listOrder($temp)
	{
		$pageType=$temp['type'];
		$controllers = '' ; 
		 
		if($pageType==1)
		{
			$inf = array('page_title' => 'لیست سفارش های در دست اجرا');
			$controllers = 'currentOrders' ; 
		}
		elseif ($pageType==2) 
		{
			$inf = array('page_title' => 'لیست سفارش های قبلی');
			$controllers = 'prevOrders' ; 
		}
		elseif ($pageType==3) 
		{
			$inf = array('page_title' => 'لیست سفارش های در صف انتظار');
			$controllers = 'queueOrders' ; 
		}
		elseif ($pageType==4) 
		{
			$inf = array('page_title' => 'لیست سفارش های جدید');
			$controllers = 'newOrders';
		}
		elseif ($pageType==5) 
		{
			$inf = array('page_title' => 'لیست همه سفارش ها');
			$controllers = 'allOrders';
		}
		elseif ($pageType==6) 
		{
			$inf = array('page_title' => 'لیست سفارش های تکمیل شده');
			$controllers = 'compeletedOrders';
		}
		elseif ($pageType==7) 
		{
			$inf = array('page_title' => 'لیست سفارش های تایید مالی شده');
			$controllers = 'consideredOrder';
		}
		elseif ($pageType==8) 
		{
			$inf = array('page_title' => 'لیست سفارش های آماده تحویل');
			$controllers = 'readyOrder';
		}
		elseif ($pageType==9) 
		{
			$inf = array('page_title' => 'لیست سفارش های تایید شده برای انجام');
			$controllers = 'acceptedOrders';
		}
		
		$body = '';



		list($tempOrders, $begin, $count) = $temp['res'];

		if($temp==null || (count($tempOrders) == 0) )
		{			 
            GSMS::$class['template']->message('اطلاعات سفارش يافت نشد' ,'اطلاعات سفارش يافت نشد .' , 'user');
            return;
		} 
		$inf['activeTab']='orders';
		
		GSMS::$class['template']->header($inf);
		
        GSMS::$class['template']->load($inf, 'user_header');
		
		$services=$temp['services'];
		$serviceType=$temp['serviceType'];

		$orderStatusArray=$temp['orderStatusArray'];

		
		$body .= '
		<div class="message-info">
		<table class="table  table-hover" >
		<thead class="text-primary">
		<th class="text-right" >کد</th>
		<th class="text-right" >نوع  فرم</th>
		<th class="text-right" >عنوان سفارش</th>
		<th class="text-right" >تاریخ ثبت</th>
		<th class="text-right" >تیراژ </th>
		<th class="text-right" >وضعیت </th>
		<th class="text-center" ><i class="material-icons">visibility</i></th>
		<th class="text-center" ><i class="material-icons">edit</i></th>
		</thead>';
		
        for ($i = 0; $i < count($tempOrders); $i++) 
		{
			$orderTitle='';
			$orderType='';
			$orderSize='';
			$orderStatus='';
			
			for($j = 0; $j < count($services); $j++)
			{
				if(intval($tempOrders[$i]->subServiceId) == intval($services[$j]['id']))
					$orderTitle=$services[$j]['title'];
			}
			
			for($j = 0; $j < count($serviceType); $j++)
			{
				if(intval($tempOrders[$i]->serviceTypeId)== intval($serviceType[$j]['id']))
					$orderType=$serviceType[$j]['title'];
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
                '<td>' . $orderType . '</td>' .
                '<td>' . $orderTitle . '</td>' .
                '<td>' . $tempOrders[$i]->createDate . '</td>' .
                '<td>' . $tempOrders[$i]->count . ' سری </td>' .
                '<td>' . $orderStatus . '</td>' .
                '<td class="text-center"><a class="btn btn-success btn-sm" href=\''.GSMS::$class['template']->info['user_url'].'orders/viewOrderDetail/' . $tempOrders[$i]->id . '\'>نمايش</a></td>' .
                '<td class="text-center"><a class="btn btn-primary btn-sm '.( $tempOrders[$i]->isOrederEditable() ? '' : 'disabled' ).' " href=\''.GSMS::$class['template']->info['user_url'].
                ($tempOrders[$i]->typeId ==1 ? 'orders/orderRegister/' :  'orders/taxOrderRegister/')
                

                . $tempOrders[$i]->id . '\'>ویرایش</a></td>' .
                '</tr>';
        }
		$body .= '</table><br>';
		
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] .
			'orders/'.$controllers.'/', $begin, $count);

        $body .= '</div>';

        $inf = array('title' => 'ليست سفارش ها', 'body' => $body);
        GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
		
	}
}

if (!defined("GSMS")) 
{
    exit("Access denied");
}
?>