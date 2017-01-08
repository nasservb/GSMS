<?php
class userOrder{
	public $name='';
	public $id=0;
	public $description='';
	public $abstractDesc='';
	public $typeId=0;
	public $titleId=0;
	public $statusId=0;
	public $serviceId=0;
	public $createDate='';
	public $expireDate='';
	public $deliverDate='';
	public $createBalanceId=0;
	public $isStarted=0; 
	public $isCompleteOrder=0;  
	public $isDelivered=0;//is delivered to costumer
	public $adminId =0;
	public $isDeleted =0;
	public $isAccepted =0;
	public $isVip =0;
	public $isPaid=0;
	public $isCanceled =0;
	public $lastUpdate ='';
	public $printPrice =0;
	public $servicePrice =0;
	public $ownerMobile ='';
	public $count  =0;
	public $paperType  =0;
	public $colorCount  =0;
	public $orderHeight  =0;
	public $orderWeidth  =0;
	
	
	public $printCount	=0;
	public $order_file_id	=0;
	public $admin_name		='';
	public $label_distance	=0;
	public $label_material	=0;
	public $color1			='';
	public $color2			='';
	public $color3			='';
	public $color4			='';
	public $color5			='';
	public $color6			='';
	public $delivery_count	=0;
	public $delivery_width	=0;
	public $delivery_weight	=0;
	public $shahed_pic_id	=0;
	
	public function __construct()
	{
		GSMS::load('log','class');	
		$user=GSMS::$class['session']->getUser();
		$this->id=0;
		$this->createDate=GSMS::$class['calendar']->now();
		$this->adminId=($user['UserID']);
		GSMS::$class['system_log']->log('DEBUG','userOrder class Initialized');
	}//fun
	
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun
	
	public function save()
	{
		
		if($this->id != 0)
		{
			
			$tempOrder= R::load('userorder',$this->id);
			//var_dump($this );
			//var_dump($tempOrder );
			//exit;
			//donot crupt when edit
			$tempOrder->description			=($this->description!='' ? $this->description: $tempOrder->description);
			$tempOrder->name				=($this->name!='' ? $this->name: $tempOrder->name);
			$tempOrder->abstractDesc		=($this->abstractDesc!='' ? $this->abstractDesc: $tempOrder->abstractDesc);
			$tempOrder->typeId				=(intval($this->typeId)>0 ? $this->typeId: $tempOrder->typeId) ; 
			$tempOrder->titleId				=(intval($this->titleId)>0 ? $this->titleId: $tempOrder->titleId) ;
			$tempOrder->statusId			=(intval($this->statusId)>0 ? $this->statusId: $tempOrder->statusId) ;
			$tempOrder->serviceId			=($this->serviceId!='' ? $this->serviceId: $tempOrder->serviceId) ;
			$tempOrder->createDate			=($this->createDate!='' ? $this->createDate: $tempOrder->createDate) ;
			$tempOrder->expireDate			=($this->expireDate!='' ? $this->expireDate: $tempOrder->expireDate) ;
			$tempOrder->deliverDate			=($this->deliverDate!='' ? $this->deliverDate: $tempOrder->deliverDate) ;
			$tempOrder->createBalanceId		=(intval($this->createBalanceId) >0  ? $this->createBalanceId: $tempOrder->createBalanceId) ;
			$tempOrder->isStarted			=(intval($this->isStarted) > 0 ? $this->isStarted :$tempOrder->isStarted);
			$tempOrder->isCompleteOrder		=(intval($this->isCompleteOrder) > 0 ? $this->isCompleteOrder : $tempOrder->isCompleteOrder );
			$tempOrder->isDelivered			=(intval($this->isDelivered) > 0 ? $this->isDelivered :$tempOrder->isDelivered);
			$tempOrder->isDeleted			=(intval($this->isDeleted) > 0 ? $this->isDeleted :$tempOrder->isDeleted);
			$tempOrder->isAccepted			=(intval($this->isAccepted)> 0 ? $this->isAccepted:$tempOrder->isAccepted);
			$tempOrder->isVip				=(intval($this->isVip)> 0 ? $this->isVip:$tempOrder->isVip);
			$tempOrder->isPaid				=(intval($this->isPaid)> 0 ? $this->isPaid:$tempOrder->isPaid);
			$tempOrder->isCanceled			=(intval($this->isCanceled) > 0 ? $this->isCanceled :$tempOrder->isCanceled);
			$tempOrder->lastUpdate			=($this->lastUpdate!='' ?$this->lastUpdate:$tempOrder->lastUpdate);
			$tempOrder->printPrice			=(intval($this->printPrice) > 0 ?$this->printPrice:$tempOrder->printPrice);
			$tempOrder->servicePrice		=(intval($this->servicePrice) > 0 ?$this->servicePrice:$tempOrder->servicePrice);
			$tempOrder->ownerMobile			=($this->ownerMobile!='' ? $this->ownerMobile:$tempOrder->ownerMobile);
			$tempOrder->count				=(intval($this->count) > 0 ?$this->count:$tempOrder->count);
			$tempOrder->paperType  			=(intval($this->paperType) > 0 ?$this->paperType:$tempOrder->paperType)  ;
			$tempOrder->colorCount 			=(intval($this->colorCount) > 0 ?$this->colorCount :$tempOrder->colorCount);
			$tempOrder->orderHeight			=(intval($this->orderHeight) > 0 ?$this->orderHeight:$tempOrder->orderHeight);
			$tempOrder->orderWeidth			=(intval($this->orderWeidth) > 0 ?$this->orderWeidth:$tempOrder->orderWeidth);
			
			$tempOrder->printCount			=(intval($this->printCount) > 0 ?$this->printCount	:$tempOrder->printCount);
			$tempOrder->order_file_id		=(intval($this->order_file_id) > 0 ?$this->order_file_id:$tempOrder->order_file_id)	;
			$tempOrder->admin_name			=($this->admin_name!='' ?$this->admin_name	:$tempOrder->admin_name);
			$tempOrder->label_distance		=(intval($this->label_distance) > 0 ?$this->label_distance:$tempOrder->label_distance)	;
			$tempOrder->label_material		=($this->label_material!='' ?$this->label_material	:$tempOrder->label_material);
			$tempOrder->color1				=($this->color1!='' ? $this->color1:$tempOrder->color1);
			$tempOrder->color2				=($this->color2!='' ? $this->color2:$tempOrder->color2);
			$tempOrder->color3				=($this->color3!='' ? $this->color3:$tempOrder->color3);
			$tempOrder->color4				=($this->color4!='' ? $this->color4:$tempOrder->color4);
			$tempOrder->color5				=($this->color5!='' ? $this->color5:$tempOrder->color5);
			$tempOrder->color6				=($this->color6!='' ? $this->color6:$tempOrder->color6);
			$tempOrder->delivery_count		=(intval($this->delivery_count) > 0 ? $this->delivery_count:$tempOrder->delivery_count)	;
			$tempOrder->delivery_width		=(intval($this->delivery_width) > 0 ?$this->delivery_width:$tempOrder->delivery_width)	;
			$tempOrder->delivery_weight		=(intval($this->delivery_weight) > 0 ?$this->delivery_weight:$tempOrder->delivery_weight)	;
			$tempOrder->shahed_pic_id		=(intval($this->shahed_pic_id) > 0 ?$this->shahed_pic_id:$tempOrder->shahed_pic_id)	;
		}
		else 
		{
			$tempOrder= R::dispense('userorder');
			$tempOrder->description			= $this->description;
			$tempOrder->name				= $this->name;
			$tempOrder->abstractDesc		= $this->abstractDesc;
			$tempOrder->typeId				= $this->typeId; 
			$tempOrder->titleId				= $this->titleId ;
			$tempOrder->statusId			= $this->statusId ;
			$tempOrder->serviceId			= $this->serviceId;
			$tempOrder->createDate			= $this->createDate;
			$tempOrder->expireDate			= $this->expireDate;
			$tempOrder->deliverDate			= $this->deliverDate;
			$tempOrder->createBalanceId		= $this->createBalanceId ;
			$tempOrder->isStarted			= $this->isStarted  ;
			$tempOrder->isCompleteOrder		= $this->isCompleteOrder  ;
			$tempOrder->isDelivered			= $this->isDelivered  ;
			$tempOrder->isDeleted			= $this->isDeleted  ;
			$tempOrder->isAccepted			= $this->isAccepted ;
			$tempOrder->isVip				= $this->isVip ;
			$tempOrder->isPaid				= $this->isPaid ;
			$tempOrder->isCanceled			= $this->isCanceled  ;
			$tempOrder->lastUpdate			=$this->lastUpdate ;
			$tempOrder->printPrice			=$this->printPrice ;
			$tempOrder->servicePrice		=$this->servicePrice ;
			$tempOrder->ownerMobile			=$this->ownerMobile ;
			$tempOrder->count				=$this->count ;
			$tempOrder->paperType  			=$this->paperType  ;
			$tempOrder->colorCount 			=$this->colorCount  ;
			$tempOrder->orderHeight			=$this->orderHeight ;
			$tempOrder->orderWeidth			=$this->orderWeidth ;
			
			$tempOrder->printCount			=$this->printCount	 ;
			$tempOrder->order_file_id		=$this->order_file_id 	;
			$tempOrder->admin_name			=$this->admin_name ;
			$tempOrder->label_distance		=$this->label_distance 	;
			$tempOrder->label_material		= $this->label_material	;
			$tempOrder->color1				= $this->color1;
			$tempOrder->color2				= $this->color2;
			$tempOrder->color3				= $this->color3;
			$tempOrder->color4				= $this->color4;
			$tempOrder->color5				= $this->color5;
			$tempOrder->color6				= $this->color6;
			$tempOrder->delivery_count		= $this->delivery_count	;
			$tempOrder->delivery_width		=$this->delivery_width 	;
			$tempOrder->delivery_weight		=$this->delivery_weight ;
			$tempOrder->shahed_pic_id		=$this->shahed_pic_id 	;
			
			$tempOrder->adminId				=$this->adminId; //no edit

		}
		
		
		$this->id = R::store($tempOrder);
	}
	
	public function getUserOrder($id )
	{ 
		$id = intval($id);
		if ($id>0)
		{
			
			$tempOrder=R::load('userorder',$id);
			 
			$this->id					=$tempOrder->id;
			$this->name					=$tempOrder->name;
			$this->description			=$tempOrder->description;
			$this->abstractDesc			=$tempOrder->abstractDesc;
			$this->typeId				=$tempOrder->typeId;
			$this->titleId				=$tempOrder->titleId;
			$this->statusId				=$tempOrder->statusId;
			$this->serviceId			=$tempOrder->serviceId;
			$this->createDate			=$tempOrder->createDate;
			$this->expireDate			=$tempOrder->expireDate;
			$this->deliverDate			=$tempOrder->deliverDate;
			$this->createBalanceId		=$tempOrder->createBalanceId;
			$this->isStarted			=$tempOrder->isStarted;
			$this->isCompleteOrder		=$tempOrder->isCompleteOrder;
			$this->isDelivered			=$tempOrder->isDelivered;
			$this->adminId				=$tempOrder->adminId;
			$this->isDeleted			=$tempOrder->isDeleted;
			$this->isAccepted			=$tempOrder->isAccepted;
			$this->isVip				=$tempOrder->isVip;
			$this->isPaid				=$tempOrder->isPaid;
			$this->isCanceled			=$tempOrder->isCanceled;
			$this->lastUpdate			=$tempOrder->lastUpdate;
			$this->printPrice			=$tempOrder->printPrice;
			$this->servicePrice			=$tempOrder->servicePrice;
			$this->ownerMobile			=$tempOrder->ownerMobile;
			$this->count				=$tempOrder->count;
			$this->paperType  			=$tempOrder->paperType  ;
			$this->colorCount 			=$tempOrder->colorCount ;
			$this->orderHeight			=$tempOrder->orderHeight;
			$this->orderWeidth			=$tempOrder->orderWeidth;
			
			$this->printCount						=$tempOrder->printCount	;
			$this->order_file_id					=$tempOrder->order_file_id	;
			$this->admin_name						=$tempOrder->admin_name	;
			$this->label_distance					=$tempOrder->label_distance	;
			$this->label_material					=$tempOrder->label_material	;
			$this->color1							=$tempOrder->color1			;
			$this->color2							=$tempOrder->color2			;
			$this->color3							=$tempOrder->color3			;
			$this->color4							=$tempOrder->color4			;
			$this->color5							=$tempOrder->color5			;
			$this->color6							=$tempOrder->color6			;
			$this->delivery_count					=$tempOrder->delivery_count	;
			$this->delivery_width					=$tempOrder->delivery_width	;
			$this->delivery_weight					=$tempOrder->delivery_weight	;
			$this->shahed_pic_id					=$tempOrder->shahed_pic_id	;
				 
			return $this;
		}
	}
	
	public function  getRunningOrders($userId=0,$begin=0,$end=0)
	{
		if($userId == 0)
		{
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		}
		$isStarted=1;
		$isCompleteOrder=0;
		return $this->searchUserOrder(
					$begin, 
					$end,
					'',//title
					0,//id
					'',//desc
					'',//absDesc
					$isStarted,
					$isCompleteOrder,
					$userId
					);
	}
	
	public function  getCompletedOrders($userId=0,$begin=0,$end=0)
	{
		if($userId == 0)
		{
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		}
		 
		$isCompleteOrder=1;
		return $this->searchUserOrder(
					$begin, 
					$end,
					'',//title
					0,//id
					'',//desc
					'',//absDesc
					-1,
					$isCompleteOrder,
					$userId
					);
	}
	
	public function  getConsideredOrder($userId=0,$begin=0,$end=0)
	{
		if($userId == 0)
		{
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		}
		  
		$isPaid=1;
		return $this->searchUserOrder(
					$begin, 
					$end,
					'',//title
					0,//id
					'',//desc
					'',//absDesc
					-1, //isStarted
					-1,//$isCompleteOrder
					$userId,
					-1,//$isDelivered=
					-1,//$isDeleted=
					-1,//$isAccepted=
					-1,//$isVip=
					$isPaid
					);
	}
	
	public function  getReadyOrder($userId=0,$begin=0,$end=0)
	{
		if($userId == 0)
		{
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		}
		  
		$statusId=3; //ready for delivery
		return $this->searchUserOrder(
					$begin, 
					$end,
					'',//title
					0,//id
					'',//desc
					'',//absDesc
					-1, //isStarted
					-1,//$isCompleteOrder
					$userId,
					-1,//$isDelivered=
					-1,//$isDeleted=
					-1,//$isAccepted=
					-1,//$isVip=
					-1,//$isPaid
					-1,//$isCanceled=-1,
					0,//$typeId=0,
					0,//$titleId=0,
					$statusId
					);
	}
	
	public function  getArchiveOrder($userId=0,$begin=0,$end=0)
	{
		if($userId == 0)
		{
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		}
		  
		return $this->searchUserOrder(
					$begin, 
					$end,
					'',//title
					0,//id
					'',//desc
					'',//absDesc
					-1, //isStarted
					-1,//$isCompleteOrder
					$userId
					);
	}
	
	public function  getNewOrders($userId=0,$begin=0,$end=0)
	{
		if($userId == 0)
		{
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		}
		$isStarted=0;
		$isCompleteOrder=0;
		return $this->searchUserOrder(
					$begin, 
					$end,
					'',//title
					0,//id
					'',//desc
					'',//absDesc
					$isStarted,
					$isCompleteOrder,
					$userId
					);
	}
	
	public function getPrevOrders($userId=0,$begin=0,$end=0)
	{
		if($userId == 0)
		{
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		} 
		$isCompleteOrder=1;
		return $this->searchUserOrder($begin, $end,
				'',//title
				0,//id
				'',//desc
				'',//absDesc
				-1,
				$isCompleteOrder,
				$userId
				);
	}
	
	public function getQueueOrders($userId=0,$begin=0,$end=0)
	{
		if($userId == 0){
			$user=GSMS::$class['session']->getUser();
			$userId=($user['UserType']==2 ? $user['UserID'] : 0 );
		}
		$isStarted=1;
		$isCompleteOrder=1;
		return $this->searchUserOrder(
			$begin, 
			$end,
			'',//title
			0,//id
			'',//desc
			'',//absDesc
			$isStarted,
			$isCompleteOrder,
			$userId
			);
	}
		
	public function searchUserOrder(
				$begin=0, 
				$end=0,  
				$title='',
				 $id=0,
				 $description='',
				 $abstractDesc='',
				 $isStarted=-1,
				 $isCompleteOrder=-1,
				 $adminId=0,
				 $isDelivered=-1,
				 $isDeleted=-1,
				 $isAccepted=-1,
				 $isVip=-1,
				 $isPaid=-1,
				 $isCanceled=-1,
				 $typeId=0,
				 $titleId=0,
				 $statusId=0,
				 $serviceId='',
				 $beginCreateDate='',
				 $endCreateDate='',
				 $beginExpireDate='',
				 $endExpireDate='',
				 $beginDeliverDate='',
				 $endDeliverDate='',
				 $createBalanceId=0,
				 $lastUpdate='',
				 $printPrice=0,
				 $servicePrice=0,
				 $ownerMobile='',
				 $count=0)
	 {
		if(intval($begin)==0)
			$begin=0;
			
		if(intval($end)==0 )
			$end=GSMS::$config['page_item_per_page'];
		
		if($end> GSMS::$config['page_item_per_page'] )
			$end= $end  - $begin;
		if($beginCreateDate != '' ) 
			$endCreateDate  = ($endCreateDate != '' ? $endCreateDate : GSMS::$class['calendar']->now());
		if($beginExpireDate != '' ) 
			$endExpireDate  = ($endExpireDate != '' ? $endExpireDate : GSMS::$class['calendar']->now());
		if($beginDeliverDate != '' ) 
			$endDeliverDate  = ($endDeliverDate != '' ? $endDeliverDate : GSMS::$class['calendar']->now());	
		
		
		$q=($title == '' ? '' :'`title` like \'%'.$title.'%\'  ') ;
		$q.=($beginCreateDate == '' ? '' : ($q!=''? ' and ' : '' ) .'`create_date` >=   \''.$beginCreateDate.'\'  and `create_date` <= \''.$endCreateDate.'\'') ;
		$q.=($beginExpireDate == '' ? '' : ($q!=''? ' and ' : '' ) .'`expire_date` >=   \''.$beginExpireDate.'\'  and `expire_date` <= \''.$endExpireDate.'\'') ;
		$q.=($beginDeliverDate == '' ? '' : ($q!=''? ' and ' : '' ) .'`deliver_date` >=   \''.$beginDeliverDate.'\'  and `deliver_date` <= \''.$endDeliverDate.'\'') ;
		
		$q.=($description =='' ? '' : ($q!=''? ' and ' : '' ) .'`description` like \'%'.$description.'%\'   ');
		$q.=($abstractDesc =='' ? '' : ($q!=''? ' and ' : '' ) .'`abstract_desc` like \'%'.$abstractDesc.'%\'   ');
		
		$q.=($isAccepted == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_accepted`='.$isAccepted.'   ');
		$q.=($isStarted == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_started`='.$isStarted.'   ');
		
		$q.=($isCompleteOrder == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_complete_order`='.$isCompleteOrder.'   ');
		$q.=($isDelivered == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_delivered`='.$isDelivered.'   ');
		$q.=($isDeleted == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_deleted`='.$isDeleted.'   ');
		$q.=($isVip == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_vip`='.$isVip.'   ');
		$q.=($isPaid == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_paid`='.$isPaid.'   ');
		$q.=($isCanceled == -1 ? '' : ($q!=''? ' and ' : '' ) .'`is_canceled='.$isCanceled.'   ');
		$q.=($ownerMobile =='' ? '' : ($q!=''? ' and ' : '' ) .'`ownerMobile`=\''.$ownerMobile.'\'   ');
		
		
		
		$user=GSMS::$class['session']->getUser();
		 
		if( $user['UserType']==2  ) //user
		{
			 
			GSMS::load('admin','class'); 
			$tempAdmin = GSMS::$class['admin']->getAdmin($user['UserID']);
			
			if(intval($tempAdmin->permission ) >0)
			{
				$q.=(  ($q!=''? ' and ' : '' ) .'`type_id` in ( '. $tempAdmin->permission .' )  ');
			} 
			else 
			{
				$q.=(  ($q!=''? ' and ' : '' ) .'`admin_id`='. $user['UserID'] .'   ');
			}
			
		}
		else   //employ || admin
		{
			if( $adminId >0)
			{
				$q.=(  ($q!=''? ' and ' : '' ) .'`admin_id`='.$adminId.'   ');
			}
			$q.=($typeId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`type_id`='.$typeId.'   ');
		}
		
		
		
		
		$q.=($titleId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`title_id`='.$titleId.'   ');
		
		$q.=($statusId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`status_id`='.$statusId.'   ');
		if($q!='')
			$q=' where '.$q ;
 
		$q_count=R::dispense('userorder'); 
		
		
		$q_count=R::getAll('select count(*)as cnt from  `userorder` '.$q );
		$result_count = $q_count[0]['cnt'];
		
		$_SESSION['query_count']= $result_count;
		$_SESSION['query']= 'select * from `userorder`   '.$q;
		
		
		$tempOrders=R::dispense('userorder'); 
		$tempOrderRows=R::getAll('select * from `userorder`  '.$q.' limit '.$begin.','.$end);
		
		
		$tempOrders=$this->map($tempOrderRows);
				
		return array($tempOrders,$begin,$result_count);
	}
	
	public function review($query, $query_count, $begin, $end)
	{
		$tempOrders=R::dispense('userorder'); 
		$tempOrderRows=R::getAll($query.' limit '.$begin.','.$end);		
		
		$tempOrders=$this->map($tempOrderRows);
				
		return array($tempOrders,$begin,$query_count);
	}
	private function map($row)
	{
		$tempOrders= array();
		
		$count = count($row);
		for($i = 0 ; $i< $count; $i++ )
		{
			$tempOrder= new userOrder();
			
			$tempOrder->name					=$row[$i]['name'];
			$tempOrder->id						=$row[$i]['id'];
			$tempOrder->description				=$row[$i]['description'];
			$tempOrder->abstractDesc			=$row[$i]['abstract_desc'];
			$tempOrder->typeId					=$row[$i]['type_id'];
			$tempOrder->titleId					=$row[$i]['title_id'];
			$tempOrder->statusId				=$row[$i]['status_id'];
			$tempOrder->serviceId				=$row[$i]['service_id'];
			$tempOrder->createDate				=$row[$i]['create_date'];
			$tempOrder->expireDate				=$row[$i]['expire_date'];
			$tempOrder->deliverDate				=$row[$i]['deliver_date'];
			$tempOrder->createBalanceId			=$row[$i]['create_balance_id'];
			$tempOrder->isStarted				=$row[$i]['is_started'];
			$tempOrder->isCompleteOrder			=$row[$i]['is_complete_order'];
			$tempOrder->isDelivered				=$row[$i]['is_delivered'];
			$tempOrder->adminId					=$row[$i]['admin_id'];
			$tempOrder->isDeleted				=$row[$i]['is_deleted'];
			$tempOrder->isAccepted				=$row[$i]['is_accepted'];
			$tempOrder->isVip					=$row[$i]['is_vip'];
			$tempOrder->isPaid					=$row[$i]['is_paid'];
			$tempOrder->isCanceled				=$row[$i]['is_canceled'];
			$tempOrder->lastUpdate				=$row[$i]['last_update'];
			$tempOrder->printPrice				=$row[$i]['print_price'];
			$tempOrder->servicePrice			=$row[$i]['service_price'];
			$tempOrder->ownerMobile				=$row[$i]['ownerMobile'];
			$tempOrder->count					=$row[$i]['count'];
			$tempOrder->paperType  				=$row[$i]['paper_type'];
			$tempOrder->colorCount 				=$row[$i]['color_count'];
			$tempOrder->orderHeight				=$row[$i]['order_height'];
			$tempOrder->orderWeidth				=$row[$i]['order_weidth'];
			
			$tempOrder->printCount						=$row[$i]['print_count'];
			$tempOrder->order_file_id					=$row[$i]['order_file_id'];
			$tempOrder->admin_name						=$row[$i]['admin_name'];
			$tempOrder->label_distance					=$row[$i]['label_distance'];
			$tempOrder->label_material					=$row[$i]['label_material'];
			$tempOrder->color1							=$row[$i]['color1'];
			$tempOrder->color2							=$row[$i]['color2'];
			$tempOrder->color3							=$row[$i]['color3'];
			$tempOrder->color4							=$row[$i]['color4'];
			$tempOrder->color5							=$row[$i]['color5'];
			$tempOrder->color6							=$row[$i]['color6'];
			$tempOrder->delivery_count					=$row[$i]['delivery_count'];
			$tempOrder->delivery_width					=$row[$i]['delivery_width'];
			$tempOrder->delivery_weight					=$row[$i]['delivery_weight'];
			$tempOrder->shahed_pic_id					=$row[$i]['shahed_pic_id'];
			
			$tempOrders[] = $tempOrder;
		}
		return $tempOrders;
	}
	
}

if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}

?>
