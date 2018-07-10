<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class viewReceipt
{
    function viewReceipt($tempReceipt)
    {
        $inf = array(
			'page_title' => 'نمایش فیش واریزی',
			'activeTab' => 'accounting'
		);
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		
        $body = '';
		
		$body .= '
		<link rel="stylesheet" href="'.GSMS::$siteURL . GSMS::$outputDir.'assets/css/magnific-popup.css">
		<script src="'. GSMS::$siteURL . GSMS::$outputDir.'assets/js/jquery.magnific-popup.js"></script>
		';
		
		$inf['balanceType'] = R::getAll('SELECT id,name FROM  balance_type where id='.$tempReceipt['Receipt']['manualtrans_type_id']);
         
        $body .= '
		<div class="message-info">
		<table dir="rtl" class="table table-striped  ">
		
			<tr>
				<td>ردیف</td>
				<td>'.$tempReceipt['Receipt']['id'].'</td>
			</tr>
			<tr>
				<td>نحوه ی واریز </td>
				<td>' . $inf['balanceType'][0]['name'] . '</td>
			</tr>
			<tr>
				<td>شماره فیش</td>
				<td>'.$tempReceipt['Receipt']['ref_num'].'</td>
			</tr>
			<tr>
				<td>نام شخص /شرکت واریز کننده</td>
				<td>'.$tempReceipt['Receipt']['name'].'</td>
			</tr>
			<tr>
				<td>مبلغ واریزی (ریال)</td>
				<td>'.$tempReceipt['Receipt']['total_amount'].'</td>
			</tr>
			<tr>
				<td>نام بانک</td>
				<td>'.$tempReceipt['Receipt']['name_bank'].'</td>
			</tr>
			<tr>
				<td>کد شعبه</td>
				<td>'.$tempReceipt['Receipt']['branch_code'].'</td>
			</tr>
			<tr>
				<td>تاریخ واریز </td>
				<td>'.$tempReceipt['Receipt']['date_deposit'].'</td>
			</tr>
			<tr>
				<td>واریز به شماره حساب </td>
				<td>'.$tempReceipt['Receipt']['deposit_accountnum'].'</td>
			</tr>
			<tr>
				<td>شماره تماس </td>
				<td>'.$tempReceipt['Receipt']['phone'].'</td>
			</tr>
			<tr>
				<td>ایمیل </td>
				<td>'.$tempReceipt['Receipt']['email'].'</td>
			</tr>
			<tr>
				<td>وضعیت</td>
				<td>
				'. ($tempReceipt['Receipt']['is_accept']>0 ?
				'<span class="text-success" >تایید و فاکتور صادر شده است<span>'
				:'<span class="text-danger" >در انتظار تایید<span>').'
				</td>
			</tr>
			<tr>
				<td>بابت(شرح واریز) </td>
				<td>'.$tempReceipt['Receipt']['comment'].'</td>
			</tr>
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
		<tr>
			<td>مشاهده تصویر فاکتور </td>
			<td>
			<div class="col-sm-4 pull-right">
				
				<a class="image-popup-vertical-fit" href="'.
					(intval($tempReceipt['Receipt']['pictureid'])>0 ? 
						GSMS::$class['template']->info['index_url'].'coverView/'. $tempReceipt['Receipt']['pictureid']
						:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundlg.jpg')
				.'" >
				<img width="150" height="150" src="'.
				   (intval($tempReceipt['Receipt']['pictureid'])>0 ? 
							GSMS::$class['template']->info['index_url'].'iconView/'. $tempReceipt['Receipt']['pictureid']
						:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundsm.jpg')
				   .'" />
				</a>
			
			
			
				
			</div>
			</td>
		</tr>
		<tr>
			<td>عملیات </td>
			<td>
			<a  href="'. GSMS::$class['template']->info['user_url'].'accounting/editReceipt/' . $tempReceipt['Receipt']['id'] . '" class="btn btn-success" >ویرایش</a> |
			<a  href="'. GSMS::$class['template']->info['user_url'].'accounting/deleteReceipt/' . $tempReceipt['Receipt']['id'] . '" class="btn  btn-danger" >حذف</a> 

		</td>
		</tr>
		
		</table>
		';
		
		$body .="<script>
		
			$('.image-popup-vertical-fit').magnificPopup({
				type: 'image',
				closeOnContentClick: true,
				mainClass: 'mfp-img-mobile',
				image: {
					verticalFit: true
				}
				
			});
		
		</script>";
		$body .='</div>';
						
		$inf = array(
			'title' => 'نمایش فیش واریزی',
			'body' => $body
		);
		GSMS::$class['template']->load($inf, 'user_index');
		GSMS::$class['template']->load($inf, 'user_footer');
		
		/*
        GSMS::$class['template']->message(
							' نمایش فیش واریزی' ,		//title
							$body,					//body
							'user',					//part
							'',	//css class
							false,					//format output
							false,						//return button
							array('activeTab'=>'accounting')); //extra argument
							
							*/
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}