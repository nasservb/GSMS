<?php //allahoma sale ala mohammad va ale mohammad
 

class editservice
{
    function editservice($temp)
    {
		 $inf = array(
            'page_title' => 'ویرایش فرم' ,
			'activeTab'=>'services'
        );
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'admin_header');
        $serviceType=$temp['serviceType'];
		$services=$temp['services'];
		$serviceTypeId = $temp['serviceTypeId'];
        $body='';
        if(isset($temp) && isset($temp['message']))
			$body .=$temp['message'];
        $body .= '
        <br/>            
        <div class="message-info">
       ویرایش فرم
        <br/>
        <form method ="POST" action="' . GSMS::$class['template']->info['admin_url'] . 'services/editservice/'.$serviceTypeId.'">
        <div id="notif"></div>
        <div id="hiddenInDiv" style="width: 0px; height: 0px;">';
		foreach($temp['servicePrices'] as $value) {
        	$body.='
			<input id="hidIn'.$value['id'].'" name="inSerives[]" type="hidden" value="'.$value['service_id'].','.$value['price'].','.$value['service_size_id'].','.$value['id'].'">
        	';
        }
		
	 
		
        $body.='</div>
		
			نوع فرم
		<input style="width:25%; font-size:13px"type="text" name="serviceTitle" 
            id="serviceTitle" value="'.$serviceType[0]['title'].'" onchange="checkAddServiceBtnState()" />
			
			<br/>
			<br/>
        
        <br/>
        ویرایش سفارش 
        <table style="width:100%;">
            <tr> 
				<td>عنوان سفارش</td>
				<td>
							
					<select name="serviceName" id="serviceName"   onchange="checkAddServiceBtnState()"  > ';
						
						foreach($temp['services'] as $size) 
						{
							$body .='<option  value="'. $size['id'] .'"  >'. $size['title'] .'</option>';
						}
						
					$body .= '
					</select>		
							
							</td>
            </tr>
			 <tr>
				<td>ابعاد</td>
				<td>
					<select name="serviceSize" id="serviceSize"   onchange="checkAddServiceBtnState()"  > ';
						
						foreach($temp['size'] as $size) 
						{
							$body .='<option  value="'. $size['id'] .'"  >'. $size['title'] .'</option>';
						}
						
		  $body .= '
					</select>
				</td>
            </tr>
            <tr>
				<td>قیمت پایه (ریال)</td>
				<td><input style="width:25%; font-size:13px" type="text" name="servicePrice" id="servicePrice" value=""   onchange="checkAddServiceBtnState()"   /></td>
            </tr>
            <tr><td style="width:15%;"><a  id="addServiceBtn" class="btn btn-primary disabled">اضافه</a></td></tr>
        </table>
        
       لیست قیمت ها
        <table id="ServicesTable" style="width:100%;" dir="rtl" class="table table-bordered">
        <tr>
        <td>عنوان سفارش</td>
        <td>ابعاد</td>
        <td>قیمت</td>
        <td>حذف</td>
        </tr>';
		
        foreach($temp['servicePrices'] as $value) {
			$sizeTitle='';
			
			foreach($temp['size'] as $size) 
			{
				if (intval($size['id']) == intval( $value['service_size_id'] ) ) 
				{
					$sizeTitle=$size['title'];
					
				}
				
			}
			
			
			foreach($temp['services'] as $size) 
			{
				if (intval($size['id']) == intval( $value['service_id'] ) ) 
				{
					$serviceTitle=$size['title'];
					
				}
				
			}
			
        	$body.='<tr id="row'.$value['id'].'">
			<td>'.$serviceTitle .'</td>
			<td>'.$sizeTitle.'</td>
			<td>'. number_format($value['price']).' ريال</td>
			<td><a class="btn btn-sm btn-danger" href="javascript:remove('.$value['id'].');">حذف</a></td></tr>
        	';
        }
        
		$body.='</table>
		<br/>
ابعاد  قابل انتخاب برای این نوع سفارش : <br/>';
	    
		foreach($temp['size'] as $size) 
		{
			$body .='<label style=" padding-left:10px; width:250px;">
            <input 
					id="size_list" 
					name="size_list[]" 
					value="'. $size['id'] .'" 
					'.(in_array($size['id'],explode(',',$serviceType[0]['available_size'])) ? ' checked' : '').'
					style="width:25px; height:25px" 
                    type="checkbox" >'. $size['title'] .'</label><br/>';
		}
		
		$body .=' 
		
		
		<button style="height:60px; padding-top:10px; font-weight: bold; margin-top:25px;" class="btn btn-success btn-register" type="submit">
	ثبت تغییرات
	</button>
		</form>
		<br/>
		<a class="btn btn-danger btn-register"
			href="' . GSMS::$class['template']->info['admin_url'] . 'services/removeService/' . $serviceTypeId . '">حذف فرم</a>
		</div>
		<script>
		startup();
	
	function startup(){
		var oldCount = $( "#servicePrice" ).val();
		$("#servicePrice").on("change paste keyup", function() {
			var newCount = $(this).val();
			if(oldCount != newCount || !newCount)
				checkAddServiceBtnState();
		});
		
		var oldSize = $( "#serviceSize" ).val();
		$("#serviceSize").on("change paste keyup", function() {
			var newSize = $(this).val();
			if(oldSize != newSize || !newSize)
				checkAddServiceBtnState();
		});
		
		var oldName = $( "#serviceName" ).val();
		$("#serviceName").on("change paste keyup", function() {
			var newName = $(this).val();
			if(oldName != newName || !newName)
				checkAddServiceBtnState();
		});
	}
	</script>
	<script>
	function checkAddServiceBtnState(){
		var sizeTemp = $( "#serviceSize" ).val();
		var nameTemp = $( "#serviceName" ).val();
		var priceTemp = $( "#servicePrice" ).val();
		
		if(sizeTemp && nameTemp && Math.floor(priceTemp) == priceTemp && $.isNumeric(priceTemp)){
			addServiceBtnEnable();
		}else if(!(Math.floor(priceTemp) == priceTemp && $.isNumeric(priceTemp)) || (!sizeTemp) || (!nameTemp)){
			addServiceBtnDisable();
		}
    }
    
    </script>
	<script>
    function addServiceBtnEnable(){
		document.getElementById("addServiceBtn").onclick= function tesr(){addServiceClicked();};//addServiceClicked();
		$("#addServiceBtn").removeClass("disabled");
    }
    function addServiceBtnDisable(){
		document.getElementById("addServiceBtn").onclick="";
		$("#addServiceBtn").addClass("disabled");
    }
	
	';
	
	$body .='
    var rowIndex = '. (intval($temp['servicePrices'][count($temp['servicePrices'])-1]['id'])+1) .';' ;
	
	$body .='
	
	var serviceArray='. (json_encode($temp['services'])) .';
	
    function addServiceClicked(){
		var nameTemp = $( "#serviceName" ).val();
		var priceTemp = $( "#servicePrice" ).val();
		var sizeTemp = $( "#serviceSize" ).val();
		
		var table = document.getElementById("ServicesTable");
		var rowNumber=table.rows.length;
		// Create an empty <tr> element and add it to the 1st position of the table:
		var row = table.insertRow(table.rows.length);
		
		rowIndex = rowIndex + 1;
		
		var hiddenInDiv= document.getElementById("hiddenInDiv");
		var input = document.createElement("input");
		input.type = "hidden";
		//"text";
		//hidden
        input.name = "inSerives[]";
        input.id = "hidIn"+rowIndex;
        input.value=nameTemp+","+priceTemp+","+sizeTemp+",0";
        hiddenInDiv.appendChild(input);
        // Append a line break 
        hiddenInDiv.appendChild(document.createElement("br"));
		
		var tempRowId="row"+rowIndex;
		row.id = tempRowId;
		
		// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var removea="<a class=\"btn btn-sm btn-danger\" href=\"javascript:remove("+rowIndex+");\" >حذف</a>";
		
		var findName= "";
		for (i=0;i<serviceArray.length;i++)
		{
			if (serviceArray[i].id == nameTemp)
				findName= serviceArray[i].title;
		}
		
		
		// Add some text to the new cells:
		cell1.innerHTML = findName;
		cell2.innerHTML = $("#serviceSize").find(":selected").text(); 
		var d= 123;
		d=  parseInt(priceTemp,10);
		cell3.innerHTML = d.toLocaleString("us", {minimumFractionDigits: 0, maximumFractionDigits: 0})+"ریال";
		cell4.innerHTML = removea;
		$( "#serviceName" ).val("");
		
    }
    
    function remove(id)
    {
		var tempp="row"+id;
		var inId="hidIn"+id;
		var row = document.getElementById(tempp);
		row.parentNode.removeChild(row);
		var input = document.getElementById(inId);
		input.parentNode.removeChild(input);
    }
    
		</script>
		';
		
		
		$inf = array(
            'title' => 'ویرایش فرم',
            'body' => $body
        );
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
    }
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?> 