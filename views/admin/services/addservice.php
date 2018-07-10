 <?php //allahoma sale ala mohammad va ale mohammad
 

class addservice
{
    function addservice($temp)
    {
        $inf = array(
            'page_title' => 'ثبت فرم جدید ',
			'activeTab'=>'services'
        );
         
        $orderTypes = ''; 
        foreach ($temp['type'] as $type ) {
         	$orderTypes .='<input style=" margin-right: 20px;margin-left: 5px; font-size:13px"type="radio" name="orderType" '.($type['id'] == 1 ? ' checked' : '').'
            id="orderType" value="'.$type['id'].'"   /> '.$type['title'];
         } 


        $body='';
        if(isset($temp) && isset($temp['message']))
			$body .=$temp['message'];
        $body .= '
        <br/>            
        <div class="message-info">
      
        
        <form method ="POST" action="' . GSMS::$class['template']->info['admin_url'] . 'services/addservice" onSubmit="return checkForm()">
        <div id="notif"></div>
        <div id="hiddenInDiv" style="width: 0px; height: 0px;"></div>
		<div class="table-responsive"> 
'.$orderTypes.'
			<br/>
		نوع فرم
		<input style="width:50%; font-size:13px"type="text" name="serviceType" 
            id="serviceType" value="" onchange="checkAddServiceBtnState()" />
			<br/>
			<br/>
		 سفارش جدید
		<table class="table table-bordered">
             
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
					<select name="serviceSize" id="serviceSize"  onchange="checkAddServiceBtnState()"  > ';
						
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
				<td><input style="width:50%; font-size:13px" type="text" name="servicePrice" id="servicePrice"  onchange="checkAddServiceBtnState()"   value=""/></td>
            </tr>
			<tr>
          
            </tr>
        </table>
		<a  id="addServiceBtn" class="btn btn-primary disabled">اضافه</a>
		<br/>
		لیست قیمت ها
    
    <table id="ServicesTable" class="table table-bordered">
        <tr>
        <td>عنوان سفارش</td>
        <td>ابعاد</td>
        <td>قیمت </td>
        <td>حذف</td>
        </tr>
    </table>
	
	<br/>
	ابعاد  قابل انتخاب برای این نوع سفارش : <br/>';
	    
		foreach($temp['size'] as $size) 
		{
			$body .='<label style=" padding-left:10px; width:250px;">
            <input id="size_list" name="size_list[]" value="'. $size['id'] .'" style="width:25px; height:25px" 
                    type="checkbox" >'. $size['title'] .'</label><br/>';
		}
		
		$body .=' 
	   
     </div>
    <button style="height:60px; padding-top:10px; font-weight: bold; margin-top:25px;" class="btn btn-success btn-register" type="submit">
    ثبت فرم
    </button>
    </form><br/>
	
	<div class="row"><div id="checkResult" class="col-sm-6 pull-right"></div>
</div>
	
</div>
        
	<script>
	$("#checkResult").hide("fast");
	function checkForm() 
	{
		result  = "" ;
		if($("#serviceType").val()  < 1 ){
				result = result + "نوع سرویس وارد نشده است.<br/>" ;
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
	
	var serviceArray='. (json_encode($temp['services'])) .';
	
    var rowIndex =0;
	
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
// 		document.getElementById("ServicesTable").deleteRow(id);
		var tempp="row"+id;
		var inId="hidIn"+id;
		var row = document.getElementById(tempp);
		row.parentNode.removeChild(row);
		var input = document.getElementById(inId);
		input.parentNode.removeChild(input);
    }
	</script>';
	
	GSMS::$class['template']->message( 'ثبت فرم جدید', $body , 'admin','',false , false ,array('aciveTab'=>'services')); 
        
    }
}


if (!defined("GSMS")) {
    exit("Access denied");
}
?> 