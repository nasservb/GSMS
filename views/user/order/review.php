<?php
define("Lito",1);
define("Rol",2);
define("Shit",3);
define("Lable",4);
define("Patern",5);

class review
{
    function review($temp)
    {
		//---------------initializing-----------
		$inf = array('page_title' => 'اطلاعات سفارش','activeTab'=>'orders');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
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
		
		$userOrder=$temp['userOrder'];
		
	
		

		
		$services= $temp['orderServices'];
		
		
		
		list($tempFileArray) = $temp['pictures'];
		 
		$printCost=200000;
		$servicesCompCost=100000;
		$servicesCost=0;
		
		if(is_array($userContent))
		{
			foreach($userContent as $value) 
			{
				$countTemp=intval($value['count']);
				$priceTemp=intval($value['price']);
				$servicesCost+=$countTemp*$priceTemp;
			}
		}
		
		$totalCost = $printCost+$servicesCost;
		
		GSMS::$class['session']->set('userOrderPrice',$totalCost);
		
		$body .= '
		<link rel="stylesheet" href="'.GSMS::$siteURL . GSMS::$outputDir.'assets/css/magnific-popup.css">
		<script src="'. GSMS::$siteURL . GSMS::$outputDir.'assets/js/jquery.magnific-popup.js"></script>
		';
		
		$body .= '        
		<br/>
		<style>
			.card img {width:15%}
		</style>
        <div style="width: 85%;
                    height: 8px;
                    background-color: #C9D1D7;
                    border-radius: 15px;
                    margin: 15px;
                    position: relative;">

                        <div class="progress_bg" style="width:50%"></div>
                    <span style="background-position: -2px -2px;right: 2%;" class="step-item">
                    <a class="s_title">
                    سفارش     
                    </a></span>
                                                                    
                    <span style="background-position: -2px -33px;right: 50%;" class="step-item">
                    <a href="#"  style="color:blue;">
                    بازبینی 
                    </a></span>
                    <span style="background-position: -2px -70px;right: 100%;" class="step-item">
                    <a>
                      پرداخت
                    </a></span>
                    
        </div>';
		
		
		$body .= '
		<br/>
		<div class="message-info" style="text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		<table class="table table-bordered">
		<thead>
			<tr>
				<th style="text-align: right;"> اطلاعات سفارش شما</th>
			</tr>
		</thead>
		<tbody>
		
			<tr id="tr_even">
				<td> 
					<table class="table table-striped table-hover" >
						<tr>
							<td>عنوان فرم</td>
							<td>'.$temp['serviceType'].'</td>
						</tr>
						<tr>
							<td>عنوان سفارش</td>
							<td>'.$temp['subService'].'</td>
						</tr>
						<tr>
							<td>ابعاد سفارش</td>
							<td>'.$temp['serviceSize'].'</td>
						</tr>
						<tr>
							<td>شماره موبایل</td>
							<td>'.$userOrder->ownerMobile.'</td>
						</tr>
						
						';
						
						$body .= $optionBody;
						
						
						$body .='
						<tr>
							<td>خدمات کار تکمیلی</td><td>
							 ';

							if(is_array($services)) 
							{
								foreach($services as $service) 
								{
									$body.='<div>'. $service['service'] .'</div>';
									
								}
							}

						$body.='</td>
						</tr>';
						
						
						
						$body.=
						'<tr>
							<td>تیراژ / تعداد سفارش</td>
							<td>'.$userOrder->count.' سری</td>
						</tr>
						<tr>
							<td>نحوه ارسال</td>
							<td>'.$temp['userSend'].' </td>
						</tr>
						<tr>
							<td> سریال</td>
							<td>'.($userOrder->isCheckSertial == 1 ?  'از شماره ' .$userOrder->serial1 . ' تا شماره '. $userOrder->serial2 : 'بدون شماره سریال' ).' </td>
						</tr>
						<tr>
							<td>توضیحات</td>
							<td>'. str_replace("\n",'<br>',$userOrder->description).'</td>
						</tr>
						
					</table> 
				</td>
			</tr>';
			if( count($tempFileArray) > 0 )
			{
				$body .= '<tr>
						<td>تصاویر : </td>
					</tr>
					<tr>
						<td style="text-align: right;" class="col-md-2">';
		
				
				for($i=0 ; $i < count($tempFileArray) ; $i++){
						
					$body .= '
							<a class="image-popup-vertical-fit" href="'.							
								GSMS::$class['template']->info['index_url'].'coverView/'. $tempFileArray[$i]->Id						
							.'" >
							<img width="10" height="10" src="'.							
							GSMS::$class['template']->info['index_url'].'iconView/'. $tempFileArray[$i]->Id							
							.'" /> 
							</a>
						';
				}
				$body .= '</td></tr>';
			}
				
				
				$body .= ' 
		</tbody>
		</table><br/>';
		
			
		
			$body.='
			<div class="col-sm-12">
			<a href="'.GSMS::$class['template']->info['user_url'] .'orders/selectPayment/'.$userOrder->id.'"  class="btn btn-success"> 
			تایید اطلاعات و انتخاب روش پرداخت
			</a>
			<a class="btn" href="'.GSMS::$class['template']->info['user_url'] .'orders/'.($userOrder->typeId == 1 ? 'orderRegister/': 'taxOrderRegister').$userOrder->id.'">برگشت</a>
			</div>
		</form>';
		
		$body .= "</div>
		<script>
		
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
		$inf = array('title' =>  'باربینی اطلاعات  سفارش شما ', 'body' => $body);
		GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
	}
	
}
if (!defined("GSMS")) {
    exit("Access denied");
}
?>