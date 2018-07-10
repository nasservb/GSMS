<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listTransBalance
{
	
    function listTransBalance($tempBalance)
    {
		  
/*

کوئری ها منتقل شود به کنترلر و با پارامتر ارسال شود . 
در ویوو کوئری زدن مجاز نیست و باعث پیچیدگی می شود.
*/
        $body = '';
        if (count($tempBalance['count']) == 0) 
		{
            $body .= 'تراکنشی يافت نشد';

			GSMS::$class['template']->message(
							' ليست تراکنش ها' ,		//title
							$body,					//body
							'user',					//part
							'alert alert-warning',	//css class
							true,					//format output
							true,						//return button
							array('activeTab'=>'accounting')); //extra argument	
            return;
        }
      
        
        $body .= '
		<div class="message-info">
	
		<br/>
		
		<table dir="rtl" class="table table-striped   table-hover">
			<tr>
				<td>شماره</td>
				<td>نوع تراکنش </td>
				<td>مبلغ دریافتی (ریال)</td>
				<td>مبلغ واریزی (ریال)</td>
				<td>کد پیگیری</td>  
				<td>کد سفارش </td> 
				<td>شماره فیش بانکی </td>
				<td>تاریخ تراکنش</td>
				<td>وضعیت</td>
				<td>نمايش </td>
			</tr>';
		if (count($tempBalance['balance']) == 0) 
		{
            $body .= '<tr>تراکنشی يافت نشد</tr></table></div>';

			GSMS::$class['template']->message(
							' ليست تراکنش ها' ,		//title
							$body,					//body
							'user',					//part
							' ',	//css class
							false,					//format output
							true,						//return button
							array('activeTab'=>'accounting')); //extra argument
            return;
        }
		else 
		{
			for ($i = 0; $i < count($tempBalance['balance']); $i++) 
			{
				//$inf['balanceType'] = R::getAll('SELECT * FROM  balance_type where id='.$tempBalance['balance'][$i]['balance_type_id']);

				$body .= 
				'<tr >' .
					'<td>' . $i . '</td>' .
					'<td>' . $tempBalance['balance'][$i]['balanceTypeName'] . '</td>' .
					'<td>' . $tempBalance['balance'][$i]['recive'] . '</td>' .
					'<td>' . $tempBalance['balance'][$i]['pay'] . '</td>' .
					'<td>';
					if($tempBalance['balance'][$i]['intransactionid']!=null)
					 {
							$inf['internetTransaction'] = R::getAll('SELECT * FROM  internet_transaction where id='.$tempBalance['balance'][$i]['intransactionid']);
					 
							$body .='<span style="color:' . ($inf['internetTransaction'][0]['ref_num']>0 ? '#9AF903">' .$inf['internetTransaction'][0]['ref_num'].'' : '#FB5A5A">تولید نشده') 
					         . '</span>'
						;
					 }
					 $body .='</td>'.'<td>';
				  if ($tempBalance['balance'][$i]['userorderid']!=null)
					  {
							$inf['userorder'] = 
									R::getAll('SELECT * FROM  userorder where id='.$tempBalance['balance'][$i]['userorderid']);
							$body .='<span style="color:' . ($inf['userorder'][0]['id']>0 ? '#9AF903">' .$inf['userorder'][0]['id'].'' : '#FB5A5A">وجود ندارد') 
					         . '</span>'
							 ;
					  }
					   $body .= '</td>'.'<td>';
				    if ($tempBalance['balance'][$i]['untransactionid']!=null)
					  {
						 $inf['manualtransaction'] = R::getAll('SELECT * FROM  manualtransaction where id='.$tempBalance['balance'][$i]['untransactionid']);
						
						$body .='<span style="color:' . ($inf['manualtransaction'][0]['ref_num']>0 ? '#9AF903">' .$inf['manualtransaction'][0]['ref_num'].'' : '#FB5A5A">وجود ندارد') 
					         . '</span>'
						 ;
					  }
					  $body .='</td>';
					$body .='<td>' . $tempBalance['balance'][$i]['insert_date'] . '</td>' . 
					'<td>';

						
						 if ($tempBalance['balance'][$i]['userorderid']!=null){
							 $inf['userorder'] = 
									R::getAll('SELECT * FROM  userorder where id='.$tempBalance['balance'][$i]['userorderid']);
									
							 $body .='<span style="color:' . ($inf['userorder'][0]['is_accept']>0 ? '#9AF903"> فاکتور صادر و تایید شده است' : '#FB5A5A">فاکتور صادر شده در انتظار تایید' )
					         . '</span>';
							 
						 }
						 else
						 {
								 $body .='<span style="color:#FB5A5A">در انتظار صدور فاکتور</span>'; 
						 }
				if($tempBalance['balance'][$i]['balance_type_id']>=6)		 
				{	
			           $body .=	'
							</td>
							<td>
								<a class="btn btn-info" href="'.
									GSMS::$class['template']->info['user_url'] .'accounting/viewReceipt/' . 
									$tempBalance['balance'][$i]['untransactionid'] . '"><i class="material-icons">dvr</i>نمايش</a>
							</td>
			       		</tr>';
				}
				else
				{
					$body .=	'
						</td>
						<td>
							<a class="btn btn-info" href="'.
								GSMS::$class['template']->info['user_url'] .'accounting/viewBalance/' . $tempBalance['balance'][$i]['id'] . '"><i class="material-icons">dvr</i>نمايش</a>
						</td>
			       	</tr>';
				}
			}
			//for
		}
        
        $body .= '</table><br>';
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'accounting/listBalance/', 
			$tempBalance['begin'], $tempBalance['count']);
 	
		$body .='</tbody></table></div> '; 
		
		
        GSMS::$class['template']->message(
							'ليست تراکنش های مالی ' ,		//title
							$body,					//body
							'user',					//part
							' ',	//css class
							false,					//format output
							true,						//return button
							array('activeTab'=>'accounting')); //extra argument;
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
