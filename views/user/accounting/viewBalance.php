<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class viewBalance
{
    function viewBalance($tempBalance)
    {
         
        $body = '';
      
    /*

کوئری ها منتقل شود به کنترلر و با پارامتر ارسال شود . 
در ویوو کوئری زدن مجاز نیست و باعث پیچیدگی می شود.
*/     
        $body .= '
		<div class="message-info">
		<table dir="rtl" class="table table-striped   table-hover">
		
		<tr><td>شماره</td><td>'.$tempBalance['balance']['id'].'</td></tr>
		<tr><td>نام</td><td>'.$tempBalance['admin']->name . ' ' . $tempBalance['admin']->family.'</td></tr>
		<tr><td>نوع تراکنش</td><td>واریز وجه آنلاین</td></tr>
		<tr><td>کد پیگیری</td><td>';
		  if($tempBalance['balance']['intransactionid']!=null)
					 {
							$inf['internetTransaction'] = R::getAll('SELECT * FROM  internet_transaction where id='.$tempBalance['balance']['intransactionid']);
					 
						$body .='<span style="color:' . ($inf['internetTransaction'][0]['ref_num']>0 ? '#9AF903">' .$inf['internetTransaction'][0]['ref_num'].'' : '#FB5A5A">تولید نشده') 
					         . '</span>'
						;
					 }
		 $body .= '</td></tr>	
		<tr><td>تاریخ تراکنش</td><td>'.$tempBalance['balance']['insert_date'].'</td></tr>
		<tr><td>تاریخ درج</td><td>'.$tempBalance['balance']['insert_date'].'</td></tr>
		<tr><td>پرداختی</td><td>'.$tempBalance['balance']['pay'].' ریال</td></tr>
		<tr><td>دریافتی</td><td>'.$tempBalance['balance']['recive'].' ریال</td></tr>
		<tr><td>شماره موبایل</td><td>'.$tempBalance['balance']['mobile'].'</td></tr>
		<tr><td>وضعیت</td><td>';	$inf['internetTransaction'] = R::getAll('SELECT * FROM  internet_transaction where id='.$tempBalance['balance']['intransactionid']);
						    $body .= '<span style="color:' . ($inf['internetTransaction'][0]['ref_num']>0 ? '#9AF903">موفق' : '#FB5A5A">نا موفق') .'</span>';
			  $facture =R::getAll('select * from `facture`  where `intransactionid`='.$tempBalance['balance']['intransactionid'] );				
		$body .= '
			<tr><td>عملیات </td>
		<td>';
		if($facture!=NULL)
		{
		$body .= ($facture['is_accept']>0 ?'<span >تایید و فاکتور صادر شده است<span>':'<span >در انتظار تایید<span>');
		}
		else{
		$body .= '<span >هنوز فاکتوری صادر نشده است<span>';
		}
			$body .= '|<a  href="'. GSMS::$class['template']->info['user_url'].'accounting/deletebalance/' . $tempBalance['balance']['intransactionid'] . '" class="btn  btn-danger" >حذف</a> 

		</td>
		</tr>
		</td></tr></table>';
		$body .='</div></div> 	';
 
        GSMS::$class['template']->message(
							' نمایش تراکنش مالی ' ,		//title
							$body,					//body
							'user',					//part
							' ',	//css class
							false,					//format output
							true,						//return button
							array('activeTab'=>'accounting')); //extra argument
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}