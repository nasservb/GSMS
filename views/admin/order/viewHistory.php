<?php //allahoma sale ala mohammad va ale mohammad
 

class viewHistory
{
	function viewHistory($temp)
	{
		$pageTitle = 'سوابق سفارش';
		$inf['title'] = $pageTitle;
		$inf['page_title'] = $pageTitle;
		$inf['activeTab'] =  'orders';
		GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'admin_header');
		
		$body = ''; 
		 
		if($temp==null || count($temp) == 0)
		{
			//GSMS::$class['template']->message('اطلاعات سفارش يافت نشد' ,'اطلاعات سفارش يافت نشد .' , 'admin');
            $body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">اطلاعات سفارش يافت نشد.</div>';
			$inf['body'] = $body ;
			GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');
            return;
		}
	 
		$body  = '
		<div class="message-info">
		
		
		<div class="row col-sm-12 pull-right table-responsive">
		<table class="table" >
		<thead class="text-primary">
		<th class="text-right">شماره</th>
		<th class="text-right">سفارش </th>
		<th class="text-right">زمان</th>
		<th class="text-right">اپراتور</th> 
		<th class="text-right">تغییر </th>
		<th class="text-right">شرح </th> 
		</thead>';
		
		$j= 1;
        for ($i = 0; ($i < count($temp)) && (intval($temp[$i]['id'])>0) ; $i++) 
		{ 
            $body .= '<tr>' .
                '<td>' . $j . '</td>' . 
                '<td><a href=\''.GSMS::$class['template']->info['admin_url'].'orders/viewOrderDetail/' .
				$temp[$i]['order_id']  . '\'>'.$temp[$i]['oname'].'</a></td>' .
                '<td>' . $temp[$i]['datetime'] . '</td>' .
                '<td>' . $temp[$i]['name']. ' ' . $temp[$i]['family'] . '</td>' .
                '<td>' . $temp[$i]['status'] . '</td>' .
                '<td>' . $temp[$i]['work_description'].     '</td>' .
                '</tr>';
			$j++;
        }
        //for
		$body .= '</table></div>';
		$body .= '<div class="row">
		<a  class="btn btn-primary" href=\''.
					GSMS::$class['template']->info['admin_url'].'orders/changeOrderStatus/' 
					. $temp[0]['order_id'] . '\'>ثبت وضعیت جدید</a>
		</div>' ;
					
		// $body .= GSMS::$class['template']->paging(
            // GSMS::$class['template']->info['admin_url'] . 'advisor/listAdvisor/', $begin, $count);

        $body .= '</div>';

		//GSMS::$class['template']->message('سوابق سفارش' ,$body  , 'admin' ,false );
		$inf['body'] = $body ;
		
		
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
		
	}
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?>