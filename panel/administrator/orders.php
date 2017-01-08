<?php //allahoma sale ala mohammad va ale mohammad
//class contain all admin function on view layer start 4-2-91 by nasser niazy in gooya smslearning system
class orders
{
    private $user;

    public function __construct()
    {    
		if (GSMS::$class['session']->checkLogin() == false)
            GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
        GSMS::load('template', 'lib');
        GSMS::$class['system_log']->log('DEBUG', 'admin class started successfull');  
    }

    public function index()
    {
		GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
    }
	
	public function registerOrder($order_id=0)
	{
		if (isset($_POST['submit'])) 
		{
			GSMS::load('userOrder', 'class');			 
			
			$tempOrder=new userOrder();
			$tempOrder->name= GSMS::$class['input']->post('orderTitle');
			
			$tempOrder->statusId=1;
			$tempOrder->save();
			
			$picId= 0;
			 
			if (isset($_FILES)) 
			{
				$fileName = $_FILES['orderFile']['name'];
				if (!file_exists(GSMS::$tempDir . $fileName)) 
				{
					if (move_uploaded_file($_FILES['orderFile']['tmp_name'], GSMS::$tempDir . $fileName)) 
					{
						GSMS::load("calendar", "lib");
						GSMS::load("filesystem", "lib");
						
						$path = GSMS::$config['photo_archive_path']. DIRECTORY_SEPARATOR;
						
						$user=GSMS::$class['session']->getUser();
						
						$path .= $user['UserName'] . DIRECTORY_SEPARATOR;
						$pathDB  = $user['UserName'] . DIRECTORY_SEPARATOR;
						
						if (!file_exists($path))
							mkdir($path, 0755);	
						
						$path .= 'orders' . DIRECTORY_SEPARATOR;
						$pathDB  .= 'orders'  . DIRECTORY_SEPARATOR;
						
						if (!file_exists($path))
							mkdir($path, 0755);
						
						$path .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
						$pathDB .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
						
						if (!file_exists($path))
							mkdir($path, 0755);
							
					    
						$new_fileName = GSMS::$class['filesystem']->sanitize($fileName,true);
					
						$new_path = $new_fileName;
						while(file_exists( $path .$new_path))
						{
							$new_path = rand() . $new_fileName ; 
						}
						
						$tempPicture =R::dispense('picture');
						$tempPicture->title = 'فايل مربوط يه سفارش :'.GSMS::$class['input']->post('orderTitle');
						$tempPicture->description = 'فايل مربوط يه سفارش :'.GSMS::$class['input']->post('orderTitle');
						$tempPicture->picturePath = $pathDB . $new_path ;
						$tempPicture->createDate = GSMS::$class['calendar']->now();
						$tempPicture->userId = $user['UserID'];
						$tempPicture->itemId =$tempOrder->id;
						$tempPicture->itemType = 'orderFile';
						$picId = R::store($tempPicture );
						
						rename(GSMS::$tempDir . $fileName,$path .$new_path );
					}
				
				}		

			}
			 
			$tempOrder->ownerMobile= GSMS::$class['input']->post('mobile');
			$tempOrder->admin_name= GSMS::$class['input']->post('adminName');
			$tempOrder->isVip=( GSMS::$class['input']->post('isVip')=='on'? 1:0);
			$tempOrder->order_file_id=$picId;
			$tempOrder->save();
			
			if(intval(GSMS::$class['input']->post('autoConfig')) ==0)
			{
				$tempOrder->titleId= 0;
				$tempOrder->typeId= intval(GSMS::$class['input']->post('orderType'));
			
				$tempOrder->save();
				
				if($tempOrder->typeId == 1 )
				{
					GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/litoRegister/'.$tempOrder->id);
				}
				elseif($tempOrder->typeId == 2 )
				{ 
					GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/rolRegister/'.$tempOrder->id);
				}
				elseif($tempOrder->typeId == 3 )
				{ 
					GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/shitRegister/'.$tempOrder->id);
				}
				elseif($tempOrder->typeId == 4 )
				{ 
					GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/labelRegister/'.$tempOrder->id);
				}	
				return;				
			}
			else//if($tempOrder->titleId >0 ) 
			{
				
				$tempOrder->typeId= 0;
				$tempOrder->titleId= intval(GSMS::$class['input']->post('formTitle'));
			
				$tempOrder->save();
				
				GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/paternRegister/'.$tempOrder->id);
				
				return;
			}
			 
		}
		 
		$orderType=R::getAll('select * from order_type;');
		$inf['orderType']=$orderType;
		$orderTitles=R::getAll('select * from order_title;');
		$inf['orderTitles']=$orderTitles;
		GSMS::load('register', 'user_view', 'order', $inf);
		 
		
	}
	
	public function litoRegister($id)
	{
		GSMS::load('userOrder', 'class');
		
		$userOrder = new userOrder();
		$userOrder->getUserOrder($id) ;
		
		if (isset($_POST['submit'])) 
		{	
			R::exec('delete from `ordercontent` where `order_id`='.$userOrder->id);
			$orderContent=GSMS::$class['input']->post('inSerives');
			 
			if(is_array($orderContent))
			{
				foreach($orderContent as $value) 
				{
					$tempVal = explode(',', $value);
					$temServicId=$tempVal[0];
					$temServicCount=$tempVal[1];
					$orderService=R::getAll('select * from service where id='.$temServicId);
					$serPrice=$orderService[0]['price'];
					$tempContent=R::dispense('ordercontent');
					$tempContent->orderId=$userOrder->id;
					$tempContent->serviceId=$temServicId;
					$tempContent->count=$temServicCount;
					$tempContent->price=$serPrice;
					R::store( $tempContent);
				}
			}
			$userOrder->orderHeight=GSMS::$class['input']->post('orderHeight');
			$userOrder->orderWeidth=GSMS::$class['input']->post('orderWeidth');
			$userOrder->colorCount=GSMS::$class['input']->post('colorCount');
			$userOrder->paperType=GSMS::$class['input']->post('paperType');
			$userOrder->printCount=GSMS::$class['input']->post('printCount');
			$userOrder->count=GSMS::$class['input']->post('orderCount');
			$userOrder->description=GSMS::$class['input']->post('description');
			$userOrder->save();
			GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/reviewOrder/'.$userOrder->id);
		}
		else 
		{
			
			GSMS::$class['session']->set('userOrderId',$tempOrder->id);
			
			$inf['userOrder']=$tempOrder;
			 
			$servicesTypes=R::getAll('select * from servicetype where part = \'lito\'');
			$inf['servicesTypes']=$servicesTypes;
			$services=R::getAll('select * from service;');
			
			$inf['services']=$services;
			GSMS::load( 'litoRegister','user_view','order',$inf);
		}
	}
	
	public function rolRegister($id)
	{
		GSMS::load('userOrder', 'class');
		
		$userOrder = new userOrder();
		$userOrder->getUserOrder($id) ;
		
		if (isset($_POST['submit'])) 
		{	
			R::exec('delete from `ordercontent` where `order_id`='.$userOrder->id);
			$orderContent=GSMS::$class['input']->post('inSerives');
			 
			if(is_array($orderContent))
			{
				foreach($orderContent as $value) 
				{
					$tempVal = explode(',', $value);
					$temServicId=$tempVal[0];
					$temServicCount=$tempVal[1];
					$orderService=R::getAll('select * from service where id='.$temServicId);
					$serPrice=$orderService[0]['price'];
					$tempContent=R::dispense('ordercontent');
					$tempContent->orderId=$userOrder->id;
					$tempContent->serviceId=$temServicId;
					$tempContent->count=$temServicCount;
					$tempContent->price=$serPrice;
					R::store( $tempContent);
				}
			}
			$userOrder->orderHeight=GSMS::$class['input']->post('orderHeight');
			$userOrder->orderWeidth=GSMS::$class['input']->post('orderWeidth');
			$userOrder->colorCount=GSMS::$class['input']->post('colorCount');
			$userOrder->paperType=GSMS::$class['input']->post('paperType');
			$userOrder->printCount=0;
			$userOrder->count=GSMS::$class['input']->post('orderCount');
			$userOrder->description=GSMS::$class['input']->post('description');
			$userOrder->save();
			GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/reviewOrder/'.$userOrder->id);
		}
		else 
		{
			
			GSMS::$class['session']->set('userOrderId',$tempOrder->id);
			
			$inf['userOrder']=$tempOrder;
			 
			$servicesTypes=R::getAll('select * from servicetype where part = \'rol\' or part = \'lito\'');
			$inf['servicesTypes']=$servicesTypes;
			$services=R::getAll('select * from service;');
			
			$inf['services']=$services;
			GSMS::load( 'rolRegister','user_view','order',$inf);
		}
	
		 
	}
	
	public function shitRegister($id)
	{
		GSMS::load('userOrder', 'class');
		
		$userOrder = new userOrder();
		$userOrder->getUserOrder($id) ;
		
		if (isset($_POST['submit'])) 
		{	
			R::exec('delete from `ordercontent` where `order_id`='.$userOrder->id);
			$orderContent=GSMS::$class['input']->post('inSerives');
			 
			if(is_array($orderContent))
			{
				foreach($orderContent as $value) 
				{
					$tempVal = explode(',', $value);
					$temServicId=$tempVal[0];
					$temServicCount=$tempVal[1];
					$orderService=R::getAll('select * from service where id='.$temServicId);
					$serPrice=$orderService[0]['price'];
					$tempContent=R::dispense('ordercontent');
					$tempContent->orderId=$userOrder->id;
					$tempContent->serviceId=$temServicId;
					$tempContent->count=$temServicCount;
					$tempContent->price=$serPrice;
					R::store( $tempContent);
				}
			}
			$servicesComp="";
			if (isset($_POST['check_list']) && !empty($_POST['check_list'])) 
			{
				$servicesComp=$_POST['check_list']; 
			}
			
			$tempQuery='';
			if(is_array($servicesComp))
			{
				foreach($servicesComp as $value) 
				{
					$tempQuery.=$value.',';
				}
				$tempQuery=rtrim($tempQuery, ",");
			}		
			$userOrder->serviceId=$tempQuery;
			$userOrder->colorCount=GSMS::$class['input']->post('colorCount');
			$userOrder->paperType=GSMS::$class['input']->post('paperType');
			$userOrder->printCount=0;
			$userOrder->count=GSMS::$class['input']->post('orderCount');
			$userOrder->description=GSMS::$class['input']->post('description');
			$userOrder->save();
			GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/reviewOrder/'.$userOrder->id);
		}
		else 
		{
			
			GSMS::$class['session']->set('userOrderId',$tempOrder->id);
			
			$inf['userOrder']=$tempOrder;
			
			$orderServices=R::getAll('select * from order_service  where part = \'shit\'');
			$inf['orderServices']=$orderServices; 
			$servicesTypes=R::getAll('select * from servicetype where part = \'shit\'');
			$inf['servicesTypes']=$servicesTypes;
			$services=R::getAll('select * from service;');
			
			$inf['services']=$services;
			GSMS::load( 'shitRegister','user_view','order',$inf);
		}
	
		
	}
	
	public function labelRegister($id)
	{
		GSMS::load('userOrder', 'class');
		
		$userOrder = new userOrder();
		$userOrder->getUserOrder($id) ;
		
		if (isset($_POST['submit'])) 
		{	
			R::exec('delete from `ordercontent` where `order_id`='.$userOrder->id);
			$orderContent=GSMS::$class['input']->post('inSerives');
			 
			if(is_array($orderContent))
			{
				foreach($orderContent as $value) 
				{
					$tempVal = explode(',', $value);
					$temServicId=$tempVal[0];
					$temServicCount=$tempVal[1];
					$orderService=R::getAll('select * from service where id='.$temServicId);
					$serPrice=$orderService[0]['price'];
					$tempContent=R::dispense('ordercontent');
					$tempContent->orderId=$userOrder->id;
					$tempContent->serviceId=$temServicId;
					$tempContent->count=$temServicCount;
					$tempContent->price=$serPrice;
					R::store( $tempContent);
				}
			}
			$servicesComp="";
			if (isset($_POST['check_list']) && !empty($_POST['check_list'])) 
			{
				$servicesComp=$_POST['check_list']; 
			}
			
			$tempQuery='';
			if(is_array($servicesComp))
			{
				foreach($servicesComp as $value) 
				{
					$tempQuery.=$value.',';
				}
				$tempQuery=rtrim($tempQuery, ",");
			}		
			
			$picId= 0;
			 var_dump($_FILES);
			if (isset($_FILES)) 
			{
				$fileName = $_FILES['orderFile']['name'];
				if (!file_exists(GSMS::$tempDir . $fileName)) 
				{
					if (move_uploaded_file($_FILES['orderFile']['tmp_name'], GSMS::$tempDir . $fileName)) 
					{
						GSMS::load("calendar", "lib");
						GSMS::load("filesystem", "lib");
						
						$path = GSMS::$config['photo_archive_path']. DIRECTORY_SEPARATOR;
						
						$user=GSMS::$class['session']->getUser();
						
						$path .= $user['UserName'] . DIRECTORY_SEPARATOR;
						$pathDB  = $user['UserName'] . DIRECTORY_SEPARATOR;
						
						if (!file_exists($path))
							mkdir($path, 0755);	
						
						$path .= 'orders' . DIRECTORY_SEPARATOR;
						$pathDB  .= 'orders'  . DIRECTORY_SEPARATOR;
						
						if (!file_exists($path))
							mkdir($path, 0755);
						
						$path .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
						$pathDB .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
						
						if (!file_exists($path))
							mkdir($path, 0755);
							
					    
						$new_fileName = GSMS::$class['filesystem']->sanitize($fileName,true);
					
						$new_path = $new_fileName;
						while(file_exists( $path .$new_path))
						{
							$new_path = rand() . $new_fileName ; 
						}
						
						$tempPicture =R::dispense('picture');
						$tempPicture->title = 'فايل مربوط يه سفارش :'.GSMS::$class['input']->post('orderTitle');
						$tempPicture->description = 'فايل مربوط يه سفارش :'.GSMS::$class['input']->post('orderTitle');
						$tempPicture->picturePath = $pathDB . $new_path ;
						$tempPicture->createDate = GSMS::$class['calendar']->now();
						$tempPicture->userId = $user['UserID'];
						$tempPicture->itemId =$userOrder->id;
						$tempPicture->itemType = 'shahedFile';
						$picId = R::store($tempPicture );
						
						rename(GSMS::$tempDir . $fileName,$path .$new_path );
					}
				
				}		

			}
			 
			$userOrder->serviceId=$tempQuery;
			$userOrder->shahed_pic_id=$picId;
			$userOrder->orderHeight=GSMS::$class['input']->post('orderHeight');
			$userOrder->orderWeidth=GSMS::$class['input']->post('orderWeidth');
			$userOrder->label_distance=GSMS::$class['input']->post('orderDistance');
			$userOrder->label_material=GSMS::$class['input']->post('orderMaterial');
			$userOrder->colorCount=GSMS::$class['input']->post('colorCount');
			$userOrder->color1=GSMS::$class['input']->post('color1');
			$userOrder->color2=GSMS::$class['input']->post('color2');
			$userOrder->color3=GSMS::$class['input']->post('color3');
			$userOrder->color4=GSMS::$class['input']->post('color4');
			$userOrder->color5=GSMS::$class['input']->post('color5');
			$userOrder->color6=GSMS::$class['input']->post('color6');
			$userOrder->delivery_count=GSMS::$class['input']->post('deliveryCount');
			$userOrder->delivery_width=GSMS::$class['input']->post('deliveryWidth');
			$userOrder->delivery_weight=GSMS::$class['input']->post('deliveryWeight');
			$userOrder->paperType=GSMS::$class['input']->post('paperType');
			$userOrder->printCount=0;
			$userOrder->count=GSMS::$class['input']->post('orderCount');
			$userOrder->description=GSMS::$class['input']->post('description');
			$userOrder->save();
			GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/reviewOrder/'.$userOrder->id);
		}
		else 
		{
			
			GSMS::$class['session']->set('userOrderId',$tempOrder->id);
			
			$inf['userOrder']=$tempOrder;
			
			$orderServices=R::getAll('select * from order_service  where part = \'lable\'');
			$inf['orderServices']=$orderServices; 
			
			$servicesTypes=R::getAll('select * from servicetype where part = \'shit\'');
			$inf['servicesTypes']=$servicesTypes;
			$services=R::getAll('select * from service;');
			
			$inf['services']=$services;
			GSMS::load( 'labelRegister','user_view','order',$inf);
		}
	}
	
	public function paternRegister($id)
	{
		GSMS::load('userOrder', 'class');
		
		$userOrder = new userOrder();
		$userOrder=$userOrder->getUserOrder($id) ;
		
		if (isset($_POST['submit'])) 
		{	
			
			$userOrder->count=GSMS::$class['input']->post('orderCount');
			$userOrder->description=GSMS::$class['input']->post('description');
			$userOrder->save();
			GSMS::$class['router']->redirect(
									GSMS::$class['template']->info['user_url']. 'orders/reviewOrder/'.$userOrder->id);
		}
		else 
		{
			GSMS::$class['session']->set('userOrderId',$tempOrder->id);
			
			$inf['userOrder']=$tempOrder;
			GSMS::load( 'paternRegister','user_view','order',$inf);
		}
	}
		 
   
    public function reviewOrder($id)
	{
		 
		if($id>0)
		{
			GSMS::load('userOrder', 'class');
			$userOrder = new userOrder();
			$userOrder->getUserOrder($id) ;
			
			$orderType=R::getAll('select * from order_type where id='.$userOrder->typeId);
			$orderTitle=R::getAll('select * from order_title where id='.$userOrder->titleId);
 
			$temp['orderType']=$orderType[0]['title'];
			$temp['orderTitle']=$orderTitle[0]['title'];
			$temp['userOrder']=$userOrder;
			$tempStr=trim($userOrder->serviceId);
			$tempArray='';
			if(!empty($tempStr))
			{ 
				$tempArray=explode(',', $userOrder->serviceId);
			}
			$compServices=''; 
			$tempQuery='(';
			if(is_array($tempArray))
			{
				foreach($tempArray as $value) 
				{
					$tempQuery.=$value.',';
				}
				$tempQuery=rtrim($tempQuery, ",");
				$tempQuery.=')';
				$compServices=R::getAll('select * from order_service where id in '.$tempQuery);
 
			}
			$temp['services']=$compServices;
			$userContent='';
			$userContentTemp=R::getAll('select * from ordercontent where order_id='.$userOrder->id);
 
			if(count($userContentTemp)>0)
			{
				$i=0;
				$services=R::getAll('select * from service');
				$servicesTypes=R::getAll('select * from servicetype');
 
				foreach($userContentTemp as $value) {
					$userContent[$i]['count']=$value['count'];
					$userContent[$i]['price']=$value['price'];
					foreach($services as $serValue) {
						if($serValue['id']==$value['service_id']){
							$userContent[$i]['service']=$serValue['title'];
							foreach($servicesTypes as $typeValue) {
								if($typeValue['id']==$serValue['type_id']){
									$userContent[$i]['type']=$typeValue['title'];
									break;
								}
							}
							break;
						}
					}
					$i++;
				}
 
				
			}
			$temp['userContent']=$userContent;
			
			
			GSMS::load('review', 'user_view', 'order',$temp);
		}
    }
    
	public function cancelPayment($id)
	{
		GSMS::load('userOrder', 'class');
		$userOrder = new userOrder();
		$userOrder->getUserOrder($id) ;
		$userOrder->isCanceled=1 ;
		$userOrder->save() ;
		
		GSMS::$class['template']->message('لغو سفارش','با انصراف شما از ادامه مراحل سفارش لغو شد . ','user' ,'label-warning');
	}
    
	public function finishPayment($id)
	{
		GSMS::load('userOrder', 'class');
		$userOrder = new userOrder();
		$userOrder->getUserOrder($id) ;
		$userOrder->isPaid=2 ;
		$userOrder->save() ;
		
		GSMS::$class['template']->message('ثبت سفارش','سفارش بدون پرداخت مبلغي ثبت شد','user');
	}
	
    public function selectPayment($id,$mod=0)
	{		
		$userOrderId =$id;// GSMS::$class['session']->get('userOrderId');
		GSMS::load('userOrder', 'class');
		$userOrder = new userOrder();
		$userOrder->getUserOrder($id) ;
		
		if(isset($_POST['submit']))
		{
			$userOrderPrice = GSMS::$class['session']->get('userOrderPrice');			
			
			$paymentType=GSMS::$class['input']->post('paymentType');
			switch (intval($paymentType)) 
			{
				case 1:
					GSMS::$class['router']->redirect(
								GSMS::$class['template']->info['user_url']
								. 'accounting/insertOnMoney/'.$userOrderPrice 
								. '/' . $userOrderId );
					break;
				case 2:
					
					GSMS::$class['router']->redirect(
								GSMS::$class['template']->info['user_url'] 
								. 'accounting/insertReceipt/2/'.$userOrderPrice
								. '/' . $userOrderId);
		
					break;
				case 3:
					GSMS::$class['router']->redirect(
								GSMS::$class['template']->info['user_url'] 
								. 'accounting/insertReceipt/3/'.$userOrderPrice
								. '/' . $userOrderId);
					break;
			} 
			return ;
		}
		elseif(intval($mod)>0)
		{
			if($mod == 1) //finish
			{
				$userOrder->isPaid=0 ;
				$userOrder->save() ;
				
			}
			elseif($mod ==2)//cancel
			{
				$userOrder->isCanceled=1;
				$userOrder->save() ;
			}
		}
		
		GSMS::load('selectPayment', 'user_view', 'order',$userOrder);
		
    }
    
    public function selectPayment2()
	{
		if(isset($_POST['paymentType'])){
			$paymentType=GSMS::$class['input']->post('paymentType');
			switch ($paymentType) {
				case 1:
					$this->onlinePayment();
					break;
				case 2:
					$this->insertReceiptPayment();
					break;
				case 3:
					$this->insertCardPayment();
					break;
			} 
			return ;
		}
    
		if(!isset($_POST['orderType']))
		{
			$this->index();
			return;
		}
		$orderDesc=GSMS::$class['input']->post('description');
		GSMS::load('userOrder', 'class');
		$tempOrder=new userOrder();
		$orderType=GSMS::$class['input']->post('orderType');
		$orderType=intval($orderType);
		$orderTitle=GSMS::$class['input']->post('orderTitle');
		$orderTitle=intval($orderTitle);
		$orderSize=GSMS::$class['input']->post('orderSize');
		$orderSize=intval($orderSize);
		$orderSendType=GSMS::$class['input']->post('orderSendType');
		$orderSendType=intval($orderSendType);
		$orderCount=GSMS::$class['input']->post('orderCount');
		$printCost=GSMS::$class['input']->post('printCost');
		$servicesCost=GSMS::$class['input']->post('servicesCost');
		$orderMobile=GSMS::$class['input']->post('orderMobile'); 
		$servicesId=GSMS::$class['input']->post('serviceId');
		$description=GSMS::$class['input']->post('description');
		$tempOrder->titleId=$orderTitle;
		$tempOrder->printPrice=$printCost;
		$tempOrder->servicePrice=$servicesCost;
		$tempOrder->typeId=$orderType;
		$tempOrder->sizeId=$orderSize;
		$tempOrder->sendTypeId=$orderSendType;
		$tempOrder->createDate =GSMS::$class['calendar']->date('Y-m-d');
		$tempOrder->ownerMobile="$orderMobile";
		$tempOrder->count=$orderCount;
		$tempOrder->serviceId=$servicesId;
		$tempOrder->description=$description;
// 		var_dump($tempOrder);
		$tempOrder->save();
		GSMS::$class['session']->set('userOrderId',"$tempOrder->id");
// 		$val=GSMS::$class['session']->get('key');
		GSMS::load('selectPayment', 'user_view', 'order',null);
		
    }
    
    public function onlinePayment()
	{
		 GSMS::$class['router']->redirect(GSMS::$class['template']->info['user_url'] . 'accounting/insertOnMoney/1');
		
    }
        
    public function insertCardPayment()
	{
		echo "we are in insertCardPayment";
    }
    
    public function currentOrders()
	{
		GSMS::load('userOrder', 'class');
		$tempOrder = new userOrder();
		$res = $tempOrder->getRunningOrders();
		
		
		
		$orderTypeArray=R::getAll('select * from order_type');
		$orderTitleArray=R::getAll('select * from order_title');
// 		$orderSizeArray=R::getAll('select * from order_size');
		$orderStatusArray=R::getAll('select * from order_status');
		
		$temp=array(
			"res" => $res,
			"type" => 1,
			"orderTypeArray" => $orderTypeArray,
			"orderTitleArray" => $orderTitleArray,
			"orderStatusArray" => $orderStatusArray
			);
		
		GSMS::load('current', 'user_view', 'order', $temp);
// 		var_dump($res);
// 		echo json_encode($res);
// 		echo "orders";
		
	}
    
    public function viewOrderDetail($id)
	{
		if($id>0)
		{
			GSMS::load('userOrder', 'class');
			$userOrder = new userOrder();
			$userOrder->getUserOrder($id) ;
			
			$orderType=R::getAll('select * from order_type where id='.$userOrder->typeId);
			$orderTitle=R::getAll('select * from order_title where id='.$userOrder->titleId);
 
			$temp['orderType']=$orderType[0]['title'];
			$temp['orderTitle']=$orderTitle[0]['title'];
			$temp['userOrder']=$userOrder;
			$tempStr=trim($userOrder->serviceId);
			$tempArray='';
			if(!empty($tempStr))
			{ 
				$tempArray=explode(',', $userOrder->serviceId);
			}
			$compServices=''; 
			$tempQuery='(';
			if(is_array($tempArray))
			{
				foreach($tempArray as $value) 
				{
					$tempQuery.=$value.',';
				}
				$tempQuery=rtrim($tempQuery, ",");
				$tempQuery.=')';
				$compServices=R::getAll('select * from order_service where id in '.$tempQuery);
 
			}
			$temp['services']=$compServices;
			$userContent='';
			$userContentTemp=R::getAll('select * from ordercontent where order_id='.$userOrder->id);
 
			if(count($userContentTemp)>0)
			{
				$i=0;
				$services=R::getAll('select * from service');
				$servicesTypes=R::getAll('select * from servicetype');
 
				foreach($userContentTemp as $value) 
				{
					$userContent[$i]['count']=$value['count'];
					$userContent[$i]['price']=$value['price'];
					foreach($services as $serValue) {
						if($serValue['id']==$value['service_id']){
							$userContent[$i]['service']=$serValue['title'];
							foreach($servicesTypes as $typeValue) {
								if($typeValue['id']==$serValue['type_id']){
									$userContent[$i]['type']=$typeValue['title'];
									break;
								}
							}
							break;
						}
					}
					$i++;
				}
 
				
			}
			$temp['userContent']=$userContent;
		
			GSMS::load('OrderDetail', 'user_view', 'order', $temp);
		}
		else
		{
			GSMS::$class['template']->message('خطا','سفارش پیدا نشد','user','label-warning');
		}

    }
    
    public function prevOrders($begin=0 , $end = 30 )
	{
		GSMS::load('userOrder', 'class');
		$tempOrder = new userOrder();
		$res = $tempOrder->getPrevOrders();
		$orderTypeArray=R::getAll('select * from order_type');
		$orderTitleArray=R::getAll('select * from order_title');
// 		$orderSizeArray=R::getAll('select * from order_size');
		$orderStatusArray=R::getAll('select * from order_status');
		
		$temp=array(
			"res" => $res,
			"type" => 1,
			"orderTypeArray" => $orderTypeArray,
			"orderTitleArray" => $orderTitleArray,
			"orderStatusArray" => $orderStatusArray
			);
		
		GSMS::load('current', 'user_view', 'order', $temp);
		
	}
    
    public function queueOrders($begin=0 , $end = 30)
	{
		GSMS::load('userOrder', 'class');
		$tempOrder = new userOrder();
		$res = $tempOrder->getQueueOrders();
		$orderTypeArray=R::getAll('select * from order_type');
		$orderTitleArray=R::getAll('select * from order_title');
// 		$orderSizeArray=R::getAll('select * from order_size');
		$orderStatusArray=R::getAll('select * from order_status');
		
		$temp=array(
			"res" => $res,
			"type" => 1,
			"orderTypeArray" => $orderTypeArray,
			"orderTitleArray" => $orderTitleArray,
			"orderStatusArray" => $orderStatusArray
			);
		
		GSMS::load('current', 'user_view', 'order', $temp);
    }
    
    public function buyOnline()
	{
		
// 		GSMS::$class['session']->set('key','val');
// 		$val=GSMS::$class['session']->get('key');
		
// 		//---------------initializing-----------
//         $inf = array('page_title' => 'اطلاعات طرح');
//         GSMS::$class['template']->header($inf);
//         $inf = array('page_title' =>'اطلاعات طرح');
//         GSMS::$class['template']->panel_header($inf);
//         //------------------------
// 		
// 		
// 		
// 		GSMS::load('plan', 'class');
// 		GSMS::load('admin', 'class');
// 		
// 		$planId = GSMS::$class['input']->post('plan_id');
// 		
// 		$telgroup_id = GSMS::$class['session']->get('plan_telgroup_id');
// 		
//         $plan =GSMS::$class['plan']->getPlan($planId);
// 		
//         $admin =GSMS::$class['admin']->getAdmin($this->user['UserID']);
// 		
// 		GSMS::load('payline', 'payment');
// 
// 		$Payline = new payline(
// 			GSMS::$config['payment_payline_api_key'],
// 			'http://mamadar.ir/index.php/user/buyFinish',
// 			GSMS::$class['DB']->mysqli_conection
// 		);
// 
// 		$Payline->conn = GSMS::$class['DB']->mysqli_conection;
// 
// 		
// 		$msg = $Payline->payRequest(
// 			$admin->name,
// 			$admin->mobile,
// 			'خريد طرح آنلاين توسط کاربر ' .$admin->id,//comment
// 			$admin->mail,
// 			$plan->price *10 ,// convert toman to rial
// 			$admin->id,
// 			$planId,
// 			$telgroup_id
// 		);
// 		
// 		$message = '<div class="alert alert-info">' . $msg . '</div>';
// 		$inf = array('title' => 'پرداخت آنلاين', 'body' =>$message );
//         GSMS::$class['template']->index($inf);
//         GSMS::$class['template']->footer($inf);
	}
	
	public function currentRegister($id=0,$begin=0 , $end = 30 )
	{
		
		GSMS::load('admin', 'class');
		
		$inf['admin'] =GSMS::$class['admin']->getAdmin($id ); 
		
		$inf['balance'] =R::getAll('select * from balance  '.($id>0 ? ' where `admin_id`= '. $id : '' )  
					. ' limit ' .$begin . ','  . $end );
					
		$inf['begin'] =$begin; 
		
		$item=R::getAll('select count(id)as cnt  from balance  '.($id>0 ? ' where `admin_id`= '. $id : '' ) ); 
		$inf['count'] = $item[0]['cnt'];
        GSMS::load('listBalance', 'user_view', 'accounting', $inf);	
	}
	
	public function queueOrders2($begin=0 , $end = 30)
	{
		GSMS::load('option', 'class');
		if(isset($_POST['submit']))
		{
			list($ads_value)= GSMS::$class['option']->get_optionsByKey('ads_value');
			$ads_value[0]->value=GSMS::$class['input']->post('ads_value');
			$ads_value[0]->save();
			
			list($gift_value)= GSMS::$class['option']->get_optionsByKey('gift_value');
			$gift_value[0]->value=GSMS::$class['input']->post('gift_value');
			$gift_value[0]->save();
			
			list($management_value)= GSMS::$class['option']->get_optionsByKey('management_value');
			$management_value[0]->value=GSMS::$class['input']->post('management_value');
			$management_value[0]->save();
			
			list($gift_min_value)= GSMS::$class['option']->get_optionsByKey('gift_min_value');
			$gift_min_value[0]->value=GSMS::$class['input']->post('gift_min_value');
			$gift_min_value[0]->save();
			
			$inf = array('page_title' => 'ويرايش اطلاعات ');
			GSMS::$class['template']->header($inf);
			$inf = array('page_title' =>'ويرايش اطلاعات');
			GSMS::$class['template']->panel_header($inf);
		
			
		}
		else 
		{	
			list($temp) = GSMS::$class['option']->get_optionsByKey('ads_value');
			$inf['ads_value'] =$temp[0]->value;
			list($temp) =GSMS::$class['option']->get_optionsByKey('gift_value');
			$inf['gift_value'] = $temp[0]->value;
			list($temp) =GSMS::$class['option']->get_optionsByKey('management_value');
			$inf['management_value'] = $temp[0]->value;
			list($temp) =GSMS::$class['option']->get_optionsByKey('gift_min_value');
			$inf['gift_min_value'] = $temp[0]->value;
			
			GSMS::load('config', 'user_view', 'accounting', $inf);	
			
		}
		
        
	}
	
	public function searchOrder($begin=0 , $end = 30)
	{
        GSMS::load('searchOrder', 'user_view', 'orders', $inf);	
	}
	
	public function transactions () 
	{
		GSMS::load('internetTransaction', 'class');
		$user = GSMS::$class['session']->getUser();
		
		$tempTr = GSMS::$class['internetTransaction']->listTransactionByUser($user['UserID']);
		
		GSMS::load('listTransaction', 'user_view', 'accounting', $tempTr); 
	}
	
	public function newOrders($begin=0 , $end = 30)
	{
		GSMS::load('userOrder', 'class');
		$tempOrder = new userOrder();
		$res = $tempOrder->getNewOrders(0,$begin , $end );
		
		$orderTypeArray=R::getAll('select * from order_type');
		$orderTitleArray=R::getAll('select * from order_title');
// 		$orderSizeArray=R::getAll('select * from order_size');
		$orderStatusArray=R::getAll('select * from order_status');
		
		$temp=array(
			"res" => $res,
			"type" => 4,
			"orderTypeArray" => $orderTypeArray,
			"orderTitleArray" => $orderTitleArray,
			"orderStatusArray" => $orderStatusArray
			);
		
		GSMS::load('current', 'user_view', 'order', $temp);

		
	}
    
}//class

if (!defined("GSMS")) {
    exit("Access denied");
}
?>
