<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class profile
{
    function profile($tempAdmin)
    {
        if (!is_object($tempAdmin)) {
            $body = 'اطلاعات کاربري يافت نشد ';
            GSMS::$class['template']->message(
							'ويرايش پروفایل' ,		//title
							$body,					//body
							'user',					//part
							'alert alert-warning',		//css class
							true,					//format output
							true,						//return button
							array('activeTab'=>'profile')); //extra argument 
            return;
        }
        //if

        $body = 'اطلاعات کاربری را وارد کنيد
  <form name="user_data" method="post" action="' .
            GSMS::$class['template']->info['user_url'] . 'users/profile">
    <input type="hidden" name="admin_id" id="admin_id"  value="' . $tempAdmin->id . '"/>
  
  
<div class="row">
	<div class="col-md-6">
		<div class="form-group   is-empty">
			<label class="control-label">نام*</label>
			<input type="text" class="form-control" name="name" id="name" value="' . $tempAdmin->name . '" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group   is-empty">
			<label class="control-label">نام خانوادگي*</label>
			<input type="text" class="form-control" name="family" id="family" value="' . $tempAdmin->family . '"/>
		<span class="material-input"></span></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group   is-empty">
			<label class="control-label">ايميل*</label>
			<input type="text" class="form-control" name="mail" id="mail" value="' . $tempAdmin->mail . '" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group   is-empty">
			<label class="control-label">نام کاربري</label>
			<input type="text" class="form-control"  disabled value="' . $tempAdmin->username . '"/>
		 </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group   is-empty">
			<label class="control-label">تلفن*</label>
			<input type="text" class="form-control" name="mobile" id="mobile" value="' . $tempAdmin->mobile . '" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group  is-empty">
			<label class="control-label">تاريخ ثبت نام</label>
			<input type="text" class="form-control"  disabled value="' . $tempAdmin->insert_date . '"/>
		 </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group   is-empty">
			<label class="control-label">شرح کوتاه</label>
			<textarea  class="form-control" name="describe" id="describe" >' . $tempAdmin->description . '</textarea>
			<span class="material-input"></span>
		</div>
	</div>
	 
	<div class="col-md-12">
		<div class="form-group   is-empty">
			<input type="submit" class="btn btn-primary "  name="submit" id="but"  value="ثبت اطلاعات"/>
		<span class="material-input"></span></div>
	</div>
</div> 
  
  </form>
';  
        GSMS::$class['template']->message(
			'ويرايش پروفایل' ,		//title
			$body,					//body
			'user',					//part
			'alert alert-warning',		//css class
			false,					//format output
			false,						//return button
			array('activeTab'=>'profile')); //extra argument 
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}