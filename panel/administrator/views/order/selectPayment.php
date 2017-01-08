<?php
class selectPayment
{
    function selectPayment()
    {
		//---------------initializing-----------
		$inf = array('page_title' => 'انتخاب روش پرداخت');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'admin_header');
		//-------------------
		$body = '';
		$body .= '        
		<br/>
        <div style="width: 85%;
                    height: 8px;
                    background-color: #C9D1D7;
                    border-radius: 15px;
                    margin: 15px;
                    position: relative;">

                        <div class="progress_bg" style="width:99%"></div>
                    <span style="background-position: -2px -2px;" class="step-item">

                    <a href="#" style="color:black;">
                    ورود به سایت
                    </a></span>
                    
                    <span style="background-position: -2px -2px;right: 25%;" class="step-item">
                    <a class="s_title" href="#"  style="color:black;">
                    ثبت سفارش    
                    </a></span>
                    
                    <span style="background-position: -2px -2px;right: 50%;" class="step-item">
                    <a class="s_title" href="#"  style="color:black;">
                    تکمیل اطلاعات سفارش    
                    </a></span>
                                                                    
                    <span style="background-position: -2px -2px;right: 75%;" class="step-item">
                    <a class="s_title" href="#"  style="color:black;">
                    بازبینی اطلاعات
                    </a></span>
                    <span style="background-position: -2px -36px;right: 99%;" class="step-item">
                    <a  class="s_title" href="#"  style="color:blue;">
                    انتخاب روش پرداخت
                    </a></span>
                    
        </div>
		<div class="message-info" style="    text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		<form method ="POST" action ="'. GSMS::$class['template']->info['user_url'] .'orders/selectPayment">
			روش پرداخت مورد نظر خود را انتخاب کنید.
			<br/>
			<input style="width:25px; height:25px" type="radio" name="paymentType" value="1" checked/> پرداخت آنلاین<br>
			<input style="width:25px; height:25px" type="radio" name="paymentType" value="2"/> ثبت فیش بانکی<br>
			<input style="width:25px; height:25px" type="radio" name="paymentType" value="3"/> ثبت فیش کارت به کارت<br>
			 <br/>
			<div class="alert alert-info">اگر از فیلتر شکن یا VPN استفاده می کنید برای پرداخت بانکی باید آنها را غیر فعال کنید .</div>
			 <button style="height:60px; padding-top:10px; font-weight: bold; margin-top:25px;" class="btn btn-success btn-register" type="submit">
			پرداخت آنلاین
			</button>
		</form>
		</di>
		';
		
		$body .= '</div>';
		$inf = array('title' =>  'انتخاب روش پرداخت', 'body' => $body);
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
    }
}
