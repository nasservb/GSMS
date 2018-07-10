<?php //allahoma sale ala mohammad va ale mohammad
 
class search
{
    function search($parameter)
    {
        $inf = array('page_title' => 'جستجو در سفارش ها','activeTab' => 'orders');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'admin_header');

        $body = '<div style="width:100%">
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#date_a").persianDatepicker();       
				$("#date_b").persianDatepicker();            
			});
		</script>';       

       $category_body = '<option value="0">همه   </option>';
       $categorys = $parameter['status'] ;
        for ($i = 0; $i < count($categorys); $i++)
            $category_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['status'] . '</option>' . '\n';
  

       $admin_body = '<option value="0">همه</option>';
       $categorys = $parameter['users'] ;
        for ($i = 0; $i < count($categorys); $i++)
            $admin_body .= '<option value="' . $categorys[$i]['admin_id'] . '" >' .
			$categorys[$i]['name'] .' ' . $categorys[$i]['family'] .'</option>' . '\n';

       $service_body = '<option value="0">همه</option>';
       $categorys = $parameter['service'] ;
        for ($i = 0; $i < count($categorys); $i++)
            $service_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['name'] .' ' . $categorys[$i]['title'] .'</option>' . '\n';

       $type_body = '<option value="0">همه</option>';
       $categorys = $parameter['type'] ;
        for ($i = 0; $i < count($categorys); $i++)
            $type_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['name'] .' ' . $categorys[$i]['title'] .'</option>' . '\n';

        $body .= '
		<form action="' . GSMS::$class['template']->info['admin_url'] . 'orders/search_result" method=POST >
			<table class="table table-hover" dir="rtl"> 
				<tr>
					<td>شماره  سفارش</td>
					<td> <input  class="form-control" type="text" name="id" title="جستجوی شماره سفارش  "></td></tr>
					<script>function view(){$("#date").toggle("slow");}</script>
				<tr>
					<td><input type="checkbox" style="width:25px;height: 25px;" name="date_enable"   
								onclick="javascript:view()" 
								title="اعمال تاریخ در نتیجه جستجو"/>تاریخ</td>
				</tr> 
				<tr id="date" style="display:none">
					<td>از تاریخ </td><td><input  class="form-control" type="text" name="date_a" id="date_a" title="تاریخ های بزرگتر از این تاریخ"/></td>
					<td>تا تاریخ </td><td><input  class="form-control" type="text" name="date_b" id="date_b" title="تاریخ های کوچکتر از این تاریخ"/></td>
				</tr> 
				<tr>
					<td>متن توضیحات سفارش</td>
					<td><input  class="form-control" type="text" name="desc" title="توضیح" value=""/></td>
				</tr>
				
				<tr>
					<td>مشتری</td>
					<td><select  class="form-control"  name="user_id" title="مشتری " >' . $admin_body . '</select></td>
				</tr>
				<tr>
					<td>وضعیت</td>
					<td><select  class="form-control"  name="status" title="وضعیت " >' . $category_body . '</select></td>
				</tr>
				
				<tr>
					<td>بخش</td>
					<td><select   class="form-control" title="بخش " >' . $type_body . '</select></td>
				</tr>
				<tr>
					<td>نوع کلی</td>
					<td><select   class="form-control" name="title_id" title="نوع " >' . $service_body . '</select></td>
				</tr>
				
				<tr>
					<td><input class="back_btn" type="submit" name="submit" title="جستجو" value="جستجو در سفارش ها "/></td>
				</tr>
			</table>
		</form></div>
		
		 ';

        $inf = array('title' =>  'جستجو در سفارش ها', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}