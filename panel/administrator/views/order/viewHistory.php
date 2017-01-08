<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class viewHistory
{
	function viewHistory($temp)
	{
		
		 
		$body = ''; 
		 
		if($temp==null || count($temp) == 0)
		{
			GSMS::$class['template']->message('اطلاعات سفارش يافت نشد' ,'اطلاعات سفارش يافت نشد .' , 'employ');
            return;
		}
	 
		$body  = '
		<div class="message-info">
		
		
		
		<table class="table table-bordered table-hover table-striped" ><tr>
		<td>#</td>
		<td>سفارش </td>
		<td>زمان</td>
		<td>اپراتور</td> 
		<td>تغییر </td>
		<td>شرح </td> 
		</tr>';
		 $body .= '<tr>' .
                '<td>0</td>' . 
                '<td><a href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderDetail/' .
				$temp[0]['order_id']  . '\'>'.$temp[0]['oname'].'</a></td>' .
                '<td dir="ltr">' . $temp[0]['create_date'] . '</td>' .
                '<td>' . $temp[0]['name']. ' ' . $temp[0]['family'] . '</td>' .
                '<td>ثبت اولیه شد</td>' .
                '<td></td>' .
                '</tr>';
        for ($i = 0; ($i < count($temp)) && (intval($temp[$i]['id'])>0) ; $i++) 
		{ 
            $body .= '<tr>' .
                '<td>' . $temp[$i]['id'] . '</td>' . 
                '<td><a href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderDetail/' .
				$temp[$i]['order_id']  . '\'>'.$temp[$i]['oname'].'</a></td>' .
                '<td dir="ltr">' . $temp[$i]['datetime'] . '</td>' .
                '<td>' . $temp[$i]['name']. ' ' . $temp[$i]['family'] . '</td>' .
                '<td>' . $temp[$i]['status'] . '</td>' .
                '<td>' . $temp[$i]['work_description'].     '</td>' .
                '</tr>';
        }
        //for
		$body .= '</table><br>';
		$body .= '<a  class="btn btn-primary" href=\''.
					GSMS::$class['template']->info['admin_url'].'orders/changeOrderStatus/' 
					. $temp[0]['order_id'] . '\'>ثبت وضعیت جدید</a>' ;
					
		// $body .= GSMS::$class['template']->paging(
            // GSMS::$class['template']->info['admin_url'] . 'advisor/listAdvisor/', $begin, $count);

        $body .= '</div>';

		GSMS::$class['template']->message('ليست سفارش ها' ,$body  , 'employ' ,false );
		
	}
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?>