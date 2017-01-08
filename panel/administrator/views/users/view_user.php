<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class view_user
{
    function view_user($tempAdmin)
    {

        $inf = array('page_title' => 'نمایش اطلاعات  کاربر');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'صفحه ی مدیریت ');
        GSMS::$class['template']->panel_header($inf);
        //--------------------------

        if (!is_object($tempAdmin)) {
            $body = 'کاربر یافت نشد<br>
						<a class="back_btn" href="' .
                GSMS::$class['template']->info['user_url'] . 'users/list_users">برگشت</a>';
            $inf = array('title' => 'نمایش اطلاعات  کاربر', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
        //if
        $body = '<div dir=rtl>
  <table border="1" class="input_table">
    <tr>
      <td >نام</td>
      <td><div class="disable_input">' . $tempAdmin->name . '</div></td>
    </tr>
    <tr>
      <td>نام خانوادگی</td>
      <td><div class="disable_input">' . $tempAdmin->family . '</div></td>
    </tr>
    <tr>
      <td>ایمیل</td>
      <td><div class="disable_input">' . $tempAdmin->mail . '</div></td>
    </tr>
    <tr>
      <td>نام کاربری</td>
      <td><div class="disable_input">' . $tempAdmin->userName . '</div></td>
    </tr>
    <tr>
      <td>همراه</td>
      <td><div class="disable_input">' . $tempAdmin->mobile . '</div></td>
    </tr>
    <tr>
      <td>تاریخ ثبت</td>
      <td><div class="disable_input">' . $tempAdmin->date . '</div></td>
    </tr>
    <tr>
      <td>توضیح</td>
      <td><div class="disable_input">' . $tempAdmin->describe . '</div></td>
    </tr>
    
    <tr>
      <td>نمایش مجوزها</td>
      <td><div class="disable_input"><a href="' .
            GSMS::$class['template']->info['user_url']
            . 'view_permission/' . $tempAdmin->id . '">نمایش</a></div></td>
    </tr>
  </table>
</div>
<a class="back_btn" href="' .
            GSMS::$class['template']->info['user_url'] . 'users/list_users">برگشت</a>';
        $inf = array('title' => 'نمایش اطلاعات کاربر', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}