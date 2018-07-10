<?php //allahoma sale ala mohammad va ale mohammad
 

class addExtraSevice
{
	function addExtraSevice($temp)
	{
		$body = '';
          
		$title = 'لیست خدمات تکمیلی فرم  ' . $temp['type']['title'];
		
		$body .= '
		<div class="table-responsive">
		<table class="table table-bordered">
		
		<tbody>
			<form  name="extra_data" method="post"  >
				<tr>
					<td>عنوان</td>
					<td><input  type="text"  name="title" '.(is_object($temp['service']) ? 'value="'.$temp['service']->service .'"': '' ).' /> </td>
					
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<button type="submit" name="submit" class="btn btn-primary btn-sm" >'.(is_object($temp['service']) ? 'ویرایش': 'افزودن' ).'</button></td>
					</td>
				</tr>
			</form>
		</tbody></table>
		
		</div>';
		
		 
        GSMS::$class['template']->message($title, $body,'admin','',false ,false,array('activeTab'=>'orderform')); 
	}
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}