<?php //allahoma sale ala mohammad va ale mohammad
 

class viewReceipt
{
    function viewReceipt($temp)
    {
        //---------------initializing-----------
        $inf = array('page_title' => ' نمایش فیش واریزی ','activeTab' => 'accounting');
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf,'admin_header');
		
		
		
		$inf['title'] = $inf['page_title'] ;
        //------------------------
		
		$tempReceipt = $temp['Receipt'];
		$facture = $temp['Facture'];  
		
		$acceptorUser = $temp['acceptor']; 
		$accpetorSt = '';
		if(!empty($acceptorUser) && $acceptorUser->id>0 ){
			$accpetorSt = '<tr><td>نام تایید کننده</td><td>'.$acceptorUser->name. ' ' . $acceptorUser->family.'</td></tr>
			<tr class="danger"><td>نام کاربری تایید کننده</td><td>'.$acceptorUser->username.'</td></tr>
			';
		}
		//var_dump($accpetorSt);
        
		$bottunSt = '';
		$factureId = intval($tempReceipt->factureid);
		if($tempReceipt->isAccept > 0 ){
			$bottunSt = '<div class="alert alert-success">فیش واریزی تایید شده است.</div>';
		}
		else if($tempReceipt->isAccept == 0 && $factureId > 0){
			$bottunSt = '
			<form enctype="multipart/form-data" method="post" action ="'. GSMS::$class['template']->info['admin_url'] .'accounting/acceptReceipt2/'.$tempReceipt->id.'">
			<button class="btn btn-primary" type="submit" name="submit" id="submit">تایید‌ فیش واریزی و مشاهده صورت حساب</button>
			</form>';
		}
		else if($tempReceipt->isAccept == 0 && $factureId == 0){
			$bottunSt = '<a  href="'. GSMS::$class['template']->info['admin_url'].'accounting/publishManTransFacture/' . $tempReceipt->id . '" class=" btn btn-primary " >تایید‌ فیش واریزی و صدور صورت حساب</a>';
		}
		
        $body = '';
        $inf['balanceType'] = R::getAll('SELECT id,name FROM  balance_type where id='.$tempReceipt->manualtransTypeId);
		
		$body .= '
			<link rel="stylesheet" href="'.GSMS::$siteURL . GSMS::$outputDir.'assets/css/magnific-popup.css">
			<script src="'. GSMS::$siteURL . GSMS::$outputDir.'assets/js/jquery.magnific-popup.js"></script>
		';
		
        $body .= '
		<div class="message-info table-responsive">
		<table class="table table-hover">
		
		<tr class="success"><td>ردیف</td><td>'.$tempReceipt->id.'</td></tr>
		<tr><td>نحوه ی واریز </td><td>' . $inf['balanceType'][0]['name'] . '</td></tr>
		<tr class="info"><td>شماره فیش</td><td>'.$tempReceipt->refNum.'</td></tr>
		<tr><td>نام شخص /شرکت واریز کننده</td><td>'.$tempReceipt->name.'</td></tr>
		<tr class="danger"><td>مبلغ واریزی (ریال)</td><td>'.$tempReceipt->totalAmount.'</td></tr>
		<tr><td>نام بانک</td><td>'.$tempReceipt->nameBank.'</td></tr>
		<tr class="success"><td>کد شعبه</td><td>'.$tempReceipt->branchCode.'</td></tr>
		<tr><td>تاریخ واریز </td><td>'.$tempReceipt->dateDeposit.'</td></tr>
		<tr class="info"><td>واریز به شماره حساب </td><td>'.$tempReceipt->depositAccountnum.'</td></tr>
		<tr><td>شماره تماس </td><td>'.$tempReceipt->depositAccountnum.'</td></tr>
		<tr class="danger"><td>ایمیل</td><td>'.$tempReceipt->email.'</td></tr>
		<tr><td>عنوان فاکتور</td><td>'.$facture->title.'</td></tr>
		<tr class="success"><td>کد فاکتور</td><td>'.$facture->id.'</td></tr>
		<tr><td>بابت(شرح واریز) </td><td>'.$tempReceipt->comment.'</td></tr>
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
		<tr class="info">
		<td>مشاهده تصویر</td>
		<td>
			<div class="col-md-4">
			<a class="image-popup-vertical-fit" href="'.
				(intval($tempReceipt->pictureid)>0 ? 
					GSMS::$class['template']->info['index_url'].'coverView/'. $tempReceipt->pictureid
					:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundlg.jpg')
			.'" >
			<img width="150" height="150" src="'.
			   (intval($tempReceipt->pictureid)>0 ? 
						GSMS::$class['template']->info['index_url'].'iconView/'. $tempReceipt->pictureid			
					:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundsm.jpg')
			   .'" />
			</a>
			</div>
		</tr>
		'.$accpetorSt.'
		<tr>
		<td>'. $bottunSt .'
		</td><td></td>
		</tr>
		
		</table>
		 ';
		$body .='</div>';
		
		$body.="
		<script>
			$('.image-popup-vertical-fit').magnificPopup({
				type: 'image',
				closeOnContentClick: true,
				mainClass: 'mfp-img-mobile',
				image: {
					verticalFit: true
				}
				
			});
		</script>";

        $inf = array('title' => '  نمایش فیش واریزی ', 'body' => $body);
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}