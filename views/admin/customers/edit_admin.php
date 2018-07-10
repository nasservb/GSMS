<?php //allahoma sale ala mohammad va ale mohammad
class edit_admin

{
	function edit_admin($temp)
	{
		$tempAdmin = $temp['tempAdmin'];
		if (!is_object($tempAdmin))
		{
			$body = '<div class="alert alert-danger">اطلاعات کاربري يافت نشد</div>';
			GSMS::$class['template']->message('ویرایش کارمند', $body, 'admin', '', false, false, array(
			'activeTab' => 'customers'
		));
		} //if
		$body = '<div dir=rtl>
		<form id="user_data" name="user_data" method="post" onSubmit="return checkForm()" action="' .
		GSMS::$class['template']->info['admin_url'] . 'customers/editEmployer/' . $tempAdmin->id . '">
<div class="message-info">	

اطلاعات مشتری را وارد کنيد

	<div class="row">
	<table  class="table table-striped ">
    <tr>
		<td >نام*</td>
		<td><input type="text"  name="name" id="name" value="' . $tempAdmin->name . '" /></td>
    </tr>
	<tr>
      <td>نام خانوادگي*</td>
      <td><input type="text" name="family" id="family" value="' . $tempAdmin->family . '"/></td>
    </tr>
	<tr>
      <td>ايميل*</td>
      <td><input type="text" name="mail" id="mail" value="' . $tempAdmin->mail . '"/></td>
    </tr>
    <tr>
      <td>نام کاربري</td>
      <td><input type="text"  value="' . $tempAdmin->username . '"  disabled/>
    </tr>
	<tr>
      <td>همراه</td>
      <td><input type="text" name="mobile" id="mobile" value="' . $tempAdmin->mobile . '"/></td>
    </tr>
    <tr>
      <td>تاريخ ثبت</td>
      <td><input type="text"  value="' . $tempAdmin->date . '"  disabled/></td>
    </tr>
	<tr>
		<td>نوع کارمند</td>
		<td>
			<select  name="user_type" id="user_type" >
				<option value="3">کارمند</option>
				<option value="1">ادمین</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>سطح دسترسی</td>
		<td>';
		foreach ($temp['part'] as $value) 
		{
			$tempOption = '
			<label style="float:right; padding-left:10px; width:250px;">
				<input id="service'.$value['id'].'" name="permission_list[]" value="' . $value['id'] . '" style="width:25px; height:25px" 
				type="checkbox" > ' . $value['title'] . '</label>
			';
			$body .=$tempOption;
		}
		$body .='</td>
	</tr>
	
	<tr>
      <td>شرح کوتاه</td>
      <td><textarea  name="describe" id="describe" >' . $tempAdmin->description . '</textarea></td>
    </tr>
	</table>
	</div>
	<input type="submit" class="btn btn-primary "  name="submit" id="but"  value="ثبت ویرایش"/>
</form>
';
		$body.= '
<div class="row">
	<div id="checkResult" class="col-sm-6 pull-right"></div>
</div>
</div><br/>
<script>  
	$("#checkResult").hide("fast");
	function checkForm() 
	{
		result  = "" ;
		if($("#name").val()  < 1 ){
				result = result + "نام وارد نشده است.<br/>" ;
		}
		if($("#family").val()  < 1 ){
				result = result + "نام خانوادگی وارد نشده است.<br/>" ;
		}
		if($("#mail").val()  < 1 ){
				result = result + "ایمیل وارد نشده است.<br/>" ;
		}
		
		if($("#username").val()  < 1 ){
				result = result + "نام کاربری وارد نشده است.<br/>" ;
		}
		
		if($("#mobile").val()  < 1 ){
				result = result + "تلفن همراه وارد نشده است.<br/>" ;
		}
		';
		$state = '';
		foreach ($temp['part'] as $value) 
		{
			
			$state .= '(!($("#service'.$value['id'].'").is(":checked")))&&';
		}
		if(!empty($state))
		{
			$state2=substr($state,0, (strlen($state) - 2));
			$body .= 'if('.$state2.'){
				result = result + "سطح دسترسی انتخاب نشده است.<br/>" ;
			}';			
		}
		
		$body .= 'if(result.length > 1 )
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
		GSMS::$class['template']->message('ویرایش کارمند', $body, 'admin', '', false, false, array(
			'activeTab' => 'customers'
		));
	}
}

// class

if (!defined("GSMS"))
{
	exit("Access denied");
}