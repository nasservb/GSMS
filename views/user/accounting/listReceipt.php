<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listReceipt
{
	
    function listReceipt($tempReceipt)
    {
		$inf = array(
			'page_title' => 'لیست فیش های واریزی',
			'activeTab' => 'accounting'
		);
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		
		$receipts = $tempReceipt['res'][0];
		$itemCount = $tempReceipt['res'][2];
		$begin = $tempReceipt['res'][1];
		
        $body = '';
        if (count($receipts) == 0) 
		{
            $body .= ' فیش واریزی وجود ندارد <br>';
 
            GSMS::$class['template']->message(
							'لیست فیش های واریزی ' ,		//title
							$body,					//body
							'user',					//part
							'alert alert-warning',	//css class
							true,					//format output
							false,						//return button
							array('activeTab'=>'accounting')); //extra argument 
            return;
        }
      
        
        $body .= '
		<div class="message-info">
	
		<br/>
		
		<table dir="rtl" class="table table-border">
			<thead class="text-primary">
				<th class="text-right" >ردیف</th>
				<th class="text-right" >شماره فیش</th>
				<th class="text-right" >نحوه ی واریز</th>
				<th class="text-right" >نام شخص /شرکت واریز کننده </th>
				<th class="text-right" >مبلغ واریزی (ریال)</th>
				<th class="text-right" >تاریخ واریز  </th>
				<th class="text-right" >وضعیت</th>
				<th class="text-right" >نمايش </th>
			</thead>
			<tbody>';
		if (count($receipts) == 0) 
		{
            $body .= '<tr> موردی یافت نشد</tr></table></div>';
 
            GSMS::$class['template']->message(
							'لیست فیش های واریزی ' ,		//title
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
			for ($i = 0; $i < count($receipts); $i++) 
			{
			   $inf['balanceType'] = R::getAll('SELECT id,name FROM  balance_type where id='.$receipts[$i]->manualtransTypeId);
	 		
				$body .= 
				'<tr >
					 <td>' . ($i+1) . '</td>' .
					'<td>' . $receipts[$i]->refNum . '</td>' .
					'<td>' . $inf['balanceType'][0]['name'] . '</td>' .
					'<td>' . $receipts[$i]->name . '</td>' .
					'<td>' . number_format($receipts[$i]->totalAmount) . '</td>' .
					'<td>' . $receipts[$i]->dateDeposit . '</td>' .
				
					'<td> 
						<span style="color:' . 
							($receipts[$i]->isRead>0 ? '#9AF903"> خوانده شد' : '#FB5A5A">خوانده نشده' )
					         . '</span> |
						<span style="color:' . 
							($receipts[$i]->isAccept>0 ? '#9AF903"> تایید' : '#FB5A5A">عدم تایید' )
					         . '</span> ' .
			
                       '<td>
							<a class="btn btn-info btn-sm" href="'. GSMS::$class['template']->info['user_url'].'accounting/viewReceipt/' . $receipts[$i]->id . '"><i class="material-icons">dvr</i>نمايش</a>
						</td>
			       	</tr>';
			}
			//for
		}
		
        $body .= '</tbody></table><br>';
		$body .='</tbody></table>';
			
		$body .= GSMS::$class['template']->paging(
			GSMS::$class['template']->info['user_url'] .'accounting/listReceipt/', $begin, $itemCount);
							
		$body .='</div>';
		
		$inf = array(
			'title' => 'لیست فیش های واریزی',
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
