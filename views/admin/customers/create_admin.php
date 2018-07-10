<?php //allahoma sale ala mohammad va ale mohammad
 

class create_admin
{
    function create_admin($parameter)
    {
		$body='<div dir=rtl>
		<form id="user_data" name="user_data" onSubmit="return checkForm()" method="post" action="'.
			GSMS::$class['template']->info['admin_url'].'customers/addEmployer">
		
<div class="message-info">	

اطلاعات کارمند جدید را وارد کنید			
  
<div class="row">
	<div class="col-md-6">
		<div class="form-group  label-floating is-empty">
			<label class="control-label">نام*</label>
			<input type="text" class="form-control" name="name" id="name"  />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group label-floating is-empty">
			<label class="control-label">نام خانوادگي*</label>
			<input type="text" class="form-control" name="family" id="family" />
		<span class="material-input"></span></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group label-floating is-empty">
			<label class="control-label">ايميل*</label>
			<input type="text" class="form-control" name="mail" id="mail" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group label-floating is-empty">
			<label class="control-label">نام کاربري*</label>
			<input type="text" class="form-control"  name ="username" id="username"/>
		 </div>
	</div>
</div>
	  <input type="hidden" name="user_type" value="1" />
 
 

<div class="row">
	<div class="col-md-6">
		<div class="form-group label-floating is-empty">
			<label class="control-label">همراه *</label>
			<input type="text" class="form-control" name="mobile" id="mobile"  />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group label-floating is-empty">
			<label class="control-label">رمز عبور*</label>
			<input type="text" class="form-control" name="pass" id="pass"/>
		 </div>
	</div>
</div>



<div class="row">
	<div class="col-md-12">
		<div class="form-group label-floating is-empty">
			<label class="control-label">شرح کوتاه</label>
			<textarea  class="form-control" name="describe" id="describe" ></textarea>
			<span class="material-input"></span>
		</div>
	</div>
	 
	<div class="col-md-12">
		<div class="form-group is-empty">
			<input type="submit" class="btn btn-primary "  name="submit" id="but" value="ثبت کارمند"/>
		<span class="material-input"></span></div>
	</div>
</div>
<div class="row">
	<div id="checkResult" class="col-sm-6 pull-right"></div>
</div>
</form>
';
$body .='
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
		
		if($("#username").val()  < 1 ){
				result = result + "نام کاربری وارد نشده است.<br/>" ;
		}
		';
		$state = '';
		foreach ($parameter['part'] as $value) 
		{
			
			$state .= '(!($("#service'.$value['id'].'").is(":checked")))&&';
		}
		if(!empty($state))
		{
			$state2=substr($state,0, (strlen($state) - 2));
			$body .= 'if('.$state2.'){
				result = result + "سطح دسترسی انتخاب نشده است.<br/>" ;
			}';			
		}
		
		$body .= 'if($("#mobile").val()  < 1 ){
				result = result + "تلفن همراه وارد نشده است.<br/>" ;
		}
		if($("#pass").val()  < 1 ){
				result = result + "رمز عبور وارد نشده است.<br/>" ;
		}
		if($("#describe").val()  < 1 ){
				result = result + "شرح کوتاه وارد نشده است.<br/>" ;
		}
		
		if(isArabic($("#username").val())){
			result = result + "نام کاربری باید انگلیسی باشد.<br/>" ;
		}
		
		if(isArabic($("#pass").val())){
			result = result + "رمز عبور باید انگلیسی باشد.<br/>" ;
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
	
	function isArabic(strInput)
	{
		var arregex = /[\u0600-\u06FF]/;
		if (arregex.test(strInput)){
			return true;
		}else{
			return false;
		}
	}
</script>
'; 

GSMS::$class['template']->message('ثبت کارمند' , $body ,'admin' ,'',false , false , 
	array('activeTab'=>'customers') );
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}