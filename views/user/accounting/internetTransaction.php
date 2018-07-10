<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listTransaction
{
	//javad
    function listTransaction($tempTrArray) 
    {
		 
        list($tempTrs, $begin, $count) = $tempTrArray;

        $body = '';
        if (count($tempTrs) == 0) {
			
            $body .= 'تراکنشی يافت نشد ';
 
            GSMS::$class['template']->message(
							'ليست تراکنش ها ' ,		//title
							$body,					//body
							'user',					//part
							'alert alert-warning',					//css class
							true,					//format output
							true,						//return button
							array('activeTab'=>'accounting')); //extra argument 
            exit();
        }
        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'cats/list_cats/', $begin, $itemCount);

        $body .= '<table  class="table tabl-hover tabl-striped"><tr>
		<td>شماره</td>
		<td>تاریخ </td>
		<td>مبلغ</td>
		<td>کد پیگیری</td>
		<td>وضعیت</td>
		</tr>';
        for ($i = 0; $i < count($tempTrs); $i++) {
            $body .= '<tr id="' . ($i % 2 == 0 ? 'tr_even' : 'tr_odd') . '">' .
                '<td>' . $tempTrs[$i]->id . '</td>' .
                '<td>' . $tempTrs[$i]->dateStart. ' '.$tempTrs[$i]->timeStart . '</td>' .
                '<td>' . $tempTrs[$i]->totalAmount . '</td>' .
                '<td>' . $tempTrs[$i]->resNum . '</td>' .
                '<td><span style="color:' . ($tempTrs[$i]->resNum>0 ? 'green">موفق' : 'red">نا موفق' ) . '</span></td>' .
                '</tr>';
        }
        //for 

        $inf = array('title' => 'ليست تراکنش ها ', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->message(
							'ليست تراکنش ها ' ,		//title
							$body,					//body
							'user',					//part
							'',					//css class
							false,					//format output
							true,						//return button
							array('activeTab'=>'accounting')); //extra argument 
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
