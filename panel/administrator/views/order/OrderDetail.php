<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class OrderDetail
{
	function OrderDetail($temp)
	{
	
        //---------------initializing-----------
		$inf = array('page_title' => 'اطلاعات سفارش');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'panel_header');
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
		
		$userOrder=$temp['userOrder'];
		$orderType = $temp['orderType'];
		$orderTitle= $temp['orderTitle'];
		
		$services= $temp['services'];
		$userContent=$temp['userContent'];
		
		
		
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
		$servicesid='';
		GSMS::$class['session']->set('userOrderPrice',$totalCost);

		$body .= '        
		<br/>
        ';
		
		
		$body .= '
		<br/>
		<div class="message-info" style="text-shadow: 0px 0px 1px #96ECFF;    color: #0F6D73;">
		<table class="table table-striped table-bordered  " dir="rtl">
		<thead>
			<tr>
				<th style="text-align: right;">مشاهده اطلاعات سفارش شما</th>
			</tr>
		</thead>
		<tbody>
		
			<tr id="tr_even">
				<td> 
					<table >
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
							<td>'.$userOrder->admin_name.'</td>
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
							if($userOrder->typeId ==1|| $userOrder->typeId ==2)
							{
								$color=array(1=>'یک رو',2=>'دو رو'); 
							}
							else //if($userOrder->typeId ==4)
							{
								$color=array(1=>'تک رنگ',2=>'دو رنگ',3=>'سه رنگ',4=>'چهار رنگ',5=>'پنج رنگ',6=>'شش رنگ',7=>'سایر'); 
							}
							
							
							if($userOrder->typeId ==3)
							{
								$paper=array(
									1 	=>'تحریر 70 گرمی',
									2 	=>'تحریر 80 گرمی',
									3 	=>'تحریر 100 گرمی',
									4 	=>'تحریر 120 گرمی',
									5 	=>'تحریر 140 گرمی',
									6 	=>'مقوای کارتنی 160 گرمی ',
									7 	=>'مقوای کارتنی 200 گرمی ',
									8 	=>'مقوای کارتنی 230 گرمی ',
									9 	=>'مقوای کارتنی 300 گرمی ',
									10	=>'گلاسه براق  90 گرمی ',
									11	=>'گلاسه براق  100 گرمی',
									12	=>'گلاسه براق  115 گرمی',
									13	=>'گلاسه براق  120 گرمی',
									14	=>'گلاسه براق  135 گرمی',
									15	=>'گلاسه براق  150 گرمی',
									16	=>'گلاسه براق  170 گرمی',
									17	=>'گلاسه براق  200 گرمی',
									18	=>'گلاسه براق  250 گرمی',
									19	=>'گلاسه براق  300 گرمی',
									20	=>'گلاسه مات  90 گرمی ',
									21	=>'گلاسه مات  100 گرمی',
									22	=>'گلاسه مات  115 گرمی',
									23	=>'گلاسه مات  135 گرمی',
									24	=>'گلاسه مات  150 گرمی',
									25	=>'گلاسه مات  170 گرمی',
									26	=>'گلاسه مات  200 گرمی',
									27	=>'گلاسه مات  300 گرمی',
									28	=>'مقوای پشت طوسی 230 گرمی',
									29	=>'مقوای پشت طوسی 280 گرمی',
									30	=>'مقوای پشت طوسی 300 گرمی',
									31	=>'مقوای پشت طوسی 350 گرمی',			
									32	=>'مقوای پشت سفید 250 گرمی',
									33	=>'مقوای پشت سفید 280 گرمی',
									34	=>'مقوای پشت سفید 300 گرمی',			
									35	=>'مقوای اینورد بورد 250 گرمی',
									36	=>'مقوای اینورد بورد 270 گرمی',
									37	=>'مقوای اینورد بورد 300 گرمی',
									38	=>'مقوای اینورد بورد 350 گرمی');
							}
							else
							{
								$paper=array(1=>'کاهی',2=>'تحریر',3=>'گلاسه',4=>'لیبل',5=>'پشت جسب دار',6=>'سایر'); 
							
							}
							
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
							. 
							($userOrder->typeId ==4 ?	//lable
							'<tr>
								<td>فاصله بین دو طرح</td>
								<td>'.$userOrder->label_distance.' میلیمتر</td>
							</tr>
							<tr>
								<td>نوع چاپ</td>
								<td>'.$color2[intval($userOrder->paperType)].' </td> 
							</tr>
							<tr>
								<td>تعداد تحویلی</td>
								<td>'. intval($userOrder->delivery_count).' </td>
							</tr>   
							<tr>
								<td>عرض تحویلی</td>
								<td>'. intval($userOrder->delivery_width).' </td>
							</tr>
							<tr>
								<td>وزن تحویلی</td>
								<td>'. intval($userOrder->delivery_weight).' کیلوگرم</td>
							</tr>
							<tr>
								<td>فایل نمونه شاهد</td>
								<td><img width="150" height="150" src="'.
								   (intval($userOrder->shahed_pic_id)>0 ? 
											GSMS::$class['template']->info['index_url'].'iconView/'. $userOrder->shahed_pic_id			
										:  	GSMS::$siteURL. GSMS::$outputDir .'views/images/404.png')
								   .'" /> </td>
							</tr>
							
				 
							':'')							
							.'
							<tr>
								<td>'.($userOrder->typeId !=4 ? 'نوع کاغذ' : 'نوع متریال').'</td>
								<td>'.($userOrder->typeId !=4 ?$paper[intval($userOrder->paperType)]:$userOrder->label_material).'</td>
							</tr>
							<tr>
								<td>تعداد رنگ</td>
								<td>';
							if ($userOrder->typeId !=4)
							{
								$body .=$color[intval($userOrder->colorCount)].'</td></tr>';
							}
							else
							{
								$body .=$color[intval($userOrder->colorCount)].'</td></tr>';
								
								for($i=1;$i<=intval($userOrder->colorCount);$i++)
								{
									switch ($i)
									{
										case 1:
											$body .='<tr><td>رنگ 1</td><td>' . $userOrder->color1 . '</td></tr>';
											break;
											
										case 2:
											$body .='<tr><td>رنگ 2</td><td>' . $userOrder->color2 . '</td></tr>';
											break;
											
										case 3:
											$body .='<tr><td>رنگ 3</td><td>' . $userOrder->color3 . '</td></tr>';
											break;
											
										case 4:
											$body .='<tr><td>رنگ 4</td><td>' . $userOrder->color4 . '</td></tr>';
											break;
											
										case 5:
											$body .='<tr><td>رنگ 5</td><td>' . $userOrder->color5 . '</td></tr>';
											break;
											
										case 6:
											$body .='<tr><td>رنگ 6</td><td>' . $userOrder->color6 . '</td></tr>';
											break;
											
									}
									
								}
							}
								
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
						
						$body.=
						'<tr>
							<td>تیراژ / تعداد سفارش</td>
							<td>'.$userOrder->count.'</td>
						</tr>
						<tr>
							<td>مشخصات</td>
							<td>'. str_replace("\n",'<br>',$userOrder->description).'</td>
						</tr>
						
					</table> 
				</td>
				<td style="text-align: left;">
				 <img width="150" height="150" src="'.
			(intval($userOrder->order_file_id)>0 ? 
				GSMS::$class['template']->info['index_url'].'iconView/'. $userOrder->order_file_id			
			:  	GSMS::$siteURL. GSMS::$outputDir .'views/images/buy.png')
	   .'" /> 
					<h3></h3>
				</td>
			</tr>
		</tbody>
		</table><br/>';
			if($userOrder->typeId>0)
			{
					
				if(is_array($userContent))
				{
					$body .='
					<table id="selectedServiceTable" class="table table-hover table-striped table-bordered " 
					cellspacing="0" style="border-collapse:collapse;" dir="rtl">
						<tr>
						<td>نوع سرویس</td>
						<td>نام سرویس</td>
						<td>تعداد</td>
						<td>قیمت پایه</td>
						</tr>';	
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
						$body.='<div class="alret alert-info">بدون سرویس اضافی</div>';
					}
					
				
			}
			$body.='
			 
			 
			<br/>
			<a class="btn btn-primary " href="'.
				GSMS::$class['template']->info['admin_url'].'orders/viewHistory/'.$userOrder->id.'">مشاهده سوابق </a>
				<br/>
			<br/><a class="btn" href="javascript:window.history.back()">برگشت</a>		
		';
		
		$body .= '</div>';
		$inf = array('title' =>  'مشاهده مشخصات سفارش', 'body' => $body);
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
		
		 
        
    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}