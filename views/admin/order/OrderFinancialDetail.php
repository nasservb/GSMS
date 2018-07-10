<?php //allahoma sale ala mohammad va ale mohammad
 

class OrderFinancialDetail
{
	function OrderFinancialDetail($temp)
	{
	
        //---------------initializing-----------
		$inf = array('page_title' => 'تراکنش مالی سفارش','activeTab' => 'orders');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'admin_header');
		//-------------------
		$body = '';
		if($temp==null){
			$body .= 'سفارشی يافت نشد<br><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';

            $inf = array('title' => 'اطلاعات سفارش', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
		}
		$orderOptionValues = $temp['orderOptionValues'];
		GSMS::load('formcreator','libs','','require');
		$formCr = new formcreator();
		$optionBody = $formCr->createFormForReview($orderOptionValues);
		
		$factures = $temp['factureRes'][0];
		$userOrder = $temp['userOrder'];
		$orderType = $temp['orderType'];
		$orderTitle= $temp['orderTitle'];
		$admin = $temp['admin'] ;
		$services= $temp['services'];
		$userContent=$temp['userContent'];
		$particularColors=$temp['particularColors'];
		$publisherInfo = $temp['publisherInfo'];
		$verifierInfo = $temp['verifierInfo'];
		
		$osrderFinancialStatusValue = $temp['osrderFinancialStatusValue'];
		
		//$orderFinancialValuesRes =$temp['orderFinancialValuesRes'];
		//$financialStatusRes = $temp['financialStatusRes'];
		//$financialStatusOptionRes = $temp['financialStatusOptionRes'];
		
		//var_dump($financialStatusOptionRes);
		
		$printCost = $userOrder->printPrice;
		$servicesCompCost=$userOrder->servicePrice;//khadamat takmili
		$servicesCost=0;//hazineh service
		
		if(is_array($userContent))
		{
			foreach($userContent as $value) 
			{
				$countTemp=intval($value['count']);
				$priceTemp=intval($value['price']);
				$servicesCost+=$countTemp*$priceTemp;
			}
		}
		
		$totalCost = $printCost+$servicesCost+$servicesCompCost;
		$servicesid='';
		GSMS::$class['session']->set('userOrderPrice',$totalCost);
		
		$tempFileArray = '';
		if($userOrder->order_file_id > 0){
			$tempFileArray = explode(',', $userOrder->order_file_id);
			//var_dump($tempFileArray);
			$firstFileId = $tempFileArray[0];
		}
		
		$body .= '
			<link rel="stylesheet" href="'.GSMS::$siteURL . GSMS::$outputDir.'assets/css/magnific-popup.css">
			<script src="'. GSMS::$siteURL . GSMS::$outputDir.'assets/js/jquery.magnific-popup.js"></script>
		';
		
		
		$body .= '
		<br/>
		<div style="text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		<div class="row">
		
			
				<div class="col-sm-6 pull-right"> 
					<table class="table">
						<tr>
							<td>عنوان سفارش</td>
							<td>'.$userOrder->name.'</td>
						</tr>
						<tr>
							<td>شماره موبایل</td>
							<td>'.$userOrder->ownerMobile.'</td>
						</tr>
						<tr>
							<td>فرد پیگیر</td>
							<td>'.$userOrder->adminName.'</td>
						</tr>
						<tr>
							<td>چاپ خارج از نوبت</td>
							<td>'.($userOrder->isVip ==1 ? 'بله' : 'خیر').'</td>
						</tr>
						'.
						($userOrder->typeId>0 ?'<tr>
							<td>نوع فرم</td>
							<td>'.$orderType.'</td>
						</tr>' : '')
						.
						'<tr>
							<td>نوع سفارش</td>
							<td>'.($userOrder->titleId>0 ? 'سفارش کلی و تماس همکاران ما برای گرفتن جزئیات': ' جزئیات سفارش وارد شده').'</td>
						</tr>' 
						.
						($userOrder->titleId >0 ?'<tr>
							<td>عنوان فرم</td>
							<td>'.$orderTitle.'</td>
						</tr>':'');
						
						if($userOrder->typeId>0)
						{
							
							$color=array();
							$paper=array();
							$color2=array(1=>'یک رو',2=>'دو رو'); 
							
							$body .=
							($userOrder->typeId !=3 ?	//shit
							'<tr>
								<td>طول سفارش</td>
								<td>'.$userOrder->orderHeight.' میلیمتر</td>
							</tr> 
							<tr>
								<td>عرض سفارش</td>
								<td>'. $userOrder->orderWeidth .' میلیمتر</td>
							</tr>':'')
							. $optionBody .
							($userOrder->typeId ==4 ?	//lable
							' <tr>
								<td>عرض تحویلی</td>
								<td>'. intval($userOrder->delivery_width).' </td>
							</tr>
							<tr>
								<td>وزن تحویلی</td>
								<td>'. intval($userOrder->delivery_weight).' کیلوگرم</td>
							</tr>
							<tr>
								<td>فایل نمونه شاهد</td>
								<td>
								<td>
								<a class="image-popup-vertical-fit" href="'.
									(intval($userOrder->shahed_pic_id)>0 ? 
										GSMS::$class['template']->info['index_url'].'coverView/'. $userOrder->shahed_pic_id
										:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/404.png')
								.'" >
								<img width="150" height="150" src="'.
								   (intval($userOrder->shahed_pic_id)>0 ? 
											GSMS::$class['template']->info['index_url'].'iconView/'. $userOrder->shahed_pic_id			
										:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/404.png')
								   .'" />
								</a>
								</td>
							</tr>
							':'');
							
							$body .= '<tr><td>رنگ</td>
							<td>'.($userOrder->cColor ? '<div>C</div>' : '' ).'
							'.($userOrder->mColor ? '<div>M</div>' : '' ).'
							'.($userOrder->yColor ? '<div>Y</div>' : '' ).'
							'.($userOrder->kColor ? '<div>K</div>' : '' ).'</td>
							
							</tr>';
							
							$tempStr = '';
							if(is_array($particularColors) && !empty($particularColors)){
								$tempStr = '
								<tr>
									<td>رنگ های خاص</td>
									<td></td>
								</tr>';
								foreach($particularColors as $particValue){
									$tempStr .= '
									<tr>
										<td></td>
										<td>'.$particValue['color_name'].'</td>
									</tr>';
								}
							}
							$body.= $tempStr;
							
							if($userOrder->typeId ==3 || $userOrder->typeId ==4){
								$body .='
								<tr>
									<td>خدمات کار تکمیلی</td><td>
									 ';
									if(is_array($services)) 
									{
										foreach($services as $service) 
										{
											$temp ='<div>'. $service['service'] .'</div>';
											$body.=$temp;
											$servicesid.=$service['id'].',';
										}
									}
								$body.='</td>
								</tr>';
							}
								
							
						}
						
						$body.=
						'<tr>
							<td>تیراژ / تعداد سفارش</td>
							<td>'.$userOrder->count.' '.  $userOrder->countUnit .'</td>
						</tr>
						<tr>
							<td>کاربر</td>
							<td>'.$admin->name . ' ' . $admin->family .'</td>
						</tr>
						<tr>
							<td>نام کاربری</td>
							<td>'.$admin->username.'</td>
						</tr>
						<tr>
							<td>هزینه چاپ</td>
							<td>'.$printCost.'</td>
						</tr>
						<tr>
							<td>هزینه خدمات تکمیلی</td>
							<td>'.$servicesCompCost.'</td>
						</tr>
						<tr>
							<td>هزینه سرویس</td>
							<td>'.$servicesCost.'</td>
						</tr>
						<tr>
							<td>مجموع هزینه</td>
							<td>'.$totalCost.'</td>
						</tr>
						<tr>
							<td>مشخصات</td>
							<td>'. str_replace("\n",'<br>',$userOrder->description).'</td>
						</tr>
						
						
					</table> 
				</div>
				<div style="text-align: left;" class="col-sm-3">';
				$fileArrCoutn = count($tempFileArray);
				
				if(is_array($tempFileArray) && $fileArrCoutn > 0 )
				{
					for($itemp=0 ; $itemp < ($fileArrCoutn-1) ; $itemp++){
						$body .= '
						<div class="row">
						<a class="image-popup-vertical-fit" href="'.
							(intval($userOrder->order_file_id)>0 ? 
								GSMS::$class['template']->info['index_url'].'coverView/'. $tempFileArray[$itemp]
								:	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundlg.jpg')
							.'" >
							<img width="10" height="10" src="'.
							(intval($userOrder->order_file_id)>0 ? 
							GSMS::$class['template']->info['index_url'].'iconView/'. $tempFileArray[$itemp]
						:  	GSMS::$siteURL. GSMS::$outputDir .'assets/images/imagenotfoundsm.jpg')
							.'" /> 
						</a></div><br/>
						';
					}
				}
				$body .= '</div>
			
		
		<div class="row col-sm-12 pull-right table-responsive">';
			if($userOrder->typeId>0)
			{
					
				if(is_array($userContent))
				{
					$body .='
					<table id="selectedServiceTable" class="table" >
						<thead class="text-primary">
						<th class="text-right">نوع سرویس</th>
						<th class="text-right">نام سرویس</th>
						<th class="text-right">تعداد</th>
						<th class="text-right">قیمت پایه</th>
						</thead>';	
						foreach($userContent as $value) 
						{
							$body.='<tr>';
							$body.='<td>'.$value['type'].'</td>
							<td>'.$value['service'].'</td>
							<td>'.$value['count'].'</td>
							<td>'.$value['price'].'</td>
							';
							$body.='</tr>';
						}
						$body.='</table>';
					}
					else
					{
						$body.='<div class="alert alert-warning col-sm-6 pull-right">بدون سرویس اضافی</div>';
					}
					
				
			}
			$body.='
			</div>';
			
			$orderStatusValueSt = '';
			if($osrderFinancialStatusValue[0]['status_id']==3){
				$financialBankRes = $temp['financialBankRes'];
				$orderStatusValueSt .= '
				<tr><td>تاریخ</td><td>'.$financialBankRes[0]->mdate.'</td></tr>
				<tr><td>بانک</td><td>'.$financialBankRes[0]->bank.'</td></tr>
				<tr><td>نام صاحب حساب</td><td>'.$financialBankRes[0]->name.'</td></tr>
				<tr><td>مبلغ چک(ريال)</td><td>'.$financialBankRes[0]->value.'</td></tr>
				<tr><td>در وجه</td><td>'.$financialBankRes[0]->payTo.'</td></tr>
				';
			}
			else if($osrderFinancialStatusValue[0]['status_id']==4){
				$financialTimeRes = $temp['financialTimeRes'];
				$orderStatusValueSt .= '
				<tr><td>ضمانت پرداخت</td><td>'.$financialTimeRes[0]->warranty.'</td></tr>
				<tr><td>زمان تسویه</td><td>'.$financialTimeRes[0]->value.'</td></tr>
				<tr><td>مبلغ کل هنگام تسویه(ريال)</td><td>'.$financialTimeRes[0]->mdate.'</td></tr>
				';
			}
			
			
			$body.='<div class="row col-sm-12 pull-right table-responsive">
			<h3>وضعیت مالی</h3>
			<table id="selectedServiceTable" class="table">
			<tr><td>'.$osrderFinancialStatusValue[0]['status'].'</td></tr>
			'.$orderStatusValueSt.'
			</table>';
			
			$body.='</div>';
			$body.='<div class="row col-sm-12 pull-right table-responsive">
				<h3>صورت حساب های سفارش</h3>';
				$factureCount = count($factures);
				if($factureCount > 0){
					$body.='
					<table class="table table-bordered">
					<thead class="text-primary">
						<th class="text-right">عنوان</th>
						<th class="text-right">شماره</th>
						<th class="text-right">مبلغ کل</th>
						<th class="text-right">مبلغ دریافتی</th>
						<th class="text-right">وضعبت</th>
						<th class="text-right">صادر کننده</th>
						<th class="text-right">تایید کننده</th>
						<th class="text-right">تاریخ سررسید</th>
						<th class="text-right">جزییات</th>
					</thead>
					<tbody>';
					foreach($factures as $value){
						//$publisherInfo = $temp['publisherInfo'];
						//$verifierInfo = $temp['verifierInfo'];
						$publisherName = '';
						$verifierName = '';
						foreach($publisherInfo as $publisherValue){
							if($publisherValue['admin_id'] == $value->userpublisherid){
								$publisherName = $publisherValue['username'];
								break;
							}
						}
						foreach($verifierInfo as $verifierValue){
							if($verifierValue['admin_id'] == $value->userverifierid){
								$verifierName = $verifierValue['username'];
								break;
							}
						}
						$body.='
							<tr>
							<td>'.$value->title.'</td>
							<td>'.$value->id.'</td>
							<td>'.$value->totalAmount.'</td>
							<td>'.$value->recieve.'</td>
							<td '.($value->isaccept > 0 ? 'class="text-success">تایید شده' : 'class="text-danger">تایید نشده').'</td>
							<td>'.$publisherName.'</td>
							<td>'.$verifierName.'</td>
							<td>'.$value->dateDue.'</td>
							<td>
							<a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'].'accounting/viewFacture/'.$value->id.'">مشاهده</a>
							</td>
							</tr>
						';
					}
					$body.='
					</tbody>
					</table>';
				}
				else{
					$body .= '<div class="alert alert-danger col-lg-4 col-md-6 col-sm-6 pull-right">برای این سفارش صورتحسابی صادرنشده است.</div>';
				}
				
			
			//var_dump($optionElements);
				
			$body.='</div>';
			$body.='</div>';
			
			//var_dump($financialStatusOptionRes);
			
			$body.='<div class="row col-sm-12 pull-right">
			<a class="btn btn-primary " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewHistory/'.$userOrder->id.'">مشاهده سوابق</a>
			<a class="btn btn-success " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/editOrderFinancialDetail/'.$userOrder->id.'">بروزرسانی وضعبت مالی</a>
			</div>
		';
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
		
		$body .= '</div>';
		$inf = array('title' =>  'مشخصات سفارش شماره: '.$userOrder->id, 'body' => $body);
		GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
		
		 
        
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}