<?php //allahoma sale ala mohammad va ale mohammad
 

class change_password
{
    function change_password()
    {
       
		$body='<div  class="message-info">اطلاعات رمز
			<form id="user_data" name="user_data" method="post" onSubmit="return checkForm()" action="'.
								GSMS::$class['template']->info['admin_url'].'customers/changePassword">
 <div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">رمز فعلی</label>
			<input type="password" class="form-control" name="oldpass" id="oldpass" size="30" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">رمز جدید</label>
			<input type="password" class="form-control" name="newpass" id="newpass" size="30" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">تکرار رمز جدید</label>
			<input type="password" class="form-control" name="newpass_again" id="newpass_again" size="30" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-12">
		<div class="form-group is-empty"> 
			<input type="submit" class="btn btn-primary" name="btn" id="btn" value="تغییر رمز" />
		<span class="material-input"></span></div>
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
		if($("#oldpass").val()  < 1 ){
				result = result + "رمز فعلی وارد نشده است.<br/>" ;
		}
		if($("#newpass").val()  < 1 ){
				result = result + "رمز جدید وارد نشده است.<br/>" ;
		}
		if($("#newpass_again").val()  < 1 ){
				result = result + "تکرار رمز وارد نشده است.<br/>" ;
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
	
</script>';



GSMS::$class['template']->message(  'تغییر رمز ',$body,'admin','',false,false,array('activeTab'=>'customers'));
		
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}