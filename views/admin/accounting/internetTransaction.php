<?php //allahoma sale ala mohammad va ale mohammad
 

class internetTransaction
{
	//javad
    function internetTransaction($tempTrArray) 
    {
		
       
		$user=GSMS::$class['session']->getUser();
        //------------------------
        list($tempTrs, $begin, $count) = $tempTrArray;

        $body = '';
        if (count($tempTrs) == 0) 
		{
            $body .= 'تراکنشی يافت نشد ';
 
            GSMS::$class['template']->message('ليست تراکنش ها ' ,$body,'admin','alert alert-warning',true , true , array('activeTab' => 'accounting'));
            exit();
        }
        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'cats/list_cats/', $begin, $itemCount);

        $body .= '<table class="data_table" ><tr>
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
        $body .= '</table> ';
 
        GSMS::$class['template']->message( 'ليست تراکنش ها ',$body,'admin',' ',false,true
					,array('activeTab' => 'accounting'));
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
