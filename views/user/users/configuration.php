<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class configuration
{
    function configuration($info)
    {
        //free result
        $inf = array('page_title' => 'تنظیمات پروفایل','activeTab'=>'profile');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'user_header');
        //----------------------------------
		
		$tempAdmin=$info['admin'];
        if (!is_object($tempAdmin)) 
		{
            $body = 'اطلاعات کاربري يافت نشد';
            GSMS::$class['template']->message(
				'ويرايش پروفایل' ,		//title
				$body,					//body
				'user',					//part
				'alert alert-warning',	//css class
				true,					//format output
				false,						//return button
				array('activeTab'=>'accounting')); //extra argument 
			return;
        }
		
		//var_dump($tempAdmin);
        //if
		
		$ostan_body = '<option value=0>همه استان ها</option>';
        $categorys = $info['ostan'];
        for ($i = 0; $i < count($categorys); $i++)
            $ostan_body .= '<option value="' . $categorys[$i]['id'] . '" '.($tempAdmin->ostan_id == $categorys[$i]['id'] ? ' selected' : '').' >' .
			$categorys[$i]['name'] . '</option>' . '\n';

		$body ='<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/dropzone.css" type="text/css" rel="stylesheet" />
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/dropzone.min.js"></script>';
		$body .= '
		<link rel="stylesheet" href="'.GSMS::$siteURL . GSMS::$outputDir.'assets/css/magnific-popup.css">
		<script src="'. GSMS::$siteURL . GSMS::$outputDir.'assets/js/jquery.magnific-popup.js"></script>
		';
			
        $body .= '
		<br/>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
		var map;
		var marker;
		function initialize() 
		{
			var latlng = new google.maps.LatLng('.(intval($tempAdmin->google_x)> 0 ? $tempAdmin->google_x.','.$tempAdmin->google_y : '35.69187929931617,51.394429206848145' ).'
			);
			var myOptions = 
			{
			  zoom: 16,
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
					  title:"محل "
				  });
			  }
			  else 
			  {
				marker.setPosition( location);
			  }

			 document.getElementById("google_position").value=location;
			 
		 }

		 '.(intval($tempAdmin->google_x)> 0 ? 'placeMarker(new google.maps.LatLng('.$tempAdmin->google_x.','.$tempAdmin->google_y.'));':'').'
		
		}

		
			
		</script>
		<script>
			var shahrId = '.intval($tempAdmin->shahr_id).';


			function getShar(ostanid)
			{
				if(ostanid == 0)
				{
					return;
				}
				$("#shahr").load("'.GSMS::$class['template']->info['index'].'index/getShahr/"+ostanid, function(responseTxt, statusTxt, xhr){
					if(statusTxt == "success")
						if (shahrId > 0 )
							$("#shahr").val(shahrId);
							
					if(statusTxt == "error")
					{
						
						document.getElementById("notif").innerHTML="<div class=\"message-info\">خطا در ارتباط با سرور: " + xhr.status + ": " + xhr.statusText+"</div>";
					}
				});
			}
		</script>
		
		<link href="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/css/persianDatepicker-default.css" rel="stylesheet" type="text/css">
		<script src="' . GSMS::$siteURL . GSMS::$outputDir . 'assets/js/persianDatepicker.min.js"></script>
		<script >
			 $(function() {
				$("#createDate").persianDatepicker();            
			});
		</script>
		
<form id="registerForm" method ="POST" enctype="multipart/form-data">
<div id="notif"></div>
       
	   
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">عنوان شرکت</label>
			<input type="text" class="form-control" name="title" id="title"  value="'.$tempAdmin->title.'" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">نام مدیرعامل</label>
			<input type="text" class="form-control"  name="name" id="name"  value="'.$tempAdmin->name.'" />
		 </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">نام خانوادگی</label>
			<input type="text" class="form-control" name="family" id="family"  value="'.$tempAdmin->family.'" />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">کد ملی</label>
			<input type="text" class="form-control"  name="melli" id="melli" value="'.$tempAdmin->melli.'" />
		 </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">کد پستی محل کار</label>
			<input type="text" class="form-control" name="workPostal" id="workPostal" value="'.$tempAdmin->work_postal_code.'"  />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">آدرس ایمیل </label>
			<input type="text" class="form-control"  name="mail" id="mail" value="'.$tempAdmin->mail.'" />
		 </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">متن کوتاه درباره شرکت</label>
			<textarea class="form-control" name="description" id="description" >'.$tempAdmin->description.'</textarea>
		<span class="material-input"></span></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">استان</label>
			<select name="ostan" id="ostan" class="form-control"  onchange="getShar(this.value)">
				' . $ostan_body . '
			</select>
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">شهر</label>
			<select name="shahr" class="form-control" id="shahr">
				<option value=0>همه شهر ها</option>
			</select>
		 </div>
	</div>
</div>

		

<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">شماره موبایل</label>
			<input type="text" class="form-control" name="mobile" id="mobile" value="'.$tempAdmin->mobile.'"  />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">شماره تلفن منزل</label>
			<input type="text" class="form-control"  name="homePhone" id="homePhone"  value="'.$tempAdmin->home_phone.'" />
		 </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">شماره تلفن محل کار</label>
			<input type="text" class="form-control" name="workPhone" id="workPhone" value="'.$tempAdmin->work_phone.'"  />
		<span class="material-input"></span></div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">کد پستی منزل</label>
			<input type="text" class="form-control" name="homePostal" id="homePostal" value="'.$tempAdmin->home_postal_code.'" />
		 </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">آدرس منزل</label>
			<textarea class="form-control" name="homeAddress" id="homeAddress" >'.$tempAdmin->home_address.'</textarea>
		 </div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">آدرس محل کار</label>
			<textarea class="form-control"  name="workAddress" id="workAddress" >'.$tempAdmin->work_address.'</textarea>
		<span class="material-input"></span></div>
	</div>
</div>

 
	
	
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">اطلاع رسانی با پیامک</label> 
            <input class="form-control" id="service" name="is_sms_notic"  style="width:25px; height:25px" 
                    type="checkbox" '. (intval( $tempAdmin->is_sms_notic  )==1  ? " checked" : "" ).'> فعال 
					
		 </div>
	</div>
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">اطلاع رسانی با ایمیل</label>
			<input class="form-control" id="service" name="is_email_notic"  style="width:25px; height:25px" 
                    type="checkbox" '. (intval( $tempAdmin->is_email_notic  )==1  ? " checked" : "" ).'> فعال 
		 </div>
	</div>
</div>
	 
<div class="row">		  
	<div class="col-md-2">
		<div class="form-group is-empty">
				<label class="control-label">تصویر نشان تجاری</label>
			<a class="image-popup-vertical-fit" href="'.
				(intval($tempAdmin->icon_picture_id)>0 ? 
					GSMS::$class['template']->info['index_url'].'coverView/'. $tempAdmin->icon_picture_id
					:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundlg.jpg')
			.'" >
				<img width="150" height="150" src="'.
				   (intval($tempAdmin->icon_picture_id)>0 ? 
							GSMS::$class['template']->info['index_url'].'iconView/'. $tempAdmin->icon_picture_id			
						:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundsm.jpg')
				   .'" />
			</a>
		</div>
	</div>
</div>


	
<div class="row">
	<div class="col-md-12">
		<div class="form-group is-empty">
			<label class="control-label">موقعیت جغرافیایی شرکت</label> 
            <input  type="hidden" name="google_position" id="google_position" />
			<div id="map_canvas" style="width:80%; height:300px;margin-right: 20px;border: 1px solid #8d05d2;"></div>
					
		 </div>
	</div>
</div>
</form>';

$body .='
	<div class="col-sm-12" style="border: 1px solid #1c44d5; border-radius: 5px; padding: 15px;">
		<div class="col-md-4 col-sm-12">
		آپلود نشان تجاری <br>
		(در صورت بارگذاری تصویر جدید تصویر قبلی حدف می شود.)
		</div>
		<div class="col-md-8 col-sm-12">
			<div id="dropzone" class="dropzone"></div>
			<script>var myDropzone = new Dropzone("#dropzone", { 
			url: "' . GSMS::$class['template']->info['user_url'] . 'users/uploadAjaxFile"});</script>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group is-empty">
			<input type="button" class="btn btn-success" onclick="checkForm()" value="ثبت اطلاعات" /> 
		 </div>
	</div>
	
	<div id="checkResult" class="col-sm-12 "></div>
';

/*
<div class="row">
	<div class="col-md-6">
		<div class="form-group is-empty">
			<label class="control-label">تاریخ تاسیس</label>
			<input type="text" class="form-control" name="createDate" id="createDate" value="'.$tempAdmin->createDate.'"  />
			<span class="material-input"></span>
		</div>
	</div>
</div>
*/
$body .="
<script>
	document.addEventListener('DOMContentLoaded', function(event) { 
		getShar($('#ostan').val());
		
		
		 

	});

	$('.image-popup-vertical-fit').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		}
		
	});

</script>
";

$body .= '
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
	$("#checkResult").hide("fast");
	function checkForm()
	{
		$("#checkResult").hide("fast");
		result  = "" ; 
		
		if($("#title").val()  < 3 )
			result = result + "عنوان به درستی وارد نشده است.<br/>" ;
		if($("#name").val()  < 3 )
			result = result + "نام مدیر عامل به درستی وارد نشده است.<br/>" ;
		if($("#family").val()  < 3 )
			result = result + "نام خانوادگی به درستی وارد نشده است.<br/>" ;
		//if($("#mail").val()  < 3 )
		//	result = result + "آدرس ایمیل به درستی وارد نشده است.<br/>" ;
		if($("#description").val()  < 3 )
			result = result + "درباره شرکت به درستی وارد نشده است.<br/>" ;
		if($("#ostan").val()  < 1 )
			result = result + "استان انتخاب نشده است.<br/>" ;
		if($("#shahr").val()  < 1 )
			result = result + "شهر انتخاب نشده است.<br/>" ;
		
		if($("#workAddress").val()  < 3 )
			result = result + "آدرس محل کار به درستی وارد نشده است.<br/>" ;
		
		
		//if( !($.isNumeric($("#melli").val())) )
		//	result = result + "کد ملی باید عدد باشد.<br/>" ;
		//if( !($.isNumeric($("#workPostal").val())) )
		//	result = result + "کد پستی باید عدد باشد.<br/>" ;
		if( !($.isNumeric($("#mobile").val())) )
			result = result + "شماره موبایل باید عدد باشد.<br/>" ;
		//if( !($.isNumeric($("#homePhone").val())) )
		//	result = result + "شماره تلفن منزل باید عدد باشد.<br/>" ;
		//if( !($.isNumeric($("#workPhone").val())) )
		//	result = result + "شماره تلفن محل کار باید عدد باشد.<br/>" ;
		//if( !($.isNumeric($("#homePostal").val())) )
		//	result = result + "کدپستی منزل باید عدد باشد.<br/>" ;
		
		
		
		if(result.length > 1 )
		{
			$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا های زیر را بررسی کنید : <br/>"+ result) ;
			$("#checkResult").show("slow");
			return false ; 
		} 
		$("#checkResult").hide("fast");
		document.getElementById(\'registerForm\').submit();
		return true ;
	}
</script>'; 
       
        $inf = array('title' => 'تنظیمات پروفایل ', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}