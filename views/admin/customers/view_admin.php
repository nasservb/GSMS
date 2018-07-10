<?php //allahoma sale ala mohammad va ale mohammad
 

class view_admin
{
    function view_admin($temp)
    {
		$tempAdmin = $temp['tempAdmin'];
		//--------------------------
		
		if(!is_object($tempAdmin))
		{
			
			$body='کاربر یافت نشد<br>
						<a class="back_btn" href="'.
						GSMS::$class['template']->info['admin_url'].'customers/listCustomers">برگشت</a>';
			$inf=array('activeTab'=>'customer', 'activeTab'=>'customers' );
			
			GSMS::$class['template']->message(
						'نمایش اطلاعات مشتری',$body , 'admin','alert alert-warning' ,true,false,$inf );
			exit();
		}//if
		$permission = explode(',', $tempAdmin->permission);
		$part = $temp['part'];
		//var_dump($permission);
		$body='<div class="message-info" dir=rtl>
  <table  class="table table-striped">
    <tr>
      <td >نام</td>
      <td><div class="disable_input">'.$tempAdmin->name.'</div></td>
    </tr>
    <tr>
      <td>نام خانوادگی</td>
      <td><div class="disable_input">'.$tempAdmin->family.'</div></td>
    </tr>
    <tr>
      <td>ایمیل</td>
      <td><div class="disable_input">'.$tempAdmin->mail.'</div></td>
    </tr>
    <tr>
      <td>نام کاربری</td>
      <td><div class="disable_input">'.$tempAdmin->username.'</div></td>
    </tr>
    <tr>
      <td>همراه</td>
      <td><div class="disable_input">'.$tempAdmin->mobile.'</div></td>
    </tr>
    <tr>
      <td>تاریخ ثبت</td>
      <td><div class="disable_input">'.$tempAdmin->date.'</div></td>
    </tr>
	<tr>
      <td>توع کارمند</td>
      <td><div class="disable_input">'.($tempAdmin->admin_type == 1 ? 'ادمین' : 'کارمند').'</div></td>
    </tr>
	 
    <tr>
      <td>توضیح</td>
      <td>'.$tempAdmin->description.'</td>
    </tr>
     
  </table>
</div>';
			 
			GSMS::$class['template']->message('نمایش اطلاعات مشتری',$body , 'admin','' ,false,false ,array('activeTab'=>'customers') );
			 
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}