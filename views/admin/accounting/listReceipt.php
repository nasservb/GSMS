<?php //allahoma sale ala mohammad va ale mohammad
 

class listReceipt
{
	
    function listReceipt($temp)
    {
		$pageType=$temp['type'];
		$directory = '';
		if($pageType==1){
			$inf = array('page_title' => 'لیست فیش های واریزی تایید شده');
			$directory = 'listAcceptedReceipts';
		}
		else if($pageType==2){
			$inf = array('page_title' => 'لیست فیش های واریزی تایید نشده');
			$directory = 'listNotAcceptedReceipts';
		}
        //---------------initializing-----------
		$inf['activeTab'] ='accounting' ;
        GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf,'admin_header');
		$inf['title'] = $inf['page_title'] ;
        //------------------------
        
		//var_dump($temp);
		list($tempReceipt, $begin, $count) = $temp['res'];
        $body = '';
        if ($count == 0) {
            $body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">فعلا فیش واریزی وجود ندارد</div>';
			$inf['body'] = $body ;
            GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');	
            return;
        }
      
        
		if (count($tempReceipt) == 0) 
		{
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">فعلا فیش واریزی وجود ندارد</div>';
			$inf['body'] = $body ;
            GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');	
            return;
        }
		else 
		{
			$body .= '
			<div class="table-responsive">
			<table class="table table-bordered">
			<thead class="text-primary">
			<th class="text-right" >کد</th>
			<th class="text-right" >شماره فیش</th>
			<th class="text-right" >نحوه ی واریز</th>
			<th class="text-right" >واریز کننده</th>
			<th class="text-right" >مبلغ واریزی (ریال)</th>
			<th class="text-right" >نام بانک </th>  
			<th class="text-right" >کد شعبه </th> 
			<th class="text-right" >تاریخ واریز</th>
			<th class="text-right" >واریز به شماره حساب</th>
			<th class="text-right" >وضعیت</th>
			<th class="text-right" >نمايش </th>
			</thead>
			<tbody>';
			for ($i = 0; $i < count($tempReceipt); $i++) 
			{
				$inf['balanceType'] = R::getAll('SELECT id,name FROM  balance_type where id='.$tempReceipt[$i]->manualtransTypeId);
				$body .= '<tr >' .
					'<td>' . $tempReceipt[$i]->id . '</td>' .
					'<td>' . $tempReceipt[$i]->refNum . '</td>' .
					'<td>' . $inf['balanceType'][0]['name'] . '</td>' .
					'<td>' . $tempReceipt[$i]->name . '</td>' .
					'<td>' . $tempReceipt[$i]->totalAmount . '</td>' .
					'<td>' . $tempReceipt[$i]->nameBank . '</td>' .
					'<td>' . $tempReceipt[$i]->branchCode . '</td>' .
					'<td>' . $tempReceipt[$i]->dateDeposit . '</td>' .
					'<td>' . $tempReceipt[$i]->depositAccountnum . '</td>' .
				
					'<td ' . ($tempReceipt[$i]->isRead>0 ? ' class="text-success"> خوانده شده' : ' class="text-danger"> خوانده نشده' )
					         . '|
					<span ' . ($tempReceipt[$i]->isAccept>0 ? ' class="text-success"> تایید' : ' class="text-danger"">عدم تایید' )
					. '</span> </td>' .
					'<td><a class="btn btn-primary" href="'. GSMS::$class['template']->info['admin_url'].'accounting/viewReceipt/' . $tempReceipt[$i]->id . '">نمايش</a></td>
					</tr>';
			}
			//for
		}
        
        $body .= '</tbody></table>';
		
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'accounting/'.$directory.'/', $begin, $count);

		//$body .='<a class="back_btn" href="javascript:window.history.back()">برگشت</a>	
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
