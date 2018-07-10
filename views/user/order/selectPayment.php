<?php
class selectPayment
{
    function selectPayment($order)
    {
		//---------------initializing-----------
		$inf = array('page_title' => 'انتخاب روش پرداخت','activeTab'=>'orders');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
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

                        <div class="progress_bg" style="width:100%"></div>
                    <span style="background-position: -2px -2px;right: 2%;" class="step-item">
                    <a class="s_title" >
                    سفارش     
                    </a></span>
                                                                    
                    <span style="background-position: -2px -2px;right: 50%;" class="step-item">
                    <a>
                    بازبینی 
                    </a></span>
                    <span style="background-position: -2px -33px;right: 100%;" class="step-item">
                    <a href="#"  style="color:blue;">
                      پرداخت
                    </a></span>
                    
        </div>
		<div class="message-info" style="    text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		<form method ="POST" action ="'. GSMS::$class['template']->info['user_url'] .'accounting/buyOnline/'.$order->factureId.'">
			روش پرداخت مورد نظر خود را انتخاب کنید.
			<br/>

			<input style="width:25px; height:25px" type="radio" name="paymentType" value="1" checked/> پرداخت آنلاین<br>
			
			 <br/>    
             <div class="finalprice pull-left">
                <div class="total">
                        جمع کل فاکتور:                  
                    <span id="servicesPrice" class="left " style="color: #0C81F9;font-size: 13pt;">
                    '.number_format($order->printPrice).'
                        <span class="toman">ریال</span>
                    </span>
                    <br>
                </div>
            </div>
            <br/>
            <br/>
            <br/>
			<div class="alert ">اگر از فیلتر شکن یا VPN استفاده می کنید برای پرداخت بانکی باید آنها را غیر فعال کنید .</div>
			 
			<button class="btn btn-success" type="submit" name="submit">پرداخت آنلاین و تکمیل سفارش</button>
			
			<a class="btn" href="'. GSMS::$class['template']->info['user_url'] .'orders/reviewOrder/'.$order->id.'">برگشت</a>
			
		</form>
		</di>
		';
		
		$body .= '</div>';
		$inf = array('title' =>  'انتخاب روش پرداخت', 'body' => $body);
		GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
    }
}
