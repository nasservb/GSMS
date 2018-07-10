<?php //allahoma sale ala mohammad va ale mohammad
 

class bulkservice
{
    function bulkservice($temp)
    {
		$inf = array(
            'title' => 'ثبت گروهی ');
		
		GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf, 'admin_header');
		
		$body = '
		
		
		<form method ="POST" action="' . GSMS::$class['template']->info['admin_url'] . 'services/bulkservice">
		
		 <table class="table table-hover">
		 <tr>
			<td>نام سرویس</td>
			<td><input style="width:80%; font-size:13px" type="text" name="name1" id="name1" value=""  /></td>
		 </tr>
		
		 <tr>
			<td>قیمت ها</td>
			<td>
				<textarea style="width:80%;height:300px"  name="data1" id="data1" ></textarea> 
			</td>
		 </tr>
		 <tr>
				<td>نوع</td>
				<td>
					<select name="orderTypeId" id="orderTypeId" > ';
						
						foreach($temp['orderTypeId'] as $size) 
						{
							$body .='<option  value="'. $size['id'] .'"  >'. $size['title'] .'</option>';
						}
						
		  $body .= '
					</select>
				</td>
            </tr>
            <tr>
				
			</tr>
        </table>
		
		<table class="table table-hover">
		 <tr>
			<td>نام سرویس</td>
			<td><input style="width:80%; font-size:13px" type="text" name="name2" id="name2" value=""  /></td>
		 </tr>
		
		 <tr>
			<td>قیمت ها</td>
			<td>
				<textarea style="width:80%;height:300px"  name="data2" id="data2" ></textarea> 
			</td>
		 </tr>
		 <tr>
				<td>نوع</td>
				<td>
					<select name="orderTypeId" id="orderTypeId2" > ';
						
						foreach($temp['orderTypeId'] as $size) 
						{
							$body .='<option  value="'. $size['id'] .'"  >'. $size['title'] .'</option>';
						}
						
		  $body .= '
					</select>
				</td>
            </tr>
            <tr>
				<td style="width:15%;">
					<button  type="submit"  class="btn btn-primary  ">اضافه</button>
				</td>
			</tr>
        </table>
		
		
		
		</form>
	';
	
	$inf = array(
            'title' => 'ثبت گروهی ',
            'body' => $body
        );
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
	}
}