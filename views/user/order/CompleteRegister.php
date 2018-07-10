<?php
class CompleteRegister
{
	function CompleteRegister($info)
	{
		
        $inf = array(
            'page_title' => 'تکمیل اطلاعات سفارش','activeTab'=>'orders'
        );
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'user_header');
        
        $msg='';

        $servicesTypes = $info['servicesTypes'];
        $services=$info['services'];

        $userOrder=$info['userOrder'];
        if(is_object($userOrder)){
			$userContent=$info['userContent'];
        }
        $servicePrice=0;
        $body = '
        <br/>
        <div style="width: 85%;
                    height: 8px;
                    background-color: #C9D1D7;
                    border-radius: 15px;
                    margin: 15px;
                    position: relative;">

                        <div class="progress_bg" style="width:50%"></div>
                    <span style="background-position: -2px -2px;" class="step-item">

                    <a href="#" style="color:black;">
                    ورود به سایت
                    </a></span>
                    
                    <span style="background-position: -2px -2px;right: 25%;" class="step-item">
                    <a class="s_title" href="#"  style="color:black;">
                    ثبت سفارش    
                    </a></span>
                    
                    <span style="background-position: -2px -36px;right: 50%;" class="step-item">
                    <a class="s_title" href="#"  style="color:blue;">
                    تکمیل اطلاعات سفارش    
                    </a></span>
                                                                    
                    <span style="background-position: -2px -70px;right: 75%;" class="step-item">
                    <a>
                    بازبینی اطلاعات
                    </a></span>
                    <span style="background-position: -2px -70px;right: 99%;" class="step-item">
                    <a>
                    انتخاب روش پرداخت
                    </a></span>
                    
        </div>
                    
        <div class="message-info">
        سفارش خود را ثبت کنید
        <br/>
        
        <form method ="POST" action="' . GSMS::$class['template']->info['user_url'] . 'orders/completeRegister">
        <div id="notif"></div>
        <div id="hiddenInDiv" style="width: 0px; height: 0px;">';
        
        if(is_object($userOrder) && is_array($userContent))
		{
			foreach($userContent as $contValue) 
			{
				$body.='<input id="hidIn'.$contValue['random'].'" name="inSerives[]" type="hidden" value="'.$contValue['id'].','.$contValue['count'].'">';
			}	
			
        }
        
        $body.='</div>';
        if(!is_null($msg))
			$body .= $msg;
        $body .='
       <table style="width:100%;" dir="rtl">
        <tr><td>تیراژ / تعداد سفارش:</td>
        <td>
            <input 
				style="width:25%; font-size:13px"
                type="text" 
                name="orderCount" 
                id="orderCount"  
                data-toggle="popover" 
                data-content="تیراژ / تعداد سفارش" 
                value="'.(is_object($userOrder) ? $userOrder->count : "" ).'"
                />
        </td>
        </tr>
        
        <tr><td>شماره موبایل</td>
        <td>
            <input 
				style="width:25%; font-size:13px"
                type="text" 
                name="mobile" 
                id="mobile"  
                data-toggle="popover" 
                value="'.(is_object($userOrder) ? $userOrder->ownerMobile : "" ).'"
                />
        </td>
        </tr>
      
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
        <tr><td valign="top">توضیحات:</td>
        <td>
            <textarea 
                style="height:100px; width:25%; font-size:13px"
                type="text" 
                name="description" 
                id="description"  
                data-toggle="popover"
                >'.(is_object($userOrder) ? $userOrder->description : "" ).'</textarea>
        </td>
        </tr> 
        </table>
        <table style="width:100%;" dir="rtl">
        <tr>
        <td style="width:25%;">
        <select onchange="serviceTypeChanged()" name="serviceType" id="serviceType" >
			<option selected disabled value="0" >انتخاب کنید</option>';
			foreach ($servicesTypes as $value) 
			{
				$tempOption = '<option  value="' . $value['id'] . '">' . $value['title'] . '</option>';
				$body = $body . $tempOption;
			}
        $body = $body . '</select>
        </td>
        <td style="width:25%;">
        <select onchange="serviceChanged()"  name="service2" id="service2" >
        </select>
        </td>
        <td style="width:15%;">
			<input id="servicePriceTd" type="text" data-toggle="popover" disabled/>
        </td>
        <td style="width:15%;"><input id="serviceCount" type="text" data-toggle="popover"/></td>
        <td style="width:15%;"><a  id="addServiceBtn" class="btn btn-primary disabled">اضافه</a></td>
        </tr>
    </table>
    
    <table id="selectedServiceTable" class="table table-hover table-striped table-bordered" 
       cellspacing="0" style="border-collapse:collapse;" dir="rtl">
        <tr>
        <td>نوع سرویس</td>
        <td>نام سرویس</td>
        <td>تعداد</td>
        <td>قیمت پایه</td>
        <td>حذف</td>';
        if(is_object($userOrder)&& is_array($userContent))
		{
			foreach($userContent as $contValue) 
			{
				$servicePrice+=intval($contValue['count'])*intval($contValue['price']);
				$body.='<tr id="row'.$contValue['random'].'"><td>'.$contValue['type'].'</td>
				<td>'.$contValue['service'].'</td>
				<td>'.$contValue['count'].'</td>
				<td>'.$contValue['price'].'</td>
				<td><a href="javascript:remove('.$contValue['random'].');">sasa</a></td></tr>';
			}
        }
        $body.='</table>
        <div class="finalprice pull-left" >
				<div class="total">
						جمع هزینه سرویس ها:					
					<span id="servicesPrice" class="left " style="color: #0C81F9;font-size: 13pt;">
					'.$servicePrice.'
						<span class="toman">ریال</span>
					</span>
					<br/>
				</div>
			</div> ';
    
    $body.='<button style="height:60px; padding-top:10px; font-weight: bold; margin-top:25px;" class="btn btn-success btn-register" type="submit">
	بازبینی اطلاعات
	</button>
    </form><br/>
        </div>
        
    <script>
    
    var oldCount = $( "#serviceCount" ).val();
    
    $("#serviceCount").on("change paste keyup", function() {
		var newCount = $(this).val();
		if(oldCount != newCount)
			checkAddServiceBtnState();
	});
    
    
    function checkAddServiceBtnState(){

		var temp = $( "#serviceType option:selected" ).val();
		var temp2 = $( "#serviceCount" ).val();
		if(temp != 0 && Math.floor(temp2) == temp2 && $.isNumeric(temp2)){

			addServiceBtnEnable();
		}else if(!(Math.floor(temp2) == temp2 && $.isNumeric(temp2))){

			addServiceBtnDisable();
		}
    }
    
    function addServiceBtnDisable()
	{
		document.getElementById("addServiceBtn").onclick="";
		$("#addServiceBtn").addClass("disabled");
    }
    
    function addServiceBtnEnable()
	{
		
		document.getElementById("addServiceBtn").onclick= function tesr(){addServiceClicked();};
		
		$("#addServiceBtn").removeClass("disabled");
    }
    
    ';
    $body.= "var js_array = ". json_encode($services) . ';
    ';
    $body .= 'var servicesTypesArray= ' . json_encode($servicesTypes).';
    ';
    $body.= '

	var servicePrice='.$servicePrice.';
	totalServicePrice = document.getElementById("servicesPrice");
    function serviceTypeChanged() 
	{
		checkAddServiceBtnState();
		$("#service2").find("option").remove();
		
		var sericeSelId=$( "#serviceType option:selected" ).val();
		var sel = document.getElementById("service2");
		
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
		serviceChanged();
    }
    
    function serviceChanged()
	{
		var sericeSelId=$( "#service2 option:selected" ).val();
		for (i = 0; i < js_array.length; i++) 
		{
			id = js_array[i].id;
			if(sericeSelId == id)
			{
				document.getElementById("servicePriceTd").value = js_array[i].price;
			}
		}
		
    }
    
    function addServiceClicked(){
		var serviceTypeId = $( "#serviceType option:selected" ).val();
		var sericeSelId=$( "#service2 option:selected" ).val();

		var count= document.getElementById("serviceCount").value;
		var serviceTypeVal;
		var sericeSelVal;
		var sericeSelId;
		var price;
		for (i = 0; i < servicesTypesArray.length; i++) 
		{
			id = servicesTypesArray[i].id;
			if(serviceTypeId == id)
			{
				serviceTypeVal=servicesTypesArray[i].title
				break;
			}
		}
		
		for (i = 0; i < js_array.length; i++) 
		{
			id = js_array[i].id;
			if(sericeSelId == id)
			{
				sericeSelVal=js_array[i].title;
				sericeSelId=js_array[i].id;
				price = js_array[i].price;
				var t = parseInt(price, 10);
				t = t*count;
				servicePrice +=t;
				break;
			}
		}
		
		
		

		totalServicePrice.innerHTML=servicePrice;
		
		var table = document.getElementById("selectedServiceTable");
		var rowNumber=table.rows.length;
		
		var row = table.insertRow(table.rows.length);
		
		var tempRandom = Math.floor(Math.random() * 10000) + 1;
		
		var hiddenInDiv= document.getElementById("hiddenInDiv");
		var input = document.createElement("input");
		input.type = "hidden";
		
        input.name = "inSerives[]";
        input.id = "hidIn"+tempRandom;
        input.value=sericeSelId+","+count;
        hiddenInDiv.appendChild(input);
    
        hiddenInDiv.appendChild(document.createElement("br"));
		
		var tempRowId="row"+tempRandom;
		row.id = tempRowId;
		
		// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		var tttt="<a href=\"javascript:remove("+tempRandom+");\" >حذف</a>";
		
		// Add some text to the new cells:
		cell1.innerHTML = serviceTypeVal;
		cell2.innerHTML = sericeSelVal;
		cell3.innerHTML = count;
		cell4.innerHTML = price;
		cell5.innerHTML = tttt;
    }
    
    function remove(id)
    {
		var tempp="row"+id;
		var inId="hidIn"+id;

		var row = document.getElementById(tempp);
		t1 = row.cells[3].innerHTML;
		price = parseInt(t1, 10);
		t2 = row.cells[2].innerHTML; 
		count = parseInt(t2, 10);
		t = price*count;

		servicePrice = servicePrice-t;
		totalServicePrice.innerHTML=servicePrice;
		row.parentNode.removeChild(row);
		var input = document.getElementById(inId);
		input.parentNode.removeChild(input);
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
