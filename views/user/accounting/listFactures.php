<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listFactures
{
	
    function listFactures($tempFacture)
    {
		$inf = array(
			'page_title' => 'لیست صورت حساب های مالی',
			'activeTab' => 'accounting'
		);
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		//$itemCount = $tempFacture['count'];
		list($factures, $begin, $itemCount) = $tempFacture['facture'];
		//var_dump($factures);
		if ($itemCount == 0) 
		{
            $body .= 'صورت حساب وجود ندارد.<br>';
 
            GSMS::$class['template']->message(
				'لیست صورت حساب های مالی' ,		//title
				$body,					//body
				'user',					//part
				'alert alert-warning',	//css class
				true,					//format output
				false,						//return button
				array('activeTab'=>'accounting')); //extra argument 
			return;
        }
		
        $body = '';
        $body .= '
		<div class="message-info">	
		<table class="table table-border">
			<thead class="text-primary">
				<th class="text-right">ردیف</th>
				<th class="text-right">شماره سفارش کاربر</th> 
				<th class="text-right">شماره صورتحساب </th>
				<th class="text-right">تاریخ صورتحساب </th>
				<th class="text-right">تاریخ سررسید </th>
				<th class="text-right">جمع مبلغ کل فاکتور</th>
				<th class="text-right">وضعیت</th>
				<th class="text-right">نمایش صورتحساب</th>
			</thead>';
		if (count($factures) == 0) 
		{
            $body .= '<tr>صورتحسابی برای شما صادر نشده است</tr></div> ';

            
            GSMS::$class['template']->message(
				'لیست صورت حساب های مالی' ,		//title
				$body,					//body
				'user',					//part
				'alert alert-warning',	//css class
				false,					//format output
				false,						//return button
				array('activeTab'=>'accounting')); //extra argument
            return;
        }
		else 
		{
			for ($i = 0; $i < count($factures); $i++) 
			{
				$body .= 
					'<tr >' .
						'<td>' . ($i+1) . '</td>' .
						'<td>' . $factures[$i]->userorderid. '</td>' .
						'<td>' . $factures[$i]->id. '</td>' .
						'<td>' . $factures[$i]->insertDate. '</td>' .
						'<td>' . $factures[$i]->dateDue. '</td>' .
						'<td>' .number_format( $factures[$i]->totalAmount) . ' ريال</td>' ;
					if(( intval($factures[$i]->totalAmount)-intval($factures[$i]->recieve))>0)
						$body .='<td><span class="text-danger">پرداخت نشده</span></td>' ;
					else
						$body .='<td><span class="text-success">پرداخت شد</span></td>' ;
			 $body .=	'</td>
						 <td><a class="btn btn-info btn-sm" href="'.
						 GSMS::$class['template']->info['user_url'] .'accounting/viewFacture/' . $factures[$i]->id . '">
						 <i class="material-icons">dvr</i>
						 نمايش</a></td>
						 </tr > ';
			}
			//for
		}
        
		$body .='</tbody></table>';
		$body .= GSMS::$class['template']->paging(
			GSMS::$class['template']->info['user_url'] .'accounting/listFactures/', $begin, $itemCount);
		$body .='</div>'; 
		$inf = array(
			'title' => 'لیست صورت حساب های مالی',
			'body' => $body
		);
		GSMS::$class['template']->load($inf, 'user_index');
		GSMS::$class['template']->load($inf, 'user_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
