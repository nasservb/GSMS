<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class configuration
{
    function configuration($info)
    {
        //free result
        $inf = array('page_title' => 'ويرايش پروفایل');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'user_header');
        //----------------------------------
		$tempAdmin=$info['admin'];
        if (!is_object($tempAdmin)) 
		{
            $body = 'اطلاعات کاربري يافت نشد<br>
						<a class="back_btn" href="' .
                GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'ويرايش پروفایل', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
        //if
		
		$ostan_body = '<option value=0>همه استان ها</option>';
        $categorys = $info['ostan'];
        for ($i = 0; $i < count($categorys); $i++)
            $ostan_body .= '<option value="' . $categorys[$i]['id'] . '" >' .
			$categorys[$i]['name'] . '</option>' . '\n';

        $body = '
		<br/>

		 
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
		var map;
		var marker;
		function initialize() 
		{
			var latlng = new google.maps.LatLng(35.69187929931617,51.394429206848145);
			var myOptions = 
			{
			  zoom: 13,
			   center: latlng,
			  mapTypeId: google.maps.MapTypeId.MAP
			};
			map = new google.maps.Map(document.getElementById("map_canvas"),
				myOptions);
			google.maps.event.addListener(map, "click", function(event) {
			placeMarker(event.latLng);
		  });
		  
		  function placeMarker(location) {
			  if(!marker)
			  {
				   marker= new google.maps.Marker({
					  position: location,
					  map: map,
					  title:"محل پذیرنده"
				  });
			  }
			  else 
			  {
				marker.setPosition( location);
			  }

			 document.getElementById("google_position").value=location;
			 
		 }
		}
		
			
		</script>
		<script>
			function getShar(ostanid)
			{
				if(ostanid == 0)
				{
					return;
				}
				$("#shahr").load("'.GSMS::$class['template']->info['index'].'index/getShahr/"+ostanid, function(responseTxt, statusTxt, xhr){
					if(statusTxt == "success")
						;
					if(statusTxt == "error")
					{
						
						document.getElementById("notif").innerHTML="<div class=\"message-info\">خطا در ارتباط با سرور: " + xhr.status + ": " + xhr.statusText+"</div>";
					}
				});
			}
		</script>
		
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'admin/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#createDate").persianDatepicker();            
			});
		</script>
		<form   method="post" enctype="multipart/form-data">
		<div id="notif"></div>
       <table dir="rtl">

        <tr><td>عنوان شرکت </td>
		<td><input type="text" name="title" id="title"  value="'.$tempAdmin->title.'" /></td></tr>
		
        <tr><td>نام مدیرعامل</td>
		<td><input type="text" name="name" id="name"  value="'.$tempAdmin->name.'" /></td></tr>

        <tr><td>نام خانوادگی</td>
		<td><input type="text" name="family" id="family"  value="'.$tempAdmin->family.'" /></td></tr>

        <tr><td>کد ملی</td>
		<td><input type="text" name="melli" id="melli" value="'.$tempAdmin->melli.'"  /></td></tr>

        <tr><td>متن کوتاه درباره شرکت:</td>
		<td><textarea type="text" name="description" id="description" >'.$tempAdmin->description.'</textarea></td></tr>
		

        <tr><td>آدرس ایمیل : (mail@gmail.com)</td>
		<td><input type="text" name="mail" id="mail" value="'.$tempAdmin->mail.'"  /></td></tr>
         
        <tr><td>استان </td>
		<td>
			<select name="ostan" id="ostan"  onchange="getShar(this.value)">
				' . $ostan_body . '
				</select>
		</td>
		</tr>

        <tr><td>شهر</td>
		<td >
				<select name="shahr" id="shahr">

					<option value=0>همه شهر ها</option>
				</select>
		</tr>
		

		<tr><td>شماره موبایل</td>
		<td><input type="text" name="mobile" id="mobile" value="'.$tempAdmin->mobile.'"  /></td></tr>
        

		<tr><td>شماره تلفن منزل</td>
		<td><input type="text" name="homePhone" id="homePhone"  value="'.$tempAdmin->home_phone.'"  /></td></tr>
        

		<tr><td>شماره تلفن محل کار</td>
		<td><input type="text" name="workPhone" id="workPhone" value="'.$tempAdmin->work_phone.'"   /></td></tr>
         

		<tr><td> کد پستی منزل</td>
		<td><input type="text" name="homePostal" id="homePostal" value="'.$tempAdmin->home_postal_code.'"  /></td></tr>
         

		<tr><td> کد پستی محل کار</td>
		<td><input type="text" name="workPostal" id="workPostal" value="'.$tempAdmin->work_postal_code.'" /></td></tr>
        

		 <tr><td>آدرس منزل :</td>
		<td><textarea type="text" name="homeAddress" id="homeAddress" >'.$tempAdmin->home_address.'</textarea></td></tr>
		

		 <tr><td>آدرس محل کار :</td>
		<td><textarea type="text" name="workAddress" id="workAddress" >'.$tempAdmin->work_address.'</textarea></td></tr>
		  
        <tr><td >
		تصویر نشان تجاری </td><td><input  onchange="readURL(this,\'imgicon\');"  type="file" name="icon" id="icon" />
					<img id="imgicon" src="'.GSMS::$class['template']->info['index_url'].'iconGroupView/0"/>
		</td></tr> 
		

		<tr><td>  تاریخ تاسیس  </td>
		<td><input type="text" name="createDate" id="createDate" value="'.$tempAdmin->createDate.'" /></td>
		</tr>
		<tr>
		  <td >  اطلاع رسانی با پیامک</td>
		  <td>
				<label style="float:right; padding-left:10px; width:250px;">
                    <input id="service" name="is_sms_notic"  style="width:25px; height:25px" 
                    type="checkbox" '. (intval( $tempAdmin->is_sms_notic  )==1  ? " checked" : "" ).'> فعال</label>
		  </td>
		</tr>
		<tr>
		  <td> اطلاع رسانی با ایمیل</td>
		  <td>
				<label style="float:right; padding-left:10px; width:250px;">
                    <input id="service" name="is_email_notic"  style="width:25px; height:25px" 
                    type="checkbox" '. (intval( $tempAdmin->is_email_notic  )==1  ? " checked" : "" ).'> فعال</label>
                
		  </td>
		</tr>
		<tr>
			<td>موقعیت جغرافیایی شرکت</td>
			<td><input  type="hidden" name="google_position" id="google_position" />
				<div id="map_canvas" style="width:80%; height:300px"></div>
			</td>
		</tr>
		
        <tr><td><input type="submit" class="btn btn-success btn-register" name="submit" id="submit" value="ثبت اطلاعات" /></tr>
		</table>
        </form><br/>
		<script>
			function readURL(input,id) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						
						$("#"+id)
							.attr("src", e.target.result);
					};

					reader.readAsDataURL(input.files[0]);
				}
			}
			</script>
		<script >
			initialize();
		</script >
		
		<a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>
		'; 
        $body .= '<a class="back_btn" href="' .
            GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' => 'ويرايش پروفایل ', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}