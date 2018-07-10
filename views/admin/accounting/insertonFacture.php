<?php //allahoma sale ala mohammad va ale mohammad
 

class insertonFacture
{
    function insertonFacture($temp)
    {
        
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
		
		<form method ="POST" action ="'.GSMS::$class['template']->info['admin_url'].'accounting/productFacture/' . $temp['id'] . '" enctype="multipart/form-data">
							<div id="notif"></div>
       <table dir="rtl">
	      <tr><td> </td>
		<td><input type="hidden" name="manualtrans_id" id="manualtrans_id"  value="'.$temp['balance']->id.'" /></td></tr>
		
	      <tr><td>سفارش کاربر را انتخاب نمایید :</td>
		<td>
			<select name="userorderid" id="userorderid" style="width:100%; font-size:13px" >';
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
		<td><textarea type="text" name="description" id="description" ></textarea></td></tr>
		
	    
	   <tr>
	   
		
		</table><br/>
					<input type="submit" class="btn btn-success btn-register" name="submit" id="submit" value="تایید و تولید فاکتور "  />
					</form>
		</div>
		<br>
		
		<a class="back_btn" href="'
            . GSMS::$class['template']->info['admin_url'].'accounting/viewBalance/'.$temp['id'] . '">برگشت</a>';
 
        GSMS::$class['template']->message(  'صدور فاکتور ',$body,'admin','alert alert-warning',true , true , array('activeTab' => 'accounting'));
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}