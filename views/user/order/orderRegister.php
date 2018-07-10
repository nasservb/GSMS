<?php
class orderRegister
{
	function orderRegister($info)
	{		
        $inf = array(
            'page_title' => 'سفارش چاپ جدید  ','activeTab'=>'orders'
        );
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'user_header');
        
        $msg='';
		

        $servicesSizes = $info['serviceSize'];
		
        $servicesTypes = $info['servicesTypes'];
		
        $services=$info['services'];
		
		
		 
        $userOrder=$info['userOrder'];

		$orderTypeOptions = $info['orderTypeOptions'];

		$dynamicCheck = [];
		$iTemp = 0;

		for($i = 0 ; $i < count($orderTypeOptions) ;$i++ ){

			$optionValue = $orderTypeOptions[$i];

			if (is_object($userOrder))
			{

				foreach ($info['orderOptionValue'] as $userOption) {

					if (intval($userOption['order_option_id']) == intval($orderTypeOptions[$i]['id']))
					{
						if ($optionValue['type'] == 'combobox')
						{
					 		$orderTypeOptions[$i]['selected_item'] =$userOption['option_item_id'];
					 	}
						else if ($optionValue['type'] == 'edittext') 
						{
							$orderTypeOptions[$i]['selected_item'] =$userOption['option_value'];
						}
					}
					
				 } ;   
			}

			if(strcmp($optionValue['type'], 'edittext') == 0){
				$dynamicCheck[$iTemp]['htmlName'] = $optionValue['html_name'];
				$dynamicCheck[$iTemp]['value'] = $optionValue['value'];
				$iTemp++;
			}
		} 
		


        if(is_object($userOrder)){
			$userContent=$info['userContent'];
        }
		
		$sendOptions = ''; 
		foreach ($info['orderSend'] as $send)
		{
			$sendOptions .= '<option value="'.$send['id'].'" '.(is_object($userOrder)&& $userOrder->orderSendId==$send['id'] ? 'selected' : "" ) .'>'.$send['title'].'</option>'; 
		}
		
		$optionBody = '';
		GSMS::load('formcreator','libs','','require');
		$temp = new formcreator();
		$optionBody = $temp->createForm($orderTypeOptions);
		
        $servicePrice=0;
		$body ='<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/dropzone.css" type="text/css" rel="stylesheet" />
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/dropzone.min.js"></script>';
		
        $body .= (!is_object($userOrder)  ? '
        <br/>
       
        <div style="width: 85%;
                    height: 8px;
                    background-color: #C9D1D7;
                    border-radius: 15px;
                    margin: 15px;
                    position: relative;">

                        <div class="progress_bg" style="width:2%"></div>
                    <span style="background-position: -2px -33px;right: 2%;" class="step-item">
                    <a class="s_title" href="#"  style="color:blue;">
                    سفارش     
                    </a></span>
                                                                    
                    <span style="background-position: -2px -70px;right: 50%;" class="step-item">
                    <a>
                    بازبینی 
                    </a></span>
                    <span style="background-position: -2px -70px;right: 100%;" class="step-item">
                    <a>
                      پرداخت
                    </a></span>
                    
        </div>
          ':'<h3> ویرایش سفارش شماره  '.$userOrder->id  .'</h3>' ).' <br>               
        <div class="message-info">
        جزئیات سفارش خود را ثبت کنید
        <br/>
        
        <form id="registerForm" method ="POST" >
		<input type="hidden" name="is_edit" value="'.(is_object($userOrder)? '1':'').'" />
		 
        <div id="notif"></div>
        <div id="hiddenInDiv" style="width: 0px; height: 0px;">';
        
        
        $body.='</div>';
        if(!is_null($msg))
			$body .= $msg;
        $body .='
<table class="table table-hover">
	<tr>
	 <style>
			.card img {width:15%}
		</style>
		<td >نوع فرم <span style="color:red">*</span>:</td>
		<td style="width:75%;">
			<select onchange="serviceTypeChanged()" name="serviceType" id="serviceType" >
				<option selected disabled value="0" >انتخاب کنید</option>';
				foreach ($servicesTypes as $value) 
				{
					$tempOption = '<option  value="' . $value['id']. '" '.(is_object($userOrder)&& $userOrder->serviceTypeId==$value['id'] ? 'selected' : "" ) .'  >' . $value['title'] . '</option>';
					$body = $body . $tempOption;
				}
				$body = $body . '
			</select>
		</td>
	</tr>
	<tr>
		<td>عنوان سفارش <span style="color:red">*</span>:</td>
		<td style="width:75%;">
			<select onchange="serviceChanged()"  name="subService" id="subService" >
			</select>
		</td>
	</tr>
	<tr>	
		<td>قیمت واحد :</td>
		<td style="width:75%;"><input 
										style="background-color: #ecf1f1;color: #484850;" 
										id="servicePrice" name="servicePrice" 
										type="text" data-toggle="popover" readonly/></td>
	</tr>
	<tr>
		<td>ابعاد سفارش:</td>
		<td style="width:75%;">
			<select   
				onchange="serviceChanged()" 
				name="serviceSize" 
                id="serviceSize"  />
			</select>
		</td>
	</tr>
	<tr>
		<td>تیراژ / تعداد سفارش <span style="color:red">*</span>:</td>
        <td>
            <select  
                name="orderCount" 
                id="orderCount"  
				 onchange="serviceChanged()" 
                >
				<option value="1" '.(is_object($userOrder)&& $userOrder->count==1 ? 'selected' : "" ).'>یک سری</option>
				<option value="2" '.(is_object($userOrder)&& $userOrder->count==2 ? 'selected' : "" ).'>دو سری</option>
				<option value="3" '.(is_object($userOrder)&& $userOrder->count==3 ? 'selected' : "" ).'>سه سری</option>
				<option value="4" '.(is_object($userOrder)&& $userOrder->count==4 ? 'selected' : "" ).'>چهارسری</option>
				<option value="5" '.(is_object($userOrder)&& $userOrder->count==5 ? 'selected' : "" ).'>پنج سری</option>
				<option value="6" '.(is_object($userOrder)&& $userOrder->count==6 ? 'selected' : "" ).'>شش سری</option>
				<option value="7" '.(is_object($userOrder)&& $userOrder->count==7 ? 'selected' : "" ).'>هفت سری</option>				
				<option value="8" '.(is_object($userOrder)&& $userOrder->count==8 ? 'selected' : "" ).'>هشت سری</option>
				 	 	
			</select>
        </td>
    </tr>
	';
		$body .=$optionBody . '
		<tr><td valign="top" style="width:150px" >خدمات کار تکمیلی:</td>
        <td>
            <div style="text-align: right;">';
            if(is_object($userOrder))
			{
				$tempStr=trim($userOrder->serviceId);
				$tempArray=[];
				if(!empty($tempStr))
				{
					$tempArray=explode(',', $tempStr);
				}
			}
            foreach ($info['orderServices'] as $value) 
			{
				$tempOption = '
                <label style="float:right; padding-left:10px; width:250px;">
                    <input id="service" name="check_list[]" value="' . $value['id'] . '" style="width:25px; height:25px" 
                    type="checkbox" '.(is_object($userOrder)&&is_array($tempArray)&&in_array($value['id'], $tempArray) ? " checked" : "" ).'>' . $value['service'] . '</label>
                ';
            $body= $body . $tempOption;
            }
        $body = $body . '</div>
        </td>
		
        </tr>
		';
            
        $body = $body . '		
    <tr>
		<td>سریال :</td>
		<td>
			<label style="float:right; padding-left:10px; width:250px;">
            <input id="checkSerial" name="checkSerial" value=""
					style="width:25px; height:25px" onChange="serialToggle()"
                    type="checkbox"  '.(is_object($userOrder)&& ($userOrder->isCheckSerial==0) ? "" : " checked" ).' > بدون شماره سریال</label>
		
		</td>
    </tr>
	<tr >
		<td>شماره :</td>
		<td>
			از شماره
				<input id="serial1" name="serial1" value="'.(is_object($userOrder) ? $userOrder->serial1 : "0" ).'"
					style="width:50px; " 
                    type="text" disabled >
			تا شماره
				<input id="serial2" name="serial2" value="'.(is_object($userOrder) ? $userOrder->serial2 : "0" ).'"
					style="width:50px; " 
                    type="text" disabled >
		</td>
    </tr>
    <tr>
		<td valign="top">توضیحات <span style="color:red">*</span>:</td>
        <td>
            <textarea 
                style="height:100px; width:75%; font-size:13px"
                type="text" 
                name="description" 
                id="description"  
                data-toggle="popover"
                >'.(is_object($userOrder) ? $userOrder->description : "" ).'</textarea>
        </td>
    </tr> 
	<tr>
		<td>نحوه ارسال <span style="color:red">*</span>:</td>
        <td>
            <select  
				style="width:25% " 
                name="orderSend" 
                id="orderSend"   
                >
				 	'.$sendOptions.'
			</select>
        </td>
    </tr>'; 


if (is_object($userOrder))
{


	$body .='<tr>
			<td> تصاویر</td>
        	<td></td>
        </tr>
        <tr>
       	 	<td></td>
       	 	<td>
        ';
				
		for($i=0 ; $i < count($info['orderPictures']) ; $i++){
					 
				$body .= '
							<a class="image-popup-vertical-fit" href="'.							
								GSMS::$class['template']->info['index_url'].'coverView/'.$info['orderPictures'][$i]->Id						
							.'" >
							<img width="10" height="10" src="'.							
							GSMS::$class['template']->info['index_url'].'iconView/'. $info['orderPictures'][$i]->Id							
							.'" /> 
							</a>
						';
					
		}
	$body .='<tr>
		<td>نحوه ارسال <span style="color:red">*</span>:</td>
        <td>
            <select  
				style="width:25% " 
                name="orderSend" 
                id="orderSend"   
                >
				 	'.$sendOptions.'
			</select>
        </td>
    </tr>';
}

 $body =  $body.'</table>
      
    <br>
    
	<br/>
        <div class="finalprice pull-left" >
				<div class="total">
						جمع کل فاکتور:					
					<span id="printPrice" class="left " style="color: #0C81F9;font-size: 13pt;">
					'.(is_object($userOrder) ? number_format($userOrder->printPrice) : "0" ).'
						<span class="toman">ریال</span>						
					</span>
					<input type="hidden" name="printPriceInput" id="printPriceInput" value="'.(is_object($userOrder) ? number_format($userOrder->printPrice) : "0" ).'" />
					<br/>
				</div>
			</div> ';
	
	$checkDynamicScript ='';
	foreach($dynamicCheck as $tempValueDy){
		$checkDynamicScript .= '
		if($("#'.$tempValueDy['htmlName'].'").val()  < 1 )
			result = result + "  '.$tempValueDy['value'].' به درستی وارد نشده است .<br/>" ;
		';
	}
    
    $body.='
	</form>
	<div class="col-sm-12" style="border: 1px solid #1c44d5; border-radius: 5px; padding: 15px;">
		<div class="col-sm-12">
			<div class="col-md-4 col-sm-12">
			 فایل سفارش <br>
				(لطفآ فقط فایل JPG با رزولیشن 300dpi را آپلود کنید .)
			</div>
			<div class="col-md-8 col-sm-12">
				<div id="dropzone" class="dropzone"></div>
				<script>var myDropzone = new Dropzone("#dropzone", { 
				url: "' . GSMS::$class['template']->info['user_url'] . 'orders/uploadAjaxFile/'.$userOrder->id.'"});</script>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12">
		<input class="btn btn-success" type="button" onclick="checkForm()"
		title="'.($info['isEdit']==0 ? 'بازبینی اطلاعات و مرحله بعد' : 'ویرایش اطلاعات').'" 
		value="'.($info['isEdit']==0 ? 'بازبینی اطلاعات و مرحله بعد' : 'ویرایش اطلاعات').'"
		/>
		<a class="btn btn-default" href="javascript:void(0)" onClick="' . GSMS::$class['template']->info['user_url'] . 'orders">برگشت</a>
	</div>
    <br/>
	<div id="checkResult" class="col-sm-12 "></div>
        </div>
	<script>
';

if (is_object($userOrder))
{
	$body .= '
	document.addEventListener("DOMContentLoaded", function(event) { 
   
			serviceTypeChanged();
	
			serviceChanged();
				
			$("#serviceType").val("'.$userOrder->serviceTypeId.'");
			$("#subService").val("'.$userOrder->subServiceId.'");
			$("#serviceSize").val("'.$userOrder->serviceSizeId.'");
			serialToggle();

			//@TODO 
			//remove prev pic option for user
			var pic_array = '. json_encode($info['orderPictures'] ) . ';	

			
	});
				

				';
	
}


	$body .= '	$("#checkResult").hide("fast");
			function checkForm() 
			{
				$("#checkResult").hide("fast");
				result  = "" ; 
				
				
				
				
				if($("#serviceType").val()  == null )
					result = result + "  لطفآ عنوان فرم را انتخاب نمائید .<br/>" ;
				 
				if($("#orderCount").val()  == 0 )
					result = result + "  تیراژ به درستی وارد نشده است .<br/>" ;
				 
				if( $("#description").val().length < 5 )
					result = result + "   توضیحات به درستی وارد نشده است . <br/>" ;
				'.$checkDynamicScript.'
				
				
				
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
    <script>
    
   
    ';
	
    $body.= "var js_array = ". json_encode($services) . ';';
	
    $body .= 'var servicesTypesArray= ' . json_encode($servicesTypes).'; ';
	
    $body .= 'var servicesSizeArray= ' . json_encode($servicesSizes).';';
	
    $body .= 'var servicesPriceArray= ' . json_encode($info['servicesPrices']).';';
	 
	
    $body.= '

	var servicePrice='.$servicePrice.';
	totalServicePrice = document.getElementById("servicesPrice");
	
    function serviceTypeChanged() 
	{
		 
		$("#subService").find("option").remove();
		
		var sericeSelId=$( "#serviceType option:selected" ).val();
		var sel = document.getElementById("subService");
		
		for (i = 0; i < js_array.length; i++) 
		{
			id = js_array[i].type_id;
			if(sericeSelId == id)
			{
				var opt = document.createElement("option");
				opt.innerHTML = js_array[i].title;
				opt.value = js_array[i].id;
				sel.appendChild(opt);
			}
		}
		
		var serviceTypeId = $( "#serviceType option:selected" ).val();
		
		var selSize = document.getElementById("serviceSize");
		
		for (i = 0; i < servicesTypesArray.length; i++) 
		{
			if(serviceTypeId == servicesTypesArray[i].id )
			{
				availableSize = servicesTypesArray[i].available_size.split(",");
				$("#serviceSize").find("option").remove();
				
				for (j = 0; j < availableSize.length; j++)
				{
					var opt = document.createElement("option");
					opt.innerHTML = servicesSizeArray[availableSize[j]].title;
					opt.value = servicesSizeArray[availableSize[j]].id;
					selSize.appendChild(opt);
				}					
			}
		}
		
		serviceChanged();
    }
    
    function serviceChanged()
	{
		var serviceSelId=$( "#subService option:selected" ).val();
		
		var serviceSizeId=$( "#serviceSize option:selected" ).val();
		
		var printCount=$( "#orderCount option:selected" ).val();
		
		for (i = 0; i < servicesPriceArray.length; i++) 
		{
			
			if(serviceSelId == servicesPriceArray[i].service_id && serviceSizeId==servicesPriceArray[i].size)
			{
				var d= 123; 
				d = parseInt(servicesPriceArray[i].price,10);
				
			
				document.getElementById("servicePrice").value = d.toLocaleString("us", {minimumFractionDigits: 0, maximumFractionDigits: 0})+"ریال";
				
				d=(d*printCount);
				document.getElementById("printPrice").innerHTML = d.toLocaleString("us", {minimumFractionDigits: 0, maximumFractionDigits: 0}) + " <span class=\"toman\">ریال</span>" ;
				document.getElementById("printPriceInput").value = d ;
			}
		}
		
    }
	
    function serialToggle()
	{
		if ($("#checkSerial").prop("checked") == true )
		{
			$("#serial1").prop("disabled", true);
			$("#serial2").prop("disabled", true);
		}
		else 
		{			
			$("#serial1").prop("disabled", false);
			$("#serial2").prop("disabled", false);
		}
		
		
	}
    </script>    ';        
        

        
        $inf = array(
            'title' => 'تکمیل اطلاعات سفارش',
            'body' => $body
        );
        GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
    }
    
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
?>
