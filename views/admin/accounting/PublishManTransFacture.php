<?php //allahoma sale ala mohammad va ale mohammad
class PublishManTransFacture{
	function PublishManTransFacture($temp)
    { 
		
		 
		$manualTransaction = $temp['manualTransaction'];
		$userOrder = $temp['userOrder'];
		
		$body = '<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/jquery.maskedinput.min.js"></script>
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/jquery.validation.js"></script>
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#dateDue").persianDatepicker();            
			});
		</script>
		';
		$body .= '
		<div class="message-info" style="text-shadow: 0px 0px 1px #96ECFF;  color: #0F6D73;">
		<form enctype="multipart/form-data" method="post" onSubmit="return checkForm()">
			<input id="orderId" name="orderId"  type="hidden" class="form-control" value="'.$userOrder->id.'">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">عنوان سفارش</label>
						<input type="text" class="form-control" disabled value="'.$userOrder->name.'">
					</div>
				</div>
				
				<div class="col-md-2">
					<div class="form-group label-floating">
						<label class="control-label">کد سفارش</label>
						<input type="text" class="form-control" disabled value="'.$userOrder->id.'">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">عنوان صورتحساب</label>
						<input id="factureTitle" name="factureTitle" type="text" class="form-control" >
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">مبلغ صورتحساب</label>
						<input id="totlaAmount" name="totlaAmount" type="text" class="form-control" >
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">تاريخ سررسيد</label>
						<input name="dateDue" id="dateDue" type="text" class="form-control" >
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>توضيحات</label>
						<div class="form-group label-floating">
							<label class="control-label">اگر توضيحاتي در مورد اين صورتحساب داريد، لطفا در اين قسمت وارد کنيد.</label>
							<textarea name="description" id="description"  class="form-control" rows="5"></textarea>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<input name="submit" class="btn btn-primary" value="ثبت" type="submit">
			</div>
		</form>
		';
		
		$body .= '
		<div class="row">
			<div id="checkResult" class="col-sm-6 pull-right"></div>
		</div>
		</div>
		
		<script>  
		$("#checkResult").hide("fast");
		function checkForm() 
		{
			result  = "" ;
			if($("#factureTitle").val()  < 1 ){
					result = result + "عنوان صورتحساب وارد نشده است.<br/>" ;
			}
			if($("#totlaAmount").val()  < 1 ){
					result = result + "مبلغ صورتحساب وارد نشده است.<br/>" ;
			}
			if($("#dateDue").val()  < 1 ){
					result = result + "تاريخ سررسيد صورتحساب وارد نشده است.<br/>" ;
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
		 
        GSMS::$class['template']->message('صدور صورتحساب' ,$body,'admin','',false,false , array('activeTab' => 'accounting'));
		
	}
}
//class
if (!defined("GSMS")) {
    exit("Access denied");
}
?>