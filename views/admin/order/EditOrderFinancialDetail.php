<?php //allahoma sale ala mohammad va ale mohammad
 
class EditOrderFinancialDetail
{
	function EditOrderFinancialDetail($temp)
	{
		$inf = array('page_title' => 'بروزرسانی وضعیت مالی','activeTab' => 'orders');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'admin_header');
		
		//-------------------
		$body='';
		
		$body = '';
		if($temp==null){
			return ;
		}
		
		$body = '<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/jquery.maskedinput.min.js"></script>
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/jquery.validation.js"></script>
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#bankDate").persianDatepicker();            
				$("#timeDate").persianDatepicker();            
			});
		</script>
		';
		
		//$financialBankRes = $temp['financialBankRes'];
		//$financialTimeRes = $temp['financialTimeRes'];
		$userOrder = $temp['userOrder'];
		$financialStatusValueRes = $temp['financialStatusValueRes'];
		$financialStatusRes = $temp['financialStatusRes'];
		
		$statusIdTemp = 0;
		if(count($financialStatusValueRes)>0){
			$statusIdTemp = $financialStatusValueRes[0]->statusId;
		}
		$select ='<option value="0" selected>انتخاب کنید</option>';
			
			for($i=0 ; $i<count($financialStatusRes);$i++)
			{
				$select .=
				'<option value="'.$financialStatusRes[$i]->id.'" '.' '.($statusIdTemp == $financialStatusRes[$i]->id ? 'selected="selected"' : '').' >'.
				$financialStatusRes[$i]->status.
				'</option>'."\n";
			}
		
		$body.='<div>
			<form  method="POST" onSubmit="return checkForm()">
			<h3>بروزرسانی وضعیت مالی</h3>
			<div>
			<select id="status" name="status" >'.$select.'</select>';
			
		$body.='
		<div  id="financialOption3" style="display:none" >
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">تاریخ</label>
				<input type="text" class="form-control" name="bankDate" id="bankDate">
			</div>
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">بانک</label>
				<input type="text" class="form-control" name="bankBank" id="bankBank">
			</div>
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">نام صاحب حساب</label>
				<input type="text" class="form-control" name="bankName" id="bankName">
			</div>
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">مبلغ چک(ريال)</label>
				<input type="text" class="form-control" name="bankValue" id="bankValue">
			</div>
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">در وجه</label>
				<input type="text" class="form-control" name="bankPay" id="bankPay">
			</div>
		</div>
		';
		
		
		$body.='
		<div  id="financialOption4" style="display:none" >
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">ضمانت پرداخت</label>
				<input type="text" class="form-control" name="timeWarranty" id="timeWarranty">
			</div>
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">زمان تسویه</label>
				<input type="text" class="form-control" name="timeDate" id="timeDate">
			</div>
			<div class="form-group label-floating col-sm-6 pull-right">
				<label class="control-label">مبلغ کل هنگام تسویه(ريال)</label>
				<input type="text" class="form-control" name="timeValue" id="timeValue">
			</div>
		</div>
		';
		
		
			$body.='</div>
			<div class="col-sm-12 pull-right">
			<input class="btn btn-success" name="submit" type="submit" value="بروزرسانی" >
			<a class="btn btn-primary " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewOrderFinancialDetail/'.$userOrder->id.'">تراکنش مالی سفارش</a>
			</div>
			<div id="hiddenInDiv" style="display:none"></div>
			</form>';
			$body.='
			
			
			
			
		';
		
		$body .= '
		<div class="col-sm-12">
			<div id="checkResult" class="col-sm-6 pull-right">
			</div>
		</div>
		</div>';
		
		$body .= '<script>
		$("#checkResult").hide("fast");
		function checkForm() 
		{
			result  = "" ;
			id = $( "#status" ).val();
			if(id  < 1 ){
				result = result + "وضعیت مالی جدید سفارش انتخاب نشده است.<br/>" ;
			}
			if(id == 3){
				if($("#bankDate").val()  < 1 ){
					result = result + "تاریخ وارد نشده است.<br/>" ;
				}
				if($("#bankBank").val()  < 1 ){
					result = result + "بانک وارد نشده است.<br/>" ;
				}
				if($("#bankName").val()  < 1 ){
					result = result + "نام صاحب حساب وارد نشده است.<br/>" ;
				}
				if($("#bankValue").val()  < 1 ){
					result = result + "مبلغ چک وارد نشده است.<br/>" ;
				}
				if($("#bankPay").val()  < 1 ){
					result = result + "در وجه وارد نشده است.<br/>" ;
				}
			}
			else if(id == 4){
				if($("#timeWarranty").val()  < 1 ){
					result = result + "ضمانت پرداخت وارد نشده است.<br/>" ;
				}
				if($("#timeDate").val()  < 1 ){
					result = result + "زمان تسویه وارد نشده است.<br/>" ;
				}
				if($("#timeValue").val()  < 1 ){
					result = result + "مبلغ کل وارد نشده است.<br/>" ;
				}
			}
			if(result.length > 1 )
			{
				$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا های زیر را بررسی کنید : <br/>"+ result) ;
				$("#checkResult").show("slow");
				return false ; 
			} 
			$("#checkResult").hide("slow");
			createElement();
			return true ;
		}
		selectedRow ='.$statusIdTemp.';';
		
		$body .= "
		if(selectedRow == 3){
			$('#financialOption3').show('slow');
		}else if(selectedRow == 4){
			$('#financialOption4').show('slow');
		}
		$('select').on('change', function() {
			$('#financialOption3').hide('slow');
			$('#financialOption4').hide('slow');
			newValue = this.value;
			if(newValue == 3){
				$('#financialOption3').show('slow');
			}else if(newValue == 4){
				$('#financialOption4').show('slow');
			}
		})";
		$body .= '</script>';
		
		
		$inf['title'] = $inf['page_title'].': '.$userOrder->id;
		$inf['body'] = $body;
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
	}
}


//class
if (!defined("GSMS")) {
    exit("Access denied");
}