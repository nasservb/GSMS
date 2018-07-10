<?php //allahoma sale ala mohammad va ale mohammad


class insertTicket
{
    function insertTicket($temp)
    {
		//---------------initializing-----------
		$inf = array('page_title' => 'ثبت تیکت پشتیبانی','activeTab'=>'orders');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, $temp['level'].'_header');
        
        $body = 'اطلاعات تیکت پشتیبانی را وارد کنيد
		
<form name="user_data" method="post" onsubmit="return checkForm()" >
  
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="form-group   is-empty">
				<label class="control-label">عنوان </label>
				<input type="text" class="form-control" name="title" id="title" value="" />
			<span class="material-input"></span></div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="form-group   is-empty">
				<label class="control-label">شرح کوتاه</label>
				<textarea  class="form-control" name="content" id="content" ></textarea>
				<span class="material-input"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="form-group   is-empty">
				<input type="submit" class="btn btn-primary "  name="submit" id="but"  value="ثبت تیکت"/>
			<span class="material-input"></span></div>
		</div>
	</div>
	
</form>
<div id="checkResult" ></div>

<script>
$("#checkResult").hide("fast");
function checkForm() 
{
	$("#checkResult").hide("fast");
	result  = "" ; 
	if($("#name").val().length < 3 )
		result = result + "عنوان تیکت را وارد کنید<br/>" ;
	if( $("#content").val().length < 3 )
		result = result + "شرح کوتاه را وارد کنید<br/>" ;
	if(result.length > 1 )
	{
		$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا هاي زير را بررسي کنيد : <br/>"+ result) ;
		$("#checkResult").show("slow");
		return false ; 
	} 
	$("#checkResult").hide("slow");
}
</script>
';
		$inf = array('title' =>  'ثبت تیکت پشتیبانی', 'body' => $body);
		GSMS::$class['template']->load($inf,$temp['level'].'_index');
        GSMS::$class['template']->load($inf,$temp['level'].'_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}