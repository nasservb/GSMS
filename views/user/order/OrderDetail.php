<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class OrderDetail
{
	function OrderDetail($temp)
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
        ';
		
		//@،TODO
		//Add Work History timeline 

		$body .= '
		<br/>
		<div class="message-info" style="text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		<style>
			.card img {width:15%}
		</style>



<link href="'.GSMS::$class['template']->info['theme_url'].'css/ticket.css" rel="stylesheet" type="text/css">

		 <div  >
          <div  >
              <h3 id="timeline">تاریخچه سفارش  '.$userOrder->id.'</h3>
          </div>
          <ul class="timeline">';
		  foreach($temp['history'] as $history)
			{
				if($history['admin_id'] == $userOrder->adminId) 
				{
					$body .='<li class="timeline-inverted">
								<div class="timeline-badge info"><i class="material-icons">edit</i></div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">شما</h4>								
								';
				}
				else 
				{
					$body .='<li>
								<div class="timeline-badge success"><i class="material-icons">face</i></div>
									<div class="timeline-panel">
									  <div class="timeline-heading">
										<h4 class="timeline-title">کارشناس پشتیبانی : '.
										$history['name'] . ' '.$history['family']
										.'</h4>';
				}
				
				$body .= '
					 <p><small class="text-muted"><i class="material-icons">query_builder</i>'.$history['create_date'].'</small></p>
                  </div>
				   <div class="timeline-body">
					   <p>'.str_replace("\n",'<br>',$history['work_description']).' </p>
				   </div>
                </div>
              </li>';
			}//for
			
			if(count($responses) == 0 )
			{
				$body .= '
					<li>
					<div class="timeline-badge  "><i class="material-icons">person</i></div>
						<div class="timeline-panel">
						  <div class="timeline-heading">
							<h4 class="timeline-title">کارشناس</h4> 
						  </div>
						   <div class="timeline-body">
							   <p>در حال بررسی</p>
						   </div>
						</div>
					  </li>  ';
			}
			$body .= '
					<li class="timeline-inverted">
						<div class="timeline-badge info"><i class="material-icons">add</i></div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">شما</h4>
							<p><small class="text-muted"><i class="material-icons">query_builder</i>'.$userOrder->createDate.'</small></p>
						  </div>
						   <div class="timeline-body">
							   <p>سفارش توسط شما ثبت شد .  </p>
						   </div>
						</div>
					  </li> ';	
			
              $body .= '</ul>
					  </div>';
			
			



		$body .= '<table class="table table-bordered">
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
			</tr>
			<tr>
			    <td>تصاویر : </td>
			</tr>
			<tr>
				<td style="text-align: right;" class="col-md-2">';
				
		
				if( count($tempFileArray) > 0 )
				{
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
				}
				
				
				
				$body .= '</td>
			</tr>
		</tbody>
		</table><br/>';
		
			
		
			$body.='
			<div class="col-sm-12">
			'.($userOrder->factureId > 0 ?  '
			<a class="btn btn-success" href="'.GSMS::$class['template']->info['user_url'].'accounting/viewFacture/'.$userOrder->factureId.'">مشاهده صورحساب مالی  </a>'
			:
			
			'<a class="btn btn-success" href="'.GSMS::$class['template']->info['user_url'].'orders/reviewOrder/'.$userOrder->id.'">تکمیل ثبت سفارش  </a>'
			).
			'<a class="btn" href="javascript:window.history.back()">برگشت</a>
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
		
		</script>";
		
		$body .= '</div>';
		$inf = array('title' =>  'مشاهده مشخصات سفارش', 'body' => $body);
		GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}