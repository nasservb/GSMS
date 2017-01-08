<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class view_request
{
    function view_request($tempRequests)
    {

        $inf = array('page_title' => 'نمایش اطلاعات  درخواست');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'صفحه ی مدیریت ');
        GSMS::$class['template']->panel_header($inf);
        //--------------------------
        list($tempRequest, $responses) = $tempRequests;

        if (!is_object($tempRequest)) {
            $body = 'درخواست یافت نشد<br>
						<a class="back_btn" href="' .
                GSMS::$class['template']->info['user_url'] . 'users/list_users">برگشت</a>';
            $inf = array('title' => 'نمایش اطلاعات  درخواست', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
        //if


        $body = '<div dir=rtl>
  <table border="1" class="input_table">
    <tr>
      <td >شماره</td>
      <td><div class="disable_input">' . $tempRequest->id . '</div></td>
    </tr>
    <tr>
      <td>عنوان</td>
      <td><div class="disable_input">' . $tempRequest->title . '</div></td>
    </tr>
    <tr>
      <td>شرح</td>
      <td><div class="disable_input">' . $tempRequest->describe . '</div></td>
    </tr>
    <tr>
      <td>تاریخ درخواست</td>
      <td><div class="disable_input">' . $tempRequest->createDate . '</div></td>
    </tr>
    <tr>
      <td>درخواست کننده</td>
      <td><div class="disable_input">' . (is_object($tempRequest->owner) ? $tempRequest->owner->family : '') . '</div></td>
    </tr>
    <tr>
      <td>پاسخگو</td>
      <td><div class="disable_input">' . (is_object($tempRequest->responser) ? $tempRequest->responser->family : 'بدون پاسخ') . '</div></td>
    </tr>
    <tr>
      <td>تاریخ پاسخ</td>
      <td><div class="disable_input">' . (is_object($tempRequest->responser) ? $tempRequest->responseDate : '') . '</div></td>
    </tr>
  </table>
</div><br/>
';
        $body .= '<table dir="rtl" class="input_table">'; //print_r($responses);
        for ($i = 0; $i < count($responses); $i++) {
            $body .= '<tr><td>زمان پاسخ</td><td>' . $responses[$i]->responseDate . '</td></tr>';
            $body .= '<tr><td>عنوان پاسخ</td><td>' . $responses[$i]->title . '</td></tr>';
            $body .= '<tr><td>شرح پاسخ</td><td>' . $responses[$i]->describe . '</td></tr>';
            $body .= '<tr><td>پاسخگو</td><td>' . $responses[$i]->responser->family . '</td></tr>';


            $body .= '</table><table dir="rtl" class="input_table">';
            for ($j = 0; $j < count($responses[$i]->responsePhoto); $j++) {
                $body .= '<td>
					<div class="post_preview" dir="rtl" align="right"><br/>
						<a href="' . GSMS::$class['template']->info['user_url'] . 'photographer/photo_view/' . $responses[$i]->responsePhoto[$j] . '">
							<img class="post_thume"
								id="img' . $i . '"
								src="' . GSMS::$class['template']->info['user_url'] . 'photographer/photo_preview/' . $responses[$i]->responsePhoto[$j] . '">
						</a><br/>			
						
						<a href="' . GSMS::$class['template']->info['user_url'] . 'photographer/photo_detail/' . $responses[$i]->responsePhoto[$j] . '" rel="bookmark">
							<div class="read_more">جزئیات</div>
						</a>
					</div></td>';

                $body .= (($j + 1) % 3 == 0) ? '</tr><tr>' : '';
            }
            $body .= '</table>' . ($i < count($responses) ? '<table dir="rtl" class="input_table">' : '');
        }

        $body .= '</tr></table><br/><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . 'users/user_requests">برگشت</a>';
        $inf = array('title' => 'نمایش اطلاعات درخواست', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}