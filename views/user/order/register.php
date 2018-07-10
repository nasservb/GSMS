<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class register
{
    function register($info)
    {
        $inf = array(
            'page_title' => 'ثبت سفارش جدید ','activeTab'=>'orders'
        );
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'user_header');
          
        $body = '
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/dropzone.css" type="text/css" rel="stylesheet" />
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/dropzone.min.js"></script>
		
		
        <br/>
        <div style="width: 85%;
                    height: 8px;
                    background-color: #C9D1D7;
                    border-radius: 15px;
                    margin: 15px;
                    position: relative;">

                        <div class="progress_bg" style="width:25%"></div>
                    <span style="background-position: -2px -2px;" class="step-item">

                    <a href="#" style="color:black;">
                    ورود به سایت
                    </a></span>
                    
                    <span style="background-position: -2px -36px;right: 25%;" class="step-item">
                    <a class="s_title" href="#"  style="color:blue;">
                    ثبت سفارش    
                    </a></span>
                    
                    <span style="background-position: -2px -70px;right: 50%;" class="step-item">
                    <a>
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
                    
        <div  class="message-info">
			
        سفارش خود را ثبت کنید
        <br/>
        <form 	id="registerForm"
				method ="POST" 
				action="' . GSMS::$class['template']->info['user_url'] . 'orders/registerOrder" 
				
				enctype="multipart/form-data">
        <div id="notif"></div>
		<table class="table table-bordered">
		<tr>
		 
		<td>عنوان سفارش<span class="text-danger">*</span>:</td>
		<td><input 
				style="width:25%; font-size:13px"
                type="text" 
                name="orderTitle" 
                id="orderTitle"
                />
        </td>
		</tr>
      
        <tr> 
		<td>
		
		<div>
		<input style="cursor: pointer;" onClick="changeView(1)" type="radio" id="autoConfig1" name="autoConfig" value="1" onClick="changeView(1)"  checked="checked" /> 
		 انتخاب از تنظیمات از پیش آماده شده</div>
		
		<div>
		<input  style="cursor: pointer;" onClick="changeView(0)" type="radio" id="autoConfig0" name="autoConfig" value="0" onClick="changeView(0)"/> 
		تنظیم ریز جزئیات سفارش</div>
		
		</td>
		<td>
		
		
		
		<div id="detailChoice">	
		
			نوع فرم <span style="color:red">*</span>:
				<div id="orderDetiles">
				<select name="orderType" id="orderType" style="width:25%; font-size:13px" >
			 ';
        foreach ($info['orderType'] as $value) 
		{
            $tempOption = '<option value="' . $value['id'] . '">' . $value['title'] . '</option>';
            $body       = $body . $tempOption;
        }
		
        $body = $body . '</select>
				</div>		
		<span>برای ورود جزئیات از این قسمت بخش مورد نظر خود را انتخاب کنید</span>
		<br>
		</div>
		<div id="generalChoice">
				عنوان فرم <span style="color:red">*</span>:
				<div id="orderGeneral">
				 <select name="formTitle" id="formTitle" style="width:25%; font-size:13px" >
				';
				
				foreach ($info['orderTitles'] as $value) 
				{
					$tempOption = '<option value="' . $value['id'] . '">' . $value['title'] . '</option>';
					$body       = $body . $tempOption;
				}
				
				$body = $body . '
				</select>
				</div>
				<div>
					<span >از این قسمت می توانید یک الگوی قبلی انتخاب کنید و کارشناسان ما برای دریافت جزئیات با شما تماس می گیرند.</span>
				</div>
		</div>
        </td>
        </tr> 
		</tr> 
		<tr><td>نام فرد پیگیر <span style="color:red">*</span>:</td>
        <td>
            <input 
				style="width:25%; font-size:13px"
                type="text" 
                name="adminName" 
                id="adminName"  
                 
                />
        </td>
        </tr>
		<tr><td>شماره موبایل <span style="color:red">*</span>:</td>
        <td>
            <input 
				style="width:25%; font-size:13px"
                type="text" 
                name="mobile" 
                id="mobile"  
                data-toggle="popover" 
                 
                />
        </td>
        </tr>
		<tr><td>فورس ماژور</td>
        <td>
			<label style="float:right; padding-left:10px; width:250px;">                    
            <input  
                type="checkbox" 
                name="isVip" 
                id="isVip"  
				style="width:25px; height:25px; font-size:13px" 
                 
                />چاپ خارج از نوبت </label><br><br>
				<div class="alert alert-info">در صورت انتخاب 20 درصد به هزینه کل اضافه می شود
				</div>
        </td>
        </tr>
      	
		<tr><td>مالیات</td>
        <td>
            <div class="alert alert-info">مبلغ مالیات بر ارزش افزوده به قیمت کل سفارش اضافه خواهد شد. </div>
        </td>
        </tr>
		</form>
      		
    </table>
		 
    <input title="ثبت سفارش" value="ثبت سفارش" type="button" onclick="checkForm() "class="btn btn-success" />
	<br/>
	<div id="checkResult" ></div>
	<script>
		$("#checkResult").hide("fast");
		function checkForm() 
		{
			$("#checkResult").hide("fast");
			result  = "" ; 
			if($("#orderTitle").val().length < 3 )
				result = result + "  عنوان سفارش را وارد کنید <br/>" ;
			if( $("#adminName").val().length < 3 )
				result = result + "  نام فرد پیگیر را وارد کنید <br/>" ;
			if( $("#mobile").val().length < 3 )
				result = result + "    موبایل را وارد کنید <br/>" ;
			if( !($.isNumeric($("#mobile").val())) )
				result = result + "موبایل باید عدد باشد. <br/>" ;
			
			
			if(result.length > 1 )
			{
				$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا هاي زير را بررسي کنيد : <br/>"+ result) ;
				$("#checkResult").show("slow");
				return false ; 
			} 
			$("#checkResult").hide("slow");
			document.getElementById(\'registerForm\').submit();
			return true ;
		}
		function changeView(id)
		{
			if(id ==1)
			{
				// $("#orderType").attr("disabled","ture");
				// $("#formTitle").removeAttr("disabled","ture"); 				
				 
				$("#autoConfig1").attr("checked","checked"); 
				
				$("#detailChoice").hide("slow");
				$("#generalChoice").show("slow");
			}
			else 
			{
				// $("#formTitle").attr("disabled","ture");
				// $("#orderType").removeAttr("disabled","ture");
				
				$("#autoConfig0").attr("checked","checked"); 
				
				$("#generalChoice").hide("slow");
				$("#detailChoice").show("slow");
			}
		}
		changeView(1);
		
	</script>
        </div>';        
        
        $inf = array(
            'title' => 'ثبت سفارش',
            'body' => $body
        );
        GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
    }
}
if (!defined("GSMS")) {
    exit("Access denied");
}
?>