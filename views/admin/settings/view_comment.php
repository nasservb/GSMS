<?php //allahoma sale ala mohammad va ale mohammad
 

class view_comment
{

    function view_comment($tempComment)
    {

        $inf = array('page_title' => 'مشاهده نظر');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'مشاهده نظر');
        GSMS::$class['template']->panel_header($inf);

        $body = '';

        if ( !is_object($tempComment)) {
            $body = ' نظری یافت نشد</table><br><a class="back_btn" href="'
                . GSMS::$class['template']->info['admin_url'] . 'settings/comments">برگشت</a>';
            $inf = array('title' =>'مشاهده نظر', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
        //if


        $body .= '<table class="table table-striped" dir=rtl>
    <tr>
		<td>نویسنده </td>
		<td>' . $tempComment->name . '</td>
	</tr>
	<tr>	
		<td>ایمیل </td>
		<td></td>
	</tr>	
		<td>تاریخ</td>
		<td>' . $tempComment->createDate . '</td>
	</tr>	
		<td>متن</td>
		<td><div class="well">' . str_replace(chr(13),'<br/>', $tempComment->content). '</div></td>
	</tr>	
		<td>عملیات</td>	
		<td>
			<a class="btn btn-success" href="'.GSMS::$class['template']->info['admin_url'] . 'settings/commentAccept/'.
							$tempComment->id . '">
				پذیرش 
			</a>
			<a class="btn btn-danger" href="'.GSMS::$class['template']->info['admin_url'] . 'settings/commentDelete/'.
							$tempComment->id . '">
				حذف
			</a>
		</td>
		
	</tr>';
       

        $body .= '</table>';

        $body .= '<br/><a class="back_btn" href="'
            . GSMS::$class['template']->info['admin_url'] . 'settings/comments/">برگشت</a>';
			
        $inf = array('title' =>'مشاهده نظر', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}