<?php //allahoma sale ala mohammad va ale mohammad
 

class servicetypelist
{
    function servicetypelist($temp)
    {
        $serviceTypes=$temp['serviceTypes'];
        $body='';
        if(isset($temp) && isset($temp['message']))
			$body .=$temp['message'];
        $body .= '
        <br/>            
        <div class="table-responsive">
        فرم خود را ثبت کنید
        <br/>
        <table id="ServicesTable"  class="table table-bordered">
        <tr>
        <td>شماره</td>
        <td>توع فرم</td>
        <td>سفارش</td>
        <td>جزییات</td>
        </tr>';
		
        $i=1;
        foreach($serviceTypes as $service) {
			
			
        	$body.='<tr>
        	<td>'.$i.'</td>
			<td>'.$service['title'].'</td>
			<td>'.$service['order_type'].'</td>
			<td><a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'].'services/editservice/'.$service['id'].'">ویرایش</a></td></tr>
        	';
        	$i++;
        }
        
		$body.='</table>
		
		<a href="'.GSMS::$class['template']->info['admin_url'].'services/addservice" class="btn btn-success">افزودن فرم</a>
		</div>';
		GSMS::$class['template']->message('لیست فرم ها' ,$body , 'admin' ,'',false,false, 
		array('activeTab'=>'services'));
    }
}

if (!defined("GSMS")) {
    exit("Access denied");
}
?> 