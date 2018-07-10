<?php //allahoma sale ala mohammad va ale mohammad
 

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
                . GSMS::$class['template']->info['admin_url'] . '">برگشت</a>';
            $inf = array('title' =>'ليست نظرات', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
        //if

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'settings/comments/', $begin, $itemCount);


        $body .= '<table class="table table-bordered" dir=rtl>
    <tr>
		<td>نویسنده </td>
		<td>نویسنده </td>
		<td> تاریخ</td>
		<td>متن</td>
		<td>مشاهده </td>
		
	</tr>';
        for ($i = 0; $i < count($tempComments); $i++) {
            $body .= '<tr '.($tempComments[$i]->accepted == 1 ? '' : 'class="alert alert-info"'  ).'  >' .
                '<td>' . $tempComments[$i]->name . '</td>' .
                '<td>' . $tempComments[$i]->createDate . '</td>' .
                '<td>' . $tempComments[$i]->content . '</td>' .
                '<td>
					<a  class="btn " href="' .GSMS::$class['template']->info['admin_url'] .
					'settings/commentDelete/'.
                                    $tempComments[$i]->id . '">حذف</a>
				</td>' .
				'<td>
					<a  class="btn " href="' .GSMS::$class['template']->info['index_url'] .
					'telgroups/telgroupView/'.
                                    $tempComments[$i]->itemId . '">مشاهده</a>
				</td>' .
              '</tr>';
        }
        //for
        $body .= '</table>';

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'settings/list_comments/', $begin, $itemCount);

        $body .= '<br/><a class="back_btn" href="'
            . GSMS::$class['template']->info['admin_url'] . '">برگشت</a>';
        $inf = array('title' =>'ليست نظرات', 'body' => $body);
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}