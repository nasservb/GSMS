<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all photo functionality on control(controller) layer start 24-7-93 by nasser niazy
class plan
{
	public $id;
	public $name;
	public $description;
	public $price;
	public $day;
	public $pictureId;
	public $isActive;
	public $createDate;
	public $addBalance;

 	public function __construct()
	{
		GSMS::load('log','class');	
		$this->id=0;
        $this->isActive=0;
		
		$this->CreateDate=GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG','plan class Initialized');
	}//fun
	
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun

	public function save()
	{
		$tempPlan = R::dispense('plan');
		if($this->id != 0)
		{
			$tempPlan = R::load('plan',$this->id);
		}
		
		//$tempPlan->id			=$this->id			;
		$tempPlan->name			=$this->name		;
		$tempPlan->description	=$this->description	;
		$tempPlan->price		=$this->price		;
		$tempPlan->day			=$this->day			;
		$tempPlan->pictureId	=$this->pictureId	;
		$tempPlan->isActive		=$this->isActive	;
		$tempPlan->createDate	=$this->createDate	;
		$tempPlan->addBalance	=$this->addBalance	;

		$this->id = R::store( $tempPlan );
		
	}//func
	
	public function listPlans($plan_type_id,$begin=0,$end=0)
	{

        $tempPlans = R::dispense('plan');
		
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		
		$query='select * from `plan` where plan_type_id = '.$plan_type_id.' order by sort ';
		$rowCount = count(R::getAll($query));
		$tempPlans = R::getAll($query . ' limit '. $begin . ','. $end);
		
		if(count($tempPlans)>0)
		{			
			return array($this->map( $tempPlans),$begin,$rowCount );
		}else
		{
			return 0; // no result for query
		}//else
	}//func
	
	public function getPlan($id)
	{
		$id=intval($id);
		if ($id>0)
		{
			$tempPlan = R::dispense('plan');
			$tempPlan = R::load('plan',$id);
			$newPlan = new plan();
			
			$newPlan->id			=$tempPlan->id			 ;
			$newPlan->name			=$tempPlan->name		;	
			$newPlan->description	=$tempPlan->description	 ;
			$newPlan->price			=$tempPlan->price		 ;
			$newPlan->day			=$tempPlan->day			 ;
			$newPlan->pictureId		=$tempPlan->pictureId	 ;
			$newPlan->isActive		=$tempPlan->isActive	;	
			$newPlan->createDate	=$tempPlan->createDate	 ;
			$newPlan->addBalance	=$tempPlan->addBalance	 ;

			
			return $newPlan;
			
		}//if
		return 0;
	}//func
	
	public function getPlanByPlanRegistered($id)
	{
		$id=intval($id);
		if ($id>0)
		{
			$tempPlan = R::dispense('plan');
			$tempPlan = R::getAll('select * from plan inner join plan_registered on plan.id = plan_registered.plan_id where plan_registered.id='.$id);
			
			return $this->map($tempPlan);
			
		}//if
		return 0;
	}//func
	
	public function deletePlan($id=0)
	{
	
		$id=intval($id);
		if($id==0)
			$id= $this->id;
			
		if ($id>0)
		{
			$tempPlan = R::dispense('plan');
			$tempPlan = R::exec('delete   from `plan` where `id`='.$id);
			
			return 1;
		}//if
		return 0;
	}//func

    public function toString($id=0)
	{
		if ($id==0)
		{
			return $this->name;
		}
		else
		{
			$tempPlan = R::dispense('plan');
			$rows = R::load('plan',$id);	
			
			return $rows->name;
			
		}//else
	}//func
	
	private function map($row)
	{
	
		$tempPlans= array();
		$count = count($row);
		for($i = 0 ; $i< $count; $i++ )
		{
			$tempPlan=new plan();
			$tempPlan->id	=$row[$i]['id']	;
			$tempPlan->name			=$row[$i]['name']		;
			$tempPlan->description	=$row[$i]['description']	;
			$tempPlan->price		=$row[$i]['price']		;
			$tempPlan->day			=$row[$i]['day']		;
			$tempPlan->pictureId	=$row[$i]['picture_id']	;
			$tempPlan->isActive		=$row[$i]['is_active']	;
			$tempPlan->createDate	=$row[$i]['create_date']	;
			$tempPlan->addBalance	=$row[$i]['add_balance']	;

			$tempPlans[] = $tempPlan;
		}
		return $tempPlans;
	}

	public function getCount()
	{
		$tempComment = R::dispense('plan');
		$row = R::getAll('select count(`id`)as cnt from  `plan` ');
		return  $row[0]['cnt'];
		
	}//func
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
