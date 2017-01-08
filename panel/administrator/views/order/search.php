<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system
class search
{
    function search($parameter)
    {
        $inf = array('page_title' => 'جستجو در سفارش ها');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'panel_header');

        $body = '<div style="width:100%">
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/js/persianDatepicker.min.js"></script>
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

       $title_body = '<option value="0">همه</option>';
       $categorys = $parameter['title'] ;
        for ($i = 0; $i < count($categorys); $i++)
            $title_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['name'] .' ' . $categorys[$i]['title'] .'</option>' . '\n';

       $type_body = '<option value="0">همه</option>';
       $categorys = $parameter['type'] ;
        for ($i = 0; $i < count($categorys); $i++)
            $type_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['name'] .' ' . $categorys[$i]['title'] .'</option>' . '\n';

        $body .= '
		<form action="' . GSMS::$class['template']->info['admin_url'] . 'orders/search_result" method=POST >
			<table dir="rtl"> 
				<tr>
					<td>عنوان  سفارش</td>
					<td> <input class="rounded raduis" type="text" name="q" title="جستجو در عنوان  "></td></tr>
					<script>function view(){$("#date").toggle("slow");}</script>
				<tr>
					<td><input type="checkbox" name="date_enable"   
								onclick="javascript:view()" 
								title="اعمال تاریخ در نتیجه جستجو"/>تاریخ</td>
				</tr> 
				<tr id="date" style="display:none">
					<td>از تاریخ </td><td><input class="raduis" type="text" name="date_a" id="date_a" title="تاریخ های بزرگتر از این تاریخ"/></td>
					<td>تا تاریخ </td><td><input class="raduis" type="text" name="date_b" id="date_b" title="تاریخ های کوچکتر از این تاریخ"/></td>
				</tr> 
				<tr>
					<td>متن توضیحات سفارش</td>
					<td><input class="rounded raduis" type="text" name="desc" title="توضیح" value=""/></td>
				</tr>
				
				<tr>
					<td>مشتری</td>
					<td><select  name="user_id" title="مشتری " >' . $admin_body . '</select></td>
				</tr>
				<tr>
					<td>وضعیت</td>
					<td><select  name="status" title="وضعیت " >' . $category_body . '</select></td>
				</tr>
				
				<tr>
					<td>بخش</td>
					<td><select  name="type_id" title="بخش " >' . $type_body . '</select></td>
				</tr>
				<tr>
					<td>نوع کلی</td>
					<td><select  name="title_id" title="نوع " >' . $title_body . '</select></td>
				</tr>
				
				<tr>
					<td><input class="back_btn" type="submit" name="submit" title="جستجو" value="بگرد"/></td>
				</tr>
			</table>
		</form></div>
		
		<a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';

        $inf = array('title' =>  'جستجو در گروه ها', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}