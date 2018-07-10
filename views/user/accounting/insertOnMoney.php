 <?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class insertOnMoney
{
    function insertOnMoney($temp)
    {
        $inf = array(
			'page_title' => 'واریز وجه آنلاین',
			'activeTab' => 'accounting'
		);
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		
        $body = '    
		
	<br/>
	<div class="message-info" style="    text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
        
			<div align="right" style="font-size:13pt;line-height: 30px;">
				 لطفا اطلاعات مبلغ واریزی را وارد نمایید  
				<br/>
			</div>
        <br/>
        <form method ="POST" action ="' . GSMS::$class['template']->info['user_url'] . 'accounting/insertOnMoney"
		onsubmit="return checkForm()">
		<div id="notif"></div>

			<input type="hidden"  name="factureId" value="' . intval($temp['factureId']) . '"  />                            
			<div>
				<div class="col-md-6">
					<div class="form-group label-floating is-empty">
						<label class="control-label">مبلغ واریزی (ریال)*</label>
						<input class="form-control" type="text" name="price" id="price"  value="' . $temp['totalAmount'] . '" />
						<span class="material-input"></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating is-empty">
						<label class="control-label">شماره تماس*</label>
						<input type="text" class="form-control" id="mobile" name="mobile" value="' . $temp['mobile'] . '"  />
					<span class="material-input"></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group   is-empty">
						<label class="control-label">دلیل واریز مبلغ*</label>
						<textarea class="form-control" name="description" id="description">'.
						(intval($temp['factureId'])>0 ? 'واریز بابت باقی مانده حساب فاکتور به شماره ' . $temp['factureId'] : '')
						.'</textarea>
					<span class="material-input"></span>
					</div>
				</div>
				
				
				<div class="col-md-12">
					<button class="btn btn-success" type="submit">واریز وجه آنلاین</button>	
				</div>
			</div>                
                    
        </form>
		<div id="checkResult" class="col-sm-12 "></div>
	</div>
	
	<script>
	$("#checkResult").hide("fast");
	function checkForm()
	{
		$("#checkResult").hide("fast");
		result  = "" ; 
		
		if($("#description").val()  < 3 )
			result = result + "دلیل واریز به درستی وارد نشده است .<br/>" ;	
		
		if( !($.isNumeric($("#price").val())) )
				result = result + "مبلغ واریزی باید عدد باشد. <br/>" ;
			
		if($("#mobile").val()  < 3 )
			result = result + "شماره تماس به درستی وارد نشده است .<br/>" ;	
		
		if(result.length > 1 )
		{
			$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا های زیر را بررسی کنید : <br/>"+ result) ;
			$("#checkResult").show("slow");
			return false ; 
		} 
		$("#checkResult").hide("fast");
		return true ;
	}
	</script>
	
	';
	
		$inf = array(
			'title' => 'ثبت فیش بانکی',
			'body' => $body
		);
		GSMS::$class['template']->load($inf, 'user_index');
		GSMS::$class['template']->load($inf, 'user_footer');
	
		/*
        GSMS::$class['template']->message('واریز وجه آنلاین', //title
            $body, //body
            'user', //part
            '', //css class
            false, //format output
            true, //return button
            array(
            'activeTab' => 'accounting'
        )); //extra argument 
		*/
    }
    
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
} 