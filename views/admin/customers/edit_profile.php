<?php //allahoma sale ala mohammad va ale mohammad
class edit_profile
{
	function edit_profile($tempAdmin)
	{
		$inf = array(
			'page_title' => 'ویرایش پروفایل',
			'activeTab' => 'customers'
		);
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'admin_header');
		if (!is_object($tempAdmin))
		{
			GSMS::$class['template']->message('خطا','اطلاعات پروفایل یافت نشد.','admin',
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'customers'));
			return ;
		} //if
		$body = '<div  class="message-info">اطلاعات پروفایل را وارد کنید
  <form id="user_data" name="user_data" method="post" onSubmit="return checkForm()" action="' .
  GSMS::$class['template']->info['admin_url'] . 'customers/editProfile">
    
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
			<textarea  class="form-control" name="describe" id="describe" >' . $tempAdmin->describe . '</textarea>
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
  
<div class="row">
	<div id="checkResult" class="col-sm-6 pull-right"></div>
</div>
</div>

<script>  
	$("#checkResult").hide("fast");
	function checkForm() 
	{
		result  = "" ;
		if($("#name").val()  < 1 ){
				result = result + "نام وارد نشده است.<br/>" ;
		}
		if($("#family").val()  < 1 ){
				result = result + "نام خانوادگی وارد نشده است.<br/>" ;
		}
		if($("#mail").val()  < 1 ){
				result = result + "ایمیل وارد نشده است.<br/>" ;
		}
		
		if($("#mobile").val()  < 1 ){
				result = result + "تلفن همراه وارد نشده است.<br/>" ;
		}
		
		if(result.length > 1 )
		{
			$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا هاي زير را بررسي کنيد : <br/>"+ result) ;
			$("#checkResult").show("slow");
			return false ; 
		} 
		$("#checkResult").hide("slow");
		return true ;
	}
	
</script>
';
		$body.= '<br/>';
		$inf = array(
			'title' => 'ویرایش پروفایل ',
			'body' => $body,
			'dir' => 'ltr'
		);
		GSMS::$class['template']->load($inf, 'admin_index');
		GSMS::$class['template']->load($inf, 'admin_footer');
	}
}

// class

if (!defined("GSMS"))
{
	exit("Access denied");
}
