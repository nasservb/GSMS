<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class list_sqlbugs
{

    function list_sqlbugs($tempSqlbugsArray)
    {

        $inf = array('page_title' => 'ليست خطا های بانک اطلاعاتی');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'ليست خطا های بانک اطلاعاتی ');
        GSMS::$class['template']->panel_header($inf);


        $body = '';
        list($tempSqlbugs, $begin, $itemCount) = $tempSqlbugsArray;

        if (count($tempSqlbugs) == 0 || !is_array($tempSqlbugs)) {
            $body = 'خوشبختانه خطایی یافت نشد</table><br><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'ليست خطا های بانک اطلاعاتی', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
        //if

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'settings/list_sqlbugs/', $begin, $itemCount);


        $body .= '<table class="data_table"><tr>
		<td>شماره</td>
		<td>کد خطا</td>
		<td>دستور اس کیو ال</td>
		<td>تاريخ</td>
		<td>توضيح</td>
		<td>فايل</td>
		<td>پیغام</td>
		<td>اپراتور</td>
		<td>آی پی</td>
		</tr>';
        for ($i = 0; $i < $itemCount; $i++) {
            $body .= '<tr id="' . ($i % 2 == 0 ? 'tr_even' : 'tr_odd') . '">' .
                '<td>' . $tempSqlbugs[$i]->id . '</td>' .
                '<td>' . $tempSqlbugs[$i]->error_code . '</td>' .
                '<td>' . $tempSqlbugs[$i]->sql . '</td>' .
                '<td>' . $tempSqlbugs[$i]->time . '</td>' .
                '<td>' . $tempSqlbugs[$i]->describe . '</td>' .
                '<td>' . $tempSqlbugs[$i]->file . '</td>' .
                '<td>' . $tempSqlbugs[$i]->message . '</td>' .
                '<td>' . $tempSqlbugs[$i]->username . '</td>' .
                '<td>' . $tempSqlbugs[$i]->operator_ip . '</td>' .
                '</tr>';
        }
        //for
        $body .= '</table>';

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'settings/list_sqlbugs/', $begin, $itemCount);

        $body .= '<br/><a class="back_btn" href="'
            . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' => 'ليست خطا های بانک اطلاعاتی', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}