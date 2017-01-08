<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class change_password
{
    function change_password()
    {
      //free result
			$inf=array('page_title'=>'تغییر رمز');
			GSMS::$class['template']->header($inf);
			$inf=array('page_title'=>'تغییر رمز');
			GSMS::$class['template']->load($inf,'user_header');
			//----------------------------------
			
			$body='<div class="message-info">اطلاعات رمز
			<form id="user_data" name="user_data" method="post" action="'.
								GSMS::$class['template']->info['user_url'].'admins/change_password">
  <table class="table table-hovered " style="width:50%">
    <tr>
      <td >رمز فعلی</td>
      <td><input type="password" name="oldpass" id="oldpass" value="" /></td>
    </tr>
    <tr>
      <td>رمز جدید</td>
      <td><input type="password" name="newpass" id="newpass" value=""/></td>
    </tr>
	<tr>
      <td>تکرار رمز جدید</td>
      <td><input type="password" name="newpass_again" id="newpass_again" value=""/></td>
    </tr>	
	<tr>
      <td>ارسال</td>
      <td><input type="submit" class="btn btn-primary"  name="but" id="but"  value="ثبت"/></td>
    </tr>
  </table>
  </form>
</div>';
			$body.='<a class="back_btn" href="'.
							GSMS::$class['template']->info['user_url'].'">برگشت</a>';
			$inf=array('title'=>'تغییر رمز ','body'=>$body);
			GSMS::$class['template']->index($inf);
			GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}