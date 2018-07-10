<?php
class RegisterOrderPrice
{
	function RegisterOrderPrice($temp)
	{
		//var_dump($temp);
		//---------------initializing-----------
		$inf = array('page_title' => 'ثبت هزينه سفارش','activeTab' => 'orders');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'admin_header');
		//-------------------
		$body = '';
		if($temp==null){
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">سفارشي يافت نشد</div>';
			$inf['body'] = $body ;
			$inf['title'] = 'خطا';
			GSMS::$class['template']->load($inf,'admin_index');
			GSMS::$class['template']->load($inf,'admin_footer');
			return ;
		}
		
		$userOrder=$temp['userOrder'];
		$printCost=$userOrder->printPrice;
		$servicesCompCost=$userOrder->servicePrice;//khadamat takmili
		$servicesCost=0;//hazineh service
		
		if(is_array($userContent))
		{
			foreach($userContent as $value) 
			{
				$countTemp=intval($value['count']);
				$priceTemp=intval($value['price']);
				$servicesCost+=$countTemp*$priceTemp;
			}
		}
		$totalCost = $printCost+$servicesCost+$servicesCompCost;
		
		$body .= '
		<div class="message-info" style="text-shadow: 0px 0px 1px #96ECFF;  color: #0F6D73;">
		<div class="row"  >
			لطفا جهت تولید فاکتور سفارش کاربر را انتخاب نمایید :
		</div>
		<form method ="POST" enctype="multipart/form-data" onSubmit="return checkForm()">
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
						<label class="control-label">هزینه چاپ (ريال)</label>
						<input id="printCost" name="printCost" type="text" class="form-control" value="'.$printCost.'">
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">هزینه خدمات تکمیلی (ريال)</label>
						<input id="servicesCompCost" name="servicesCompCost" type="text" class="form-control" value="'.$servicesCompCost.'">
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
			if($("#printCost").val()  < 1 ){
					result = result + "هزینه چاپ وارد نشده است.<br/>" ;
			}
			if($("#servicesCompCost").val()  < 1 ){
					result = result + "هزینه خدمات تکمیلی وارد نشده است.<br/>" ;
			}
			if($("#servicesCost").val()  < 1 ){
					result = result + "هزینه سرویس ها وارد نشده است.<br/>" ;
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
		
		$inf = array('title' =>  'ثبت هزينه سفارش شماره: '.$userOrder->id, 'body' => $body);
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
	}
}


//class
if (!defined("GSMS")) {
    exit("Access denied");
}

?>