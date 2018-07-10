<?php //allahoma sale ala mohammad va ale mohammad
class editOptionItem
{
	function editOptionItem($temp)
	{
		$optionItems = $temp['optionItems'];
		$body = '';
		$body .='<div>
		<form method ="POST" action="' . GSMS::$class['template']->info['admin_url'] . 'orderform/editOptionItem/'.$optionItems[0]['id'].'"
		onSubmit="return checkForm()">
			<div class="col-md-6">
				<div class="form-group">
					<label>نام آیتم</label>
					<div class="form-group label-floating is-empty">
						<input class="form-control" name="value" id="value" value="'.$optionItems[0]['value'].'"></input>
					<span class="material-input"></span></div>
				</div>
			</div>
			<div class="col-md-12">
			<button class="btn btn-success" type="submit">ثبت تغییرات</button>
			</div>
		</form>
		';
		
		$body .='<div id="checkResult" class="col-sm-6 pull-right"></div></div>';
		
		$body .= '
		<script>  
			$("#checkResult").hide("fast");
			function checkForm() 
			{
				result  = "" ;
				if($("#value").val()  < 1 ){
						result = result + "نام آیتم وارد نشده است.<br/>" ;
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
		
		GSMS::$class['template']->message('ویرایش آیتم المنت',$body,'admin','',true, false, array('activeTab' => 'orderform'));
		
	}
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}