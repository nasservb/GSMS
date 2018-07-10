<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class change_password
{
    function change_password()
    {
       
			$inf=array('page_title'=>'تغییر رمز' ,'activeTab'=>'profile');
			GSMS::$class['template']->header($inf); 
			GSMS::$class['template']->load($inf,'user_header');
			//----------------------------------
			
			$body='<div class="message-info">اطلاعات رمز
			<form id="registerForm" method ="POST" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group is-empty">
						<label class="control-label">رمز فعلی</label>
						<input type="password" class="form-control" name="oldpass" id="oldpass" size="30" />
					<span class="material-input"></span></div>
				</div>
			</div>
			<div class="row">
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
						<input type="button" class="btn btn-success" onclick="checkForm()" value="تغییر رمز" /> 
					<span class="material-input"></span></div>
				</div>
			</div>
				
			 
			  </form>
			</div>
			<div id="checkResult" class="col-sm-12 "></div>';
		
			$body .= '
			<script >
			$("#checkResult").hide("fast");
			function checkForm()
			{
				$("#checkResult").hide("fast");
				result  = "" ; 
				
				if($("#oldpass").val()  < 3 )
					result = result + "رمز فعلی به درستی وارد نشده است.<br/>" ;
				if($("#newpass").val()  < 3 )
					result = result + "رمز جدید به درستی وارد نشده است.<br/>" ;
				if($("#newpass_again").val()  < 3 )
					result = result + "تکرار رمز جدید به درستی وارد نشده است.<br/>" ;
				
				if(result.length > 1 )
				{
					$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا های زیر را بررسی کنید : <br/>"+ result) ;
					$("#checkResult").show("slow");
					return false ; 
				} 
				$("#checkResult").hide("fast");
				document.getElementById(\'registerForm\').submit();
				return true ;
			}
			</script>';
			
			$inf=array('title'=>'تغییر رمز ','body'=>$body);
			GSMS::$class['template']->load($inf,'site_index');
			GSMS::$class['template']->load($inf,'site_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}