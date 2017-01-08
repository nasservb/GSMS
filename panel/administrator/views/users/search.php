<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class search
{
    function search($parameter)
    {


        $body = '<div style="width:100%">
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/js/jquery.min.js"></script>
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#date_a").persianDatepicker();       
				$("#date_b").persianDatepicker();            
			});
		</script>';

        $admin_body = '<option value="0">نامعلوم</option>';
        $admins = $parameter['admins'];
        for ($i = 0; $i < count($admins); $i++)
            $admin_body .= '<option value="' . $admins[$i]->id . '" >' . $admins[$i]->name . ' ' . $admins[$i]->family . '</option>' . '\n';


        $cat = '<option value="0" selected>انتخاب نشده</option>';
        $categorys = $parameter['categorys'];
        for ($i = 0; $i < count($categorys); $i++)
            $cat .= '<option value="' . $categorys[$i]->id . '" >' . $categorys[$i]->title . '</option>' . '\n';


        $body .= '
		<form action="' . GSMS::$class['template']->info['user_url'] . 'users/select_result" method=POST >
			<table dir="rtl"> 
				<tr>
					<td>عنوان</td>
					<td> <input class="rounded raduis" type="text" name="q" title="جستجو در متن همه چیز"></td></tr>
					<script>function view(){$("#date").toggle("slow");}</script>
				<tr>
					<td><input type="checkbox" name="date_enable"   onclick="javascript:view()" title="اعمال تاریخ در نتیجه جستجو"/>تاریخ</td>
				</tr> 
				<tr id="date" style="display:none">
					<td>از تاریخ </td><td><input class="raduis" type="text" name="date_a" id="date_a" title="تاریخ های بزرگتر از این تاریخ"/></td>
					<td>تا تاریخ </td><td><input class="raduis" type="text" name="date_b" id="date_b" title="تاریخ های کوچکتر از این تاریخ"/></td>
				</tr> 
				<tr>
					<td>شرح</td>
					<td><input class="rounded raduis" type="text" name="desc" title="توضیح" value=""/></td>
				</tr>
				<tr>
					<td>کلید</td>
					<td><input class="rounded raduis" type="text" name="key" title="کلید" value=""/></td>
				</tr>
				<tr>
					<td>موضوع</td>
					<td><select  name="cat" title="موضوع" >' . $cat . '</select></td>
				</tr>
				<tr>
					<td>عکاس</td>
					<td><select  name="photographer" title="عکاس" >' . $admin_body . '</select></td>
				</tr>
				<tr>
					<td>مکان عکس</td>
					<td><input class="rounded raduis" type="text" name="place" title="مکان عکس" value=""/></td>
				</tr>
				<tr>
					<td><input class="back_btn" type="submit" name="submit" title="جستجو" value="بگرد"/></td>
				</tr>
			</table>
		</form></div>
		';

        $inf = array('title' => 'لیست تصاویر', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);

    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}