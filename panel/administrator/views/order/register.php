<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class register
{
    function register($info)
    {
        $inf = array(
            'page_title' => 'ثبت سفارش جدید '
        );
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'admin_header');
          
        $body = '
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
                    
        <div class="message-info">
        سفارش خود را ثبت کنید
        <br/>
        
        <form method ="POST" action="' . GSMS::$class['template']->info['admin_url'] . 'orders/registerOrder">
        <div id="notif"></div>
       <table  class="table table-striped table-bordered" dir="rtl">
		<tr>
		 
		<td>عنوان سفارش:</td>
		<td><input 
				style="width:25%; font-size:13px"
                type="text" 
                name="orderTitle" 
                id="orderTitle"
                value=""
                />
        </td>
		</tr>
      
	  <tr>
		
		<td> </td>
		
		<td>برای ورود جزئیات از این قسمت بخش مورد نظر خود را انتخاب کنید</td>
	  </tr>
        <tr> 
		<td><input type="radio" name="autoConfig" value="0" onClick="changeView(0)"/> تنظیم ریز جزئیات سفارش</td>
		<td>		 
			نوع فرم:
				<div id="orderDetiles">
				<select name="orderType" id="orderType" style="width:25%; font-size:13px" >
				<option value="0" >هیچکدام</option>';
        foreach ($info['orderType'] as $value) 
		{
            $tempOption = '<option value="' . $value['id'] . '">' . $value['title'] . '</option>';
            $body       = $body . $tempOption;
        }
		
        $body = $body . '</select>
				</div>
		
		</td>
        
		</tr>
		<tr>
			<td> </td>
			
			<td >از این قسمت می توانید یک الگوی قبلی انتخاب کنید و کارشناسان ما برای دریافت جزئیات با شما تماس می گیرند.</td>
		</tr>
        <tr> 
		<td><input type="radio" name="autoConfig" value="1" onClick="changeView(1)" /> انتخاب از تنظیمات از پیش آماده شده</td>
		<td>عنوان فرم:
				<div id="orderGeneral">
				 <select name="formTitle" id="formTitle" style="width:25%; font-size:13px" >
						<option value="0" >هیچکدام</option>';
				foreach ($info['orderTitles'] as $value) 
				{
					$tempOption = '<option value="' . $value['id'] . '">' . $value['title'] . '</option>';
					$body       = $body . $tempOption;
				}
				$body = $body . '
				</select>
				</div>
		</td>
        
        </tr>   
    </table>
    
    <button style="height:60px; padding-top:10px; font-weight: bold; margin-top:25px;" class="btn btn-success btn-register" type="submit">
	ثبت سفارش
	</button>
    </form><br/>
	<script>
		function changeView(id)
		{
			if(id ==1)
			{
				$("#orderType").attr("disabled","ture");
				$("#formTitle").removeAttr("disabled","ture"); 
			}
			else 
			{
				$("#formTitle").attr("disabled","ture");
				$("#orderType").removeAttr("disabled","ture");
			}
		}
		changeView(0);
		
	</script>
        </div>';        
        
        $inf = array(
            'title' => 'ثبت سفارش',
            'body' => $body
        );
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }
}
if (!defined("GSMS")) {
    exit("Access denied");
}
?>