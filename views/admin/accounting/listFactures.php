<?php //allahoma sale ala mohammad va ale mohammad
 

class listFactures
{
    function listFactures($temp)
    {
		$pageType=$temp['type'];
		$directory = '';
		if($pageType==1)
		{
			$inf = array('page_title' => 'لیست فاکتورهای پرداخت نشده');
			$directory = 'listNotPaidFactures';
		}
		else if($pageType==2)
		{
			$inf = array('page_title' => 'لیست فاکتورهای پرداخت شده');
			$directory = 'listPaidFactures';
		}
		else if($pageType==3)
		{
			$inf = array('page_title' => 'لیست فاکتورهای تایید شده');
			$directory = 'listAcceptedFactures';
		}
		else if($pageType==4)
		{
			$inf = array('page_title' => 'لیست فاکتورهای تایید نشده');
			$directory = 'listNotAcceptedFactures';
		}
        //---------------initializing-----------
		$inf['activeTab']='accounting';
        GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf,'admin_header');
        //------------------------
		
		$inf['title'] = $inf['page_title'] ;
        list($tempFacture, $begin, $count) = $temp['res'];
		$body = '';
		if ($count == 0) {
            $body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">فعلا فاکتوری وجود ندارد</div>';
			$inf['body'] = $body ;
            GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');	
            return;
        }
      
        
		if (count($tempFacture) == 0) 
		{
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">فعلا فاکتوری وجود ندارد</div>';
			$inf['body'] = $body ;
            GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');	
            return;
        }
		
        $body .= '
		<div class="table-responsive">
		<table class="table table-bordered">
		<thead class="text-primary">
		<th class="text-right" >ردیف</th>
		<th class="text-right" >شماره سفارش کاربر</th> 
		<th class="text-right" >شماره صورتحساب </th>
		<th class="text-right" >تاریخ صورتحساب </th>
		<th class="text-right" >تاریخ سررسید </th>
		<th class="text-right" >جمع مبلغ کل فاکتور</th>
		<th class="text-right" >وضعیت</th>
		<th class="text-right" >نمایش فاکتور</th>
		</thead>
		<tbody>';
		
		for ($i = 0; $i < count($tempFacture); $i++) 
		{
			$body .= '<tr>' .
			'<td>' . ($i+1) . '</td>' .
			'<td>' . $tempFacture[$i]->userorderid. '</td>' .
			'<td>' . $tempFacture[$i]->id. '</td>' .
			'<td>' . $tempFacture[$i]->insertDate. '</td>' .
			'<td>' . $tempFacture[$i]->dateDue. '</td>' .
			'<td>' . $tempFacture[$i]->totalAmount . '</td>
			<td>' ;
			if( $tempFacture[$i]->isaccept > 0)
			{
				$body .='<span class="text-success">تایید شده</span>' ;
			}
			else
			{
				$body .='<span class="text-danger">تایید نشده</span>' ;			
			}
			$body .='</td>
			<td><a class="btn btn-primary" href="'.GSMS::$class['template']->info['admin_url'] .'accounting/viewFacture/' . $tempFacture[$i]->id . '">نمايش</a></td>
			</tr > ';
		}
			//for
		
        
        $body .= '</tbody></table><br>';
		
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'accounting/'.$directory.'/', $begin, $count);
		
		$body .='</div>';

        $inf['body'] = $body ;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
