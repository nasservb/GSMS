<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class search
{
    function search($parameter)
    {
        $inf = array('page_title' => 'جستجو در گروه ها');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'جستجو در گروه ها');
        GSMS::$class['template']->load($inf,'admin_header');

        $body = '<div style="width:100%">
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#date_a").persianDatepicker();       
				$("#date_b").persianDatepicker();            
			});
		</script>';

   
       $category_type = '<option value="-1">همه چیز</option>';
       $category_type .= '<option value="1" selected >گروه</option>';
      $category_type .= '<option value="2" >آی دی</option>';
     $category_type .= '<option value="3" >استیکر</option>';
     $category_type .= '<option value="4" >ربات</option>';
     $category_type .= '<option value="7" >کانال</option>';


       $category_body = '<option value="0">همه دسته ها </option>';
        $categorys = $parameter['telgroupCategory'];
        for ($i = 0; $i < count($categorys); $i++)
            $category_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['title'] . '</option>' . '\n';




        $body .= '
		<form action="' . GSMS::$class['template']->info['admin_url'] . 'telgroups/search_result" method=POST >
			<table dir="rtl"> 
				<tr>
					<td>عنوان  </td>
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
					<td>متن توضیحات </td>
					<td><input class="rounded raduis" type="text" name="desc" title="توضیح" value=""/></td>
				</tr>
				
				<tr>
					<td>هشتگ مثل: #عاشقانه#دخترانه</td>
					<td><input class="rounded raduis" type="text" name="Tag" value=""/></td>
				</tr>
				<tr>
					<td>دسته بندی</td>
					<td><select  name="musicCategory" title="دسته بندی" >' . $category_body . '</select></td>
				</tr>
					<tr>
<td>چه چیزی (گروه - استیکر ...)</td>
					<td><select  name="type" title="دسته بندی" >' . $category_type . '</select></td>
				</tr>
				
				<tr>
					<td><input class="back_btn" type="submit" name="submit" title="جستجو" value="بگرد"/></td>
				</tr>
			</table>
		</form></div>
		
		<a class="back_btn" href="' . GSMS::$class['template']->info['admin_url'] . '">برگشت</a>';

        $inf = array('title' =>  'جستجو در گروه ها', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}