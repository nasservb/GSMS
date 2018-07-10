<?php //allahoma sale ala mohammad va ale mohammad
 

class insertFacture
{
    function insertFacture($temp)
    {
        //---------------initializing-----------
        $inf = array('page_title' => 'صدور فاکتور','activeTab' => 'accounting');
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf,'admin_header');
        //------------------------
		
		$inf['title'] = $inf['page_title'] ;
		
		$id = $temp['id'];
		$tempdeposit = $temp['Receipt'];
		$factureId = $temp['factureid'];
		$userOrder = $temp['userorder'];
		
      // var_dump($temp['Receipt']);
        $body='';		
		$body .= '
		
		<br/>
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#date_due").persianDatepicker();            
			});
		</script>
     
	
		<div class="message-info" style="text-shadow: 0px 0px 1px #96ECFF;  color: #0F6D73;">
		 
		<div align="right" style="font-size:13pt;line-height: 30px;">
			لطفا جهت تولید فاکتور سفارش کاربر را انتخاب نمایید :  
			<br/>
		</div>
		<br/>
		
		<form method ="POST" action ="'.GSMS::$class['template']->info['admin_url'].'accounting/acceptReceipt/' . $temp['id'] . '" enctype="multipart/form-data">
							<div id="notif"></div>
       <table dir="rtl">
	      <tr><td> </td>
		<td><input type="hidden" name="manualtrans_id" id="manualtrans_id"  value="'.$temp['Receipt']->id.'" /></td></tr>
		
	      <tr><td>سفارش کاربر را انتخاب نمایید :</td>
		<td>
			<select name="userorderid" id="userorderid" style="width:100%; font-size:13px">';
         foreach ($temp['userorder'] as $value) {
			if($value['name']==NULL)
			{
				$tempOption = '<option value="' . $value['id'] . '">کد سفارش' .$value['id'] . '</option>';
				$body       = $body . $tempOption;
			}
			else
				{
					$tempOption = '<option value="' . $value['id'] . '">کد سفارش' .$value['id'] .'-'. $value['name'] . '</option>';
                   $body       = $body . $tempOption;
				
			}
        }
        $body = $body . '</select><span id="domainResult"></span>
        </td></tr>
		 <tr><td>تاریخ سررسید:</td>
		<td><input type="text" name="date_due" id="date_due" value="" ></td></tr>
        <tr><td>بابت(شرح فاکتور):</td>
		<td><textarea type="text" name="description" id="description" >'.($temp['factureid']>0?' صدور فاکتور جدید بابت باقی مانده حساب فاکتور به شماره'.$temp['factureid']:'').'</textarea></td></tr>
		
	    
	   <tr>
	   
		
		</table><br/>
					<input type="submit" class="btn btn-success btn-register" name="submit" id="submit" value="تایید و تولید فاکتور "  />
					</form>
		</div>
		<br>
		
		<a class="back_btn" href="'
            . GSMS::$class['template']->info['admin_url'].'accounting/viewReceipt/'.$temp['id'] . '">برگشت</a>';

       
		
		$inf['body'] = $body;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}