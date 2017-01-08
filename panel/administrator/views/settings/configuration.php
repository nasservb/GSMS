<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class configuration
{

    function configuration($information)
    {
        GSMS::load('template', 'lib');

        $inf = array('page_title' => 'تغییر تنظیمات');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'تغییر تنظیمات');
        GSMS::$class['template']->panel_header($inf);


        $body = '';

        $body .= '
  <form id="user_data" name="user_data" method="post" action="' .
            GSMS::$class['template']->info['user_url'] . 'settings/configuration">
   
  <table border="1" class="input_table" dir="rtl">
    <tr>
      <td >سیستم کوچک ساز</td>
      <td><input type="checkbox" name="photo_resize" id="photo_resize" ' . ($information['photo_resize']->value == 'on' ? 'checked' : '') . ' /></td>
    </tr>
    <tr>
      <td>سایز کوچک سازی عرض  تصویر</td>
      <td><input type="text" name="photo_width" id="photo_width" ' . ($information['photo_resize']->value == 'off' ? 'disabled' : '') . ' value="' . $information['photo_width']->value . '"/></td>
    </tr>
    <tr>
      <td>سایز کوچک سازی ارتفاع تصویر</td>
      <td><input type="text" name="photo_height" id="photo_height" ' . ($information['photo_resize']->value == 'off' ? 'disabled' : '') . ' value="' . $information['photo_height']->value . '"/></td>
    </tr>
    <tr>
      <td>مسیر ذخیره سازی [مثال c:\archive]</td>
      <td><input type="text" name="photo_archive_path" id="photo_archive_path"  value="' . $information['photo_archive_path']->value . '"/></td>
    </tr>
     <tr>
      <td>سایز کوچک سازی پیش نمایش ها عرض  تصویر</td>
      <td><input type="text" name="photo_small_width" id="photo_small_width"   value="' . $information['photo_small_width']->value . '"/></td>
    </tr>
    <tr>
      <td>سایز کوچک سازی پیش نمایش ها ارتفاع تصویر</td>
      <td><input type="text" name="photo_small_height" id="photo_small_height"   value="' . $information['photo_small_height']->value . '"/></td>
    </tr>
   
  
	<tr>
      <td>ذخیره</td>
      <td><input type="submit" class="back_btn"  name="submit" id="submit"  value="ثبت"/></td>
    </tr>
  </table>
  </form>
</div>';


        $body .= '<br/><a class="back_btn" href="'
            . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' => 'تغییر تنظیمات', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}