<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class edit_admin
{
    function edit_admin($tempAdmin)
    {
        //free result
        $inf = array('page_title' => 'ويرايش پروفایل');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'ويرايش پروفایل');
        GSMS::$class['template']->load($inf,'user_header');
        //----------------------------------

        if (!is_object($tempAdmin)) {
            $body = 'اطلاعات کاربري يافت نشد<br>
						<a class="back_btn" href="' .
                GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'ويرايش پروفایل', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
        //if

        $body = '<div class="message-info">اطلاعات کاربری را وارد کنيد
  <form name="user_data" method="post" action="' .
            GSMS::$class['template']->info['user_url'] . 'admins/edit_admin">
    <input type="hidden" name="admin_id" id="admin_id"  value="' . $tempAdmin->id . '"/>
  <table   calss="table table-striped" >
    <tr>
      <td >نام*</td>
      <td><input type="text" name="name" id="name" value="' . $tempAdmin->name . '" /></td>
    </tr>
    <tr>
      <td>نام خانوادگي*</td>
      <td><input type="text" name="family" id="family" value="' . $tempAdmin->family . '"/></td>
    </tr>
    <tr>
      <td>ايميل*</td>
      <td><input type="text" name="mail" id="mail" value="' . $tempAdmin->mail . '"/></td>
    </tr>
    <tr>
      <td>نام کاربري</td>
      <td><div class="disable_input">' . $tempAdmin->username . '</div></td>
    </tr>
    <tr>
      <td>همراه</td>
      <td><input type="text" name="mobile" id="mobile" value="' . $tempAdmin->mobile . '"/></td>
    </tr>
    <tr>
      <td>تاريخ ثبت</td>
      <td><div class="disable_input">' . $tempAdmin->date . '</div></td>
    </tr>
    <tr>
      <td>توضيح</td>
      <td><input type="text" name="describe" id="describe" value="' . $tempAdmin->describe . '"></td>
    </tr>
    
   
   
	<tr>
      <td>ارسال</td>
      <td><input type="submit" class="btn btn-primary "  name="submit" id="but"  value="ثبت"/></td>
    </tr>
  </table>
  </form>
</div>';
        $body .= '<a class="back_btn" href="' .
            GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' => 'ويرايش پروفایل ', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}