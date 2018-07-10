<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listTransaction
{
    function listTransaction($temp) 
    {
		$inf = array(
			'page_title' => 'لیست تراکنش ها',
			'activeTab' => 'accounting'
		);
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		$tempTrArray = $temp['res'];
        list($tempTrs, $begin, $count) = $tempTrArray;		
        $body = '<div>';
        if (count($tempTrs) == 0) 
		{
            $body .= 'تراکنشی يافت نشد<br> ';
			GSMS::$class['template']->message(
							' ليست تراکنش ها' ,		//title
							$body,					//body
							'user',					//part
							'alert alert-warning',	//css class
							true,					//format output
							false,						//return button
							array('activeTab'=>'accounting')); //extra argument
            return;
        }
		/*
        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'cats/list_cats/', $begin, $itemCount);
		*/

        $body .= '<table class="table table-hover">
		<thead class="text-primary">
			<th class="text-right">#</th>
			<th class="text-right">تاریخ </th>
			<th class="text-right">مبلغ</th>
			<th class="text-right">کد پیگیری</th>
			<th class="text-right">علت واریز</th>
			<th class="text-right">وضعیت</th>
			<th class="text-right">صورتحساب</th>
		</thead>
		
		<tbody>';
		
        for ($i = 0; $i < count($tempTrs); $i++) {
            $body .= '<tr id="' . ($i % 2 == 0 ? 'tr_even' : 'tr_odd') . '">' .
                '<td>' . $tempTrs[$i]->id . '</td>' .
                '<td>' . str_replace('-','/',$tempTrs[$i]->dateStart). '   '.$tempTrs[$i]->timeStart . '</td>' .
                '<td>' . number_format( $tempTrs[$i]->totalAmount) . ' ريال</td>' .
                '<td>' . $tempTrs[$i]->refNum . '</td>' .
				'<td>' . $tempTrs[$i]->comment . '</td>' .
                '<td><span class="' . ($tempTrs[$i]->refNum>0 ? 'text-success">موفق' : 'text-danger">نا موفق' ) . '</span></td>' .
				
				'<td>
				'.
				($tempTrs[$i]->factureId>0 ?
				'
				<a href="'.GSMS::$class['template']->info['user_url'].'accounting/viewFacture/'.$tempTrs[$i]->factureId.'"  class="btn btn-sm">نمایش</a>
				'
				:'')
				.'
				</td>
				</tr>';
        }
        //for
        $body .= '</tbody></table> ';
		
		$body .= GSMS::$class['template']->paging(
			GSMS::$class['template']->info['user_url'] .'accounting/transactions/', $begin, $count);
		$body .= '</div>';
		
		$inf = array(
			'title' => 'لیست تراکنش ها',
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