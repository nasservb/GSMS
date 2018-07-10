<?php //allahoma sale ala mohammad va ale mohammad

// class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class insertReceipt
{
	function insertReceipt($temp)
	{
		$inf = array(
			'page_title' => 'ثبت فیش بانکی',
			'activeTab' => 'accounting'
		);
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		
		if ($temp['factureId'] > 0)
		{
			$temp['manualtransaction']['comment'] = 'واریز بابت باقی مانده حساب صورتحساب به شماره ی ' . $temp['factureId'];
		}
		elseif (intval($temp['type']) > 1)
		{
			$temp['manualtransaction']['comment'] = 'واریز بابت باقی مانده حساب فاکتور به شماره ' . $temp['factureId'];
			$temp['manualtransaction']['totalAmount'] = $temp['total'];
		}
		
		$userId = $temp['userid'];
		
		$body ='<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/dropzone.css" type="text/css" rel="stylesheet" />
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/dropzone.min.js"></script>';
		
		$body .= '
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/jquery.maskedinput.min.js"></script>
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/jquery.validation.js"></script>
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#dateDeposit").persianDatepicker();            
			});
		</script>
		';
		
		$body.= '
	
		<div class="message-info" style="    text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		 
		<div align="right" style="font-size:13pt;line-height: 30px;">
			 لطفااطلاعات واریزی خود را وارد نمایید  
			<br/>
			 
		</div>
		<br/>
		<form id="registerForm" method="POST" action ="' . GSMS::$class['template']->info['user_url'] . 'accounting/insertReceipt" 
		enctype="multipart/form-data" >
			
			<div id="notif"></div>
			
			<input type="hidden" name="factureid" id="factureid"  value="' . ($temp['factureId'] > 0 ? $temp['factureId'] : '') . '" />
			
			<input type="hidden" name="id" id="id"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->id : '0') . '" />


			<div class="row">
				<div class="col-md-6">
					<div class="form-group   is-empty">
						<label class="control-label">نوع سند *</label>
						<select name="manualtransTypeId" id="manualtransTypeId"class="form-control">';
		foreach($temp['manualType'] as $value)
		{
			if (is_object($temp['manualtransaction']))
			{
				if ($temp['manualtransaction']->manualtransTypeId == $value['id'])
				{
					$tempOption = '<option value="' . $value['id'] . '" selected="selected">' . $value['name'] . '</option>';
				}
				else
				{
					$tempOption = '<option value="' . $value['id'] . '" >' . $value['name'] . '</option>';
				}
			}
			elseif (intval($temp['type']) > 1)
			{
				if ((intval($value['id']) == 6) && (intval($temp['type']) == 2))
				{
					$tempOption = '<option value="' . $value['id'] . '" selected="selected">' . $value['name'] . '</option>';
				}
				elseif ((intval($value['id']) == 7) && (intval($temp['type']) == 3))
				{
					$tempOption = '<option value="' . $value['id'] . '" selected="selected">' . $value['name'] . '</option>';
				}
				else
				{
					$tempOption = '<option value="' . $value['id'] . '" >' . $value['name'] . '</option>';
				}
			}
			else
			{
				$tempOption = '<option value="' . $value['id'] . '" >' . $value['name'] . '</option>';
			}

			$body = $body . $tempOption;
		}

		$body = $body . '</select><span id="domainResult"></span>
		
		
		<span class="material-input"></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group label-floating is-empty">
			<label class="control-label">نام شخص /شرکت واریز کننده* </label>
			<input type="text" class="form-control" name="name" id="name"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->name : '') . '" /> 
		<span class="material-input"></span>
		</div>
	</div>	
	<div class="col-md-6">
		<div class="form-group label-floating  is-empty">
			<label class="control-label">مبلغ واریزی (ریال)*</label>
			<input type="text" class="form-control"  name="totalAmount" id="totalAmount"  value="' . $temp['manualtransaction']['totalAmount'] . '" />
		<span class="material-input"></span>
		</div>	
	</div>	

	<div class="col-md-6">
		<div class="form-group label-floating  is-empty">
			<label class="control-label">شماره فیش *</label>
			<input type="text" class="form-control" name="refNum" id="refNum"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->refNum : '') . '" /> 
		<span class="material-input"></span>
		</div>	
	</div>	
	<div class="col-md-6">
		<div class="form-group  label-floating is-empty">
			<label class="control-label">نام بانک *</label>
			<input type="text" class="form-control" name="nameBank" id="nameBank"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->nameBank : '') . '" />
		<span class="material-input"></span>
		</div>	
	</div>	

	<div class="col-md-6">
		<div class="form-group label-floating  is-empty">
			<label class="control-label">کد شعبه </label>
			<input type="text" class="form-control" name="branchCode" id="branchCode"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->branchCode : '') . '" />			
		<span class="material-input"></span>
		</div>	
	</div>	
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">تاریخ واریز</label>
			<input type="text" class="form-control" name="dateDeposit" id="dateDeposit"  value="'.
			(is_object($temp['manualtransaction']) ? $temp['manualtransaction']->dateDeposit : '') . '" />
		<span class="material-input"></span>
		</div>	
	</div>	

	<div class="col-md-6">
		<div class="form-group label-floating  is-empty">
			<label class="control-label">واریز به شماره حساب </label>
			<input type="text" class="form-control" name="depositAccountnum" id="depositAccountnum"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->depositAccountnum : '') . '" /> 		
			<span class="material-input"></span>
		</div>	
	</div>	
	<div class="col-md-6">
		<div class="form-group  label-floating is-empty">
			<label class="control-label">شماره تماس</label>			 
			 <input type="text" class="form-control" name="phone" id="phone"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->phone : '') . '"  />
			<span class="material-input"></span>
		</div>	
	</div>	


	<div class="col-md-6">
		<div class="form-group label-floating  is-empty">
			<label class="control-label">ایمیل </label>
			<input class="form-control" type="text" name="email" id="email"  value="' . (is_object($temp['manualtransaction']) ? $temp['manualtransaction']->email : '') . '"  /> 	
			<span class="material-input"></span>
		</div>	
	</div>	
	
</div>

<div class="row col-md-12">
	<div class="col-md-6">
		<div class="form-group label-floating  is-empty">
			<label class="control-label">بابت(دلیل واریز) </label>			 
			 <textarea class="form-control" type="text" name="comment" id="comment" >' . str_replace('<br/>', "\n", $temp['manualtransaction']['comment']) . '</textarea>			  
			<span class="material-input"></span>
		</div>	
	</div>	
</div>	
	</form>
	
	<div class="col-sm-12" style="border: 1px solid #1c44d5; border-radius: 5px; padding: 15px;">
		<div class="col-md-4 col-sm-12">
		 فایل سفارش <br />
			(عکس)
		</div>
		<div class="col-md-8 col-sm-12">
			<div id="dropzone" class="dropzone"></div>
			<script>var myDropzone = new Dropzone("#dropzone", { 
			url: "' . GSMS::$class['template']->info['user_url'] . 'accounting/uploadAjaxFile/'.$userId.'"});</script>
		</div>
	</div>
	<br/>
	
	<div class="col-md-12">	 		 
		<input type="submit" class="btn btn-success" type="button" onclick="checkForm()" value="ثبت اطلاعات فیش شما "  />	  	  
	</div>
	<br/>
	<div id="checkResult" class="col-sm-12 "></div>
	</div>
	
	<script>
	//checkForm();
		$("#checkResult").hide("fast");
		function checkForm()
		{
			$("#checkResult").hide("fast");
			result  = "" ; 
			
			if($("#name").val()  < 3 )
				result = result + "نام واریز کننده به درستی وارد نشده است .<br/>" ;	
			
			if( !($.isNumeric($("#totalAmount").val())) )
					result = result + "مبلغ واریزی باید عدد باشد. <br/>" ;
				
			if($("#refNum").val()  < 3 )
				result = result + "شماره فیش به درستی وارد نشده است .<br/>" ;	
			
			if($("#nameBank").val()  < 3 )
				result = result + "نام یانک به درستی وارد نشده است .<br/>" ;	
			
			if($("#branchCode").val()  < 3 )
				result = result + "کد شعبه به درستی وارد نشده است .<br/>" ;	
			
			if($("#dateDeposit").val()  < 3 )
				result = result + "تاریخ واریز به درستی وارد نشده است .<br/>" ;	
			
			if($("#depositAccountnum").val()  < 3 )
				result = result + "شماره حساب به درستی وارد نشده است .<br/>" ;	
			
			if($("#phone").val()  < 3 )
				result = result + "شماره تماس به درستی وارد نشده است .<br/>" ;	
			
			if($("#email").val()  < 3 )
				result = result + "ایمیل به درستی وارد نشده است .<br/>" ;
			
			
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
	</script> 
	
	';
	
		
		
		$inf = array(
			'title' => 'ثبت فیش بانکی',
			'body' => $body
		);
		GSMS::$class['template']->load($inf, 'user_index');
		GSMS::$class['template']->load($inf, 'user_footer');
	}
}

// class

if (!defined("GSMS"))
{
	exit("Access denied");
}
