<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listBalance
{
    function listBalance($tempBalance)
    {
         
        $body = '';
      
        
        $body .= '
		<div class="message-info">
		<table  class="table table-striped   table-hover">
		
		<tr><td>شماره</td><td>'.$tempBalance['admin']->id.'</td></tr>
		<tr><td>نام</td><td>'.$tempBalance['admin']->name . ' ' . $tempBalance['admin']->family.'</td></tr>
		<tr><td>تاریخ</td><td>'.$tempBalance['admin']->insert_date.'</td></tr>
		<tr><td>اعتبار</td><td>'.$tempBalance['admin']->credit.'</td></tr>
		<tr><td>تصویر</td><td><img id="imgicon" src="'.
						GSMS::$class['template']->info['index_url'].'iconGroupView/'.
						$tempBalance['admin']->icon_picture_id.'"/></td></tr>
		</table>
		<br/>
		
		<table dir="rtl" class="table table-striped table-bordered table-hover">
		<tr>
		<td>شماره</td>
		<td>پایانه</td>
		<td>ارجاع</td>
		<td>مقدار</td>
		<td>سهم کارمز</td>
		<td>تاریخ تراکنش</td>
		<td>نمايش </td>
		</tr>';
		if (count($tempBalance['balance']) == 0) 
		{
            $body .= '<tr>تراکنشی يافت نشد</tr></table></div><br><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';

            $inf = array('title' => '  ليست تراکنش های مالی ', 'body' => $body);
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
		else 
		{
			for ($i = 0; $i < count($tempBalance['balance']); $i++) 
			{
				
				$body .= '<tr >' .
					'<td>' . $i . '</td>' .
					'<td>' . $tempBalance['balance'][$i]['terminalno'] . '</td>' .
					'<td>' . $tempBalance['balance'][$i]['referenceno'] . '</td>' .
					'<td>' . $tempBalance['balance'][$i]['recive'] . '</td>' .
					'<td>' . $tempBalance['balance'][$i]['porsant'] . '</td>' . 
					'<td>' . $tempBalance['balance'][$i]['create_date'] . '</td>' . 
					'<td><a href="'.GSMS::$class['template']->info['user_url'] .'accounting/viewBalance/' . $tempBalance['balance'][$i]['id'] . '">نمايش</a></td>' .
					'</tr>';
			}
			//for
		}
        
        $body .= '</table><br>';
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'accounting/listBalance/', 
			$tempBalance['begin'], $tempBalance['count']);

		 

        $inf = array('title' => ' ليست تراکنش های مالی ', 'body' => $body);
        
        GSMS::$class['template']->message(
							'ليست تراکنش های مالی' ,		//title
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