<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all photo functionality on control(controller) layer start 24-7-93 by nasser niazy
class planRegistered
{
	public $id					;
	public $adminId				;
	public $planId				;
	public $telgroupId				;
	public $date				;
	public $time				;
	public $day					;
	public $description				;
	public $isActive			;
	public $isExpired			;
	public $expireDate			;
	public $balanceId			;
	public $planPrice			;
	public $credit			;

 	public function __construct()
	{
		GSMS::load('log','class');	
		$this->id=0;
        $this->isActive=0;
		
		$this->CreateDate=GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG','plan_registered class Initialized');
	}//fun
	
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun

	public function save()
	{ 
		$tempPlan = R::load('plan_registered',0);
		if($this->id != 0)
		{
			$tempPlan = R::load('plan_registered',$this->id);
		}
				
		$tempPlan->id			=$this->id			;
		$tempPlan->adminId		=$this->adminId		;
		$tempPlan->planId		=$this->planId		;
		$tempPlan->telgroupId	=$this->telgroupId		;
		$tempPlan->date			=$this->date			;
		$tempPlan->time			=$this->time			;
		$tempPlan->day			=$this->day			;
		$tempPlan->description	=$this->description	;
		$tempPlan->isActive		=$this->isActive		;
		$tempPlan->isExpired	=$this->isExpired	;
		$tempPlan->expireDate	=$this->expireDate	;
		$tempPlan->balanceId	=$this->balanceId	;
		
		$tempPlan->planPrice	=$this->planPrice	;
		$tempPlan->credit		=$this->credit	;
		
		$this->id = R::store( $tempPlan );
		
	}//func
	public function getAdsDetails($plan,$begin=0,$end=30)
	{

        $tempPlans = R::dispense('plan');
		
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		
		$query='SELECT *  FROM  `adslog` WHERE registered_plan_id='.intval($plan)  .' order by date asc';
					
		$rowCount = count(R::getAll($query));
		$tempPlans = R::getAll($query . ' limit '. $begin . ','. $end);
		
		if(count($tempPlans)>0)
		{			
			return array($tempPlans,$begin,$rowCount );
		}else
		{
			return 0; // no result for query
		}//else
	}//func
	
	public function getPlanRegisteredDetail($id)
	{
		$tempPlans = R::dispense('plan');
		
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		
		$query='select tl.title,plan.name,plan.description as pldesc,pl.* from `telgroup` tl 
									INNER JOIN plan_registered pl ON pl.telgroup_id = tl.id
									INNER JOIN plan plan ON plan.id = pl.plan_id
									WHERE   pl.id = ' . $id .'
									ORDER BY id desc
									' ;
		
		$tempPlans = R::getAll($query );
		
		if(count($tempPlans)>0)
		{			
			return  $tempPlans;
		}else
		{
			return array(); // no result for query
		}//else
	}
	
	public function listPlanRegistered($user = 0 ,$begin=0,$end=0)
	{
		
        $tempPlans = R::dispense('plan');
		
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		
		$query='select tl.title,plan.name,plan.description as pldesc,pl.* from `telgroup` tl 
									INNER JOIN plan_registered pl ON pl.telgroup_id = tl.id
									INNER JOIN plan plan ON plan.id = pl.plan_id
											'.($user == 0 ? '':  '	WHERE   pl.admin_id = ' . $user ).'
												ORDER BY id desc
												' ;
		$rowCount = count(R::getAll($query));
		$tempPlans = R::getAll($query . ' limit '. $begin . ','. $end);
		
		if(count($tempPlans)>0)
		{			
			return array( $tempPlans,$begin,$rowCount );
		}else
		{
			return array(); // no result for query
		}//else
	}//func
	
	public function getPlanRegistered($id)
	{
		
		$id=intval($id);
		if ($id>0)
		{
			$row='';
			$max=0;	
			GSMS::$class['DB']->run('select *   FROM plan_registered where id=' . $id,
								'planRegistered.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'getPlanRegistered'	//sql code subject	
								);
			$tempPlan = new planRegistered();
			
			$tempPlan->id			=$row['id']	;
			$tempPlan->adminId		=$row['admin_id']		;
			$tempPlan->telgroupId	=$row['telgroup_id']		;
			$tempPlan->planId		=$row['plan_id']		;
			$tempPlan->date			=$row['date']			;
			$tempPlan->time			=$row['time']			;
			$tempPlan->day			=$row['day']			;
			$tempPlan->description	=$row['description']	;
			$tempPlan->isActive		=$row['is_active']		;
			$tempPlan->isExpired	=$row['is_expired']		;
			$tempPlan->expireDate	=$row['expire_date']	;
			$tempPlan->balanceId	=$row['balance_id']		;
			$tempPlan->planPrice	=$row['plan_price']		;
			$tempPlan->credit		=$row['credit']		;
						
			return $tempPlan;
			
		}//if
		return 0;
	}//func

	//گرفتن تبلیغات
   public function getAdsGroup($partKey,$count)
   {
	    $useragent=$_SERVER['HTTP_USER_AGENT'];
		 if(strpos($useragent,'bot') !==  false)
			 return ; 
		GSMS::load('telgroup','class');	
		GSMS::load('visit','class');	
	   
		$limi = '';
		if($part =='view_in_site_mobile' ) 
			$limi  = ' and  pl.plan_id = 4 or  pl.plan_id = 5  or  pl.plan_id = 7 or  pl.plan_id = 8 or  pl.plan_id = 9'   ;
		elseif($part =='view_in_site_main')
			$limi  = ' and pl.plan_id = 4 or  pl.plan_id = 5 or pl.plan_id = 7 or  pl.plan_id = 8 or  pl.plan_id = 9'   ;
		
		
	   $query = '  `telgroup` tl
												INNER JOIN plan_registered pl ON pl.telgroup_id = tl.id
												WHERE tl.is_accepted = 1 and tl.is_vip=1 and pl.credit> 0 	
														and pl.is_active =1	'.$limi.'								
												ORDER BY rand() ';
	   
		$row='';
		$max=0;	
							
		$result=GSMS::$class['DB']->run('SELECT tl.*, pl.id as plan FROM '.$query. ' limit 0,'.$count,
								'planRegistered.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'getads '	//sql code subject	
								);
		
		for($i=0 ; $i< count($result) ; $i++ )
		{
			
			GSMS::$class['visit']->logAds($partKey , $result[$i]['plan'], 0) ; 
			
		}			
		
		return GSMS::$class['telgroup']->map($result);
		
   }
	
	//مثلآ برای کلیک رو عضویت
   public function setAdsForGroup($partKey,$groupId)
   {
	    $useragent=$_SERVER['HTTP_USER_AGENT'];
		 if(strpos($useragent,'bot') !==  false)
			 return ; 
	   GSMS::load('telgroup','class');	
	   GSMS::load('visit','class');	
	   
	   $query = '  `telgroup` tl
												INNER JOIN plan_registered pl ON pl.telgroup_id = tl.id
												WHERE  tl.id='. $groupId . ' and pl.is_active =1											
												ORDER BY rand() ';
	   
					
		$result=R::dispense('telgroup'); 
		$result=R::getAll('SELECT tl.*, pl.id as plan FROM '.$query);
		
		list($partPrice)  = GSMS::$class['option']->get_optionsByKey($partKey);
		//$partPrice[0]->value
		
		$planRegistered = $this->getPlanRegistered($result[0]['plan']);
		 
		
		$planRegistered->credit = $planRegistered->credit - $partPrice[0]->value ; 
		if ($planRegistered->credit <= 0 )
		{
			//finishing user ads .
			//$planRegistered->credit = 0 ; 
			$planRegistered->isActive = 0 ; 
			
		}				
		$planRegistered->save() ; 
		GSMS::$class['visit']->logAds($partKey , $result[0]['plan'], $partPrice[0]->value) ; 
				
		
		return GSMS::$class['telgroup']->map($result);
		
   }
	
	public function updateAds()
	{
		GSMS::load('option','class');
		$query="SELECT COUNT( ads.id ) AS cnt, ads.`date` , ads.`part` ,pl.id,pl.telgroup_id FROM `plan_registered` pl
					 INNER JOIN adsvisit ads ON pl.id = ads.plan_registered_id 
					  where is_calc =0 
					 GROUP BY ads.`date` , ads.`part` ,pl.id 
					  " ;
					
		
		$tempPlans = R::getAll($query );
		
		
		$price=array();
		 
		for($i=0 ; $i<count($tempPlans ); $i++ )
		{
			$planRegistered = $this->getPlanRegistered($tempPlans[$i]['id']);
			
			if(!is_object($planRegistered)  ) 
				continue ; 
			
			list($price)  = GSMS::$class['option']->get_optionsByKey($tempPlans[$i]['part']);
			$cnt  = intval(GSMS::$class['option']->get_optionsByKey($tempPlans[$i]['cnt']));
			
			 
			
			$planRegistered->credit = $planRegistered->credit -( intval( $partPrice[0]->value) * $cnt ); 
			
			
			$tempAdsLog = R::dispense('adslog');
			
			$tempAdsLog->telgroupId			=$tempPlans[$i]['telgroup_id'];
			$tempAdsLog->registeredPlanId	=$tempPlans[$i]['id'];	
			$tempAdsLog->price				=intval($price[0]->value);
			$tempAdsLog->part				=$tempPlans[$i]['part'];
			$tempAdsLog->date				=$tempPlans[$i]['date'];
			$tempAdsLog->count				=intval($tempPlans[$i]['cnt']);
			$tempAdsLog->totoalPrice=	intval($price[0]->value) * intval($tempPlans[$i]['cnt']);
			
			
			R::store($tempAdsLog);
			
			$row='';
			$max=0;	
			
			
			
			if ($planRegistered->credit  < 0 ) 
				$planRegistered->isActive = 0 ; 
			//$planRegistered->save() ; 
		}
		
		GSMS::$class['DB']->run('delete from  adsvisit  ',
								'planRegistered.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'update ads'	//sql code subject	
								);
		echo 'count '. count($tempPlans). ' ads is completed.';
	}
	
	private function map($row)
	{
	
		$tempPlans= array();
		$count = count($row);
		for($i = 0 ; $i< $count; $i++ )
		{
			$tempPlan=new planRegistered();
			$tempPlan->id			=$row[$i]['id']	;
			$tempPlan->adminId		=$row[$i]['admin_id']		;
			$tempPlan->telgroupId	=$row[$i]['telgroup_id']		;
			$tempPlan->planId		=$row[$i]['plan_id']		;
			$tempPlan->date			=$row[$i]['date']			;
			$tempPlan->time			=$row[$i]['time']			;
			$tempPlan->day			=$row[$i]['day']			;
			$tempPlan->description	=$row[$i]['description']	;
			$tempPlan->isActive		=$row[$i]['is_active']		;
			$tempPlan->isExpired	=$row[$i]['is_expired']		;
			$tempPlan->expireDate	=$row[$i]['expire_date']	;
			$tempPlan->balanceId	=$row[$i]['balance_id']		;
			$tempPlan->planPrice	=$row[$i]['plan_price']		;
			$tempPlan->credit		=$row[$i]['credit']		;

			$tempPlans[] = $tempPlan;
		}
		return $tempPlans;
	}

	public function getCount()
	{
		$tempComment = R::dispense('plan');
		$row = R::getAll('select count(`id`)as cnt from  `plan_registered` ');
		return  $row[0]['cnt'];
		
	}//func
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
