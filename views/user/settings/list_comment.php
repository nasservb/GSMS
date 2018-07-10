<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class list_comment
{

    function list_comment($tempCommentsArray)
    {

	
        $inf = array('page_title' => 'ليست نظرات');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'ليست نظرات');
        GSMS::$class['template']->panel_header($inf);


        $body = '';
        list($tempComments, $begin, $itemCount) = $tempCommentsArray['comments'];
		

        if (count($tempComments) == 0 || !is_array($tempComments)) {
            $body = ' نظری یافت نشد</table><br><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' =>'ليست نظرات', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
        //if


        $body .= '<div class="message-info">
		<h4>ليست نظرات گروه های شما
		</h4>
		<table class="table table-bordered table-striped" dir=rtl>
    <tr>
		<td> صفحه </td>
		<td>نویسنده </td>
		<td>   تاریخ</td>
		<td>متن</td>
		<td>مشاهده </td>
		<td>پذیرش </td>
	</tr>';
        for ($i = 0; $i < count($tempComments); $i++) {
            $body .= 
			'<tr '.($tempComments[$i]->accepted == 1 ? '' : 'class="alert alert-info"'  ).'  >' .
                '<td>' . $tempComments[$i]->toString() . '</td>' .
                '<td>' . $tempComments[$i]->name . '</td>' .
                '<td>' . $tempComments[$i]->createDate . '</td>' .
                '<td>' . substr( $tempComments[$i]->content,0,50) . '</td>' .
                '<td><a class="btn btn-success" href="' .GSMS::$class['template']->info['user_url'] . 'settings/commentView/'.
                                    $tempComments[$i]->id . '">مشاهده</a></td>' .
                '<td>'.
				(
					$tempComments[$i]->accepted == 1 ? '' : 
					'<a  class="btn " href="' .GSMS::$class['template']->info['user_url'] .
					'settings/commentAccept/'.
                                    $tempComments[$i]->id . '">پذیرش</a>'
				).
				'</td>' .
              '</tr>';
        }
        //for
        $body .= '</table>';

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'settings/comments/', $begin, $itemCount);

        $body .= '</div><br/><a class="back_btn" href="'
            . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' =>'ليست نظرات', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}