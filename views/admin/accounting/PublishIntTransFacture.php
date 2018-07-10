<?php //allahoma sale ala mohammad va ale mohammad
class PublishIntTransFacture{
	function PublishIntTransFacture($temp)
    {
		//---------------initializing-----------
        $inf = array('page_title' => 'صدور صورتحساب','activeTab' => 'accounting');
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf,'admin_header');
		$inf['title'] = $inf['page_title'];
		
		$internetTransaction = $temp['internetTransaction'];
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
						<label class="control-label">تاریخ سررسید</label>
						<input name="dateDue" id="dateDue" type="text" class="form-control" >
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>توضیحات</label>
						<div class="form-group label-floating">
							<label class="control-label">اگر توضیحاتی در مورد این صورتحساب دارید، لطفا در این قسمت وارد کنید.</label>
							<textarea name="description" id="description"  class="form-control" rows="5"></textarea>
						</div>
					</div>
				</div>
			</div>
			
			<div id="notif"></div>
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
					result = result + "تاریخ سررسید صورتحساب وارد نشده است.<br/>" ;
			}
			if(result.length > 1 )
			{
				$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا های زیر را بررسی کنید : <br/>"+ result) ;
				$("#checkResult").show("slow");
				return false ; 
			} 
			$("#checkResult").hide("slow");
			return true ;
		}
		</script>
		';
		
		$inf['body'] = $body ;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
	}
}
//class
if (!defined("GSMS")) {
    exit("Access denied");
}
?>