<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class reports
{

    function reports($information)
    {
        GSMS::load('template', 'lib');

        $inf = array('page_title' => 'گزارش آماری سیستم  ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'گزارش آماری سیستم  ');
        GSMS::$class['template']->panel_header($inf);


        $body = '';


        $body .= '<table class="data_table" dir="rtl">
		<tr><td>تعداد مدیران </td><td><input type="text" disabled value="' . $information['admins'] . '" /></td></tr>
		<tr><td>تعداد کاربران :</td><td><input type="text" disabled value="' . $information['users'] . '" /></td></tr>
		<tr><td>تعداد عکاسان :</td><td><input type="text" disabled value="' . $information['photographers'] . '" /></td></tr>
		
		<tr><td>تعداد تصاویر :</td><td><input type="text" disabled value="' . $information['photos'] . '" /></td></tr>
		<tr><td>تعداد موضوعات :</td><td><input type="text" disabled value="' . $information['categoris'] . '" /></td></tr>
		<tr><td>تعداد خطا های  اس کیو ال :</td><td><input type="text" disabled value="' . $information['bugs'] . '" /></td></tr>
		
		<tr><td>سیستم کوچک ساز تصاویر</td><td><input type="text" disabled value="' . (GSMS::$config['photo_resize'] == false ? 'خاموش' : 'روشن') . '" /></td></tr>
		<tr><td>سیستم ایجادگر  تصاویر بندانگشتی</td><td><input type="text" disabled value="' . (GSMS::$config['photo_thumbs'] == false ? 'خاموش' : 'روشن') . '" /></td></tr>
		<tr><td>مسیر ذخیره سازی </td><td><input type="text" disabled value="' . GSMS::$config['photo_archive_path'] . '" /></td></tr>
		<tr><td>فرمت ذخیره سازی</td><td><input type="text" disabled value="' . GSMS::$config['photo_format'] . '" /></td></tr>
		<tr><td>آی پی شما</td><td><input type="text" disabled value="' . GSMS::$class['input']->ip_address() . '" /></td></tr>
		';

        $body .= '</table>';

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'settings/list_sqlbugs/', $begin, $itemCount);

        $body .= '<br/><a class="back_btn" href="'
            . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' => 'گزارش آماری سیستم  ', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}