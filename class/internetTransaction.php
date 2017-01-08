<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all photo functionality on control(controller) layer start 24-7-93 by nasser niazy
class internetTransaction
{
	public  $id					;
	public 	$resNum				;
	public 	$refNum				;
	public 	$totalAmount		;
	public 	$payment			;
	public 	$dateStart			;
	public 	$lastUrl			;
	public 	$ipAddress			;
	public 	$timeStart			;
	public 	$email				;
	public 	$adminId			;
	public 	$name				;
	public 	$phone				;
	public 	$comment			;
	public 	$balanceId			;
	public 	$tempCredit			;
	public 	$factureId			;
	public 	$orderId            ;

 	public function __construct()
	{
		GSMS::load('log','class');	
		$this->id=0;
       
		$user=GSMS::$class['session']->getUser();
		$this->adminId=$user['UserID'];
		$this->CreateDate=GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG','internetTransaction class Initialized');
	}//fun
	
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun

	public function save()
	{
		$tempTransaction = R::dispense('internet_transaction');
		if($this->id != 0)
		{
			$tempTransaction = R::load('internet_transaction',$this->id);
		}
		//$tempTransaction->id		=$this->id	;
		$tempTransaction->resNum		=$this->resNum			;
		$tempTransaction->refNum		=$this->refNum			;
		$tempTransaction->totalAmount	=$this->totalAmount		;
		$tempTransaction->payment		=$this->payment			;
		$tempTransaction->dateStart		=$this->dateStart		;
		$tempTransaction->lastUrl		=$this->lastUrl			;
		$tempTransaction->ipAddress		=$this->ipAddress		;
		$tempTransaction->timeStart		=$this->timeStart		;
		$tempTransaction->email			=$this->email			;
		$tempTransaction->adminId		=$this->adminId			;
		$tempTransaction->name			=$this->name			;	
		$tempTransaction->phone			=$this->phone			;	
		$tempTransaction->comment		=$this->comment			;
		$tempTransaction->balanceId 	=$this->balanceId 		;
		$tempTransaction->tempCredit	=$this->tempCredit		;
		$tempTransaction->planId		=$this->planId			;	
		$tempTransaction->telgroupId   	=$this->telgroupId  		;  	

		$this->id = R::store( $tempTransaction );
		
	}//func
	
	public function listTransactions($begin=0,$end=0)
	{

        $tempTransaction = R::dispense('internet_transaction');
		
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		
		$query='select * from `internet_transaction` ';
		$rowCount = count(R::getAll($query));
		$tempTransaction = R::getAll($query . ' limit '. $begin . ','. $end);
		
		if(count($tempTransaction)>0)
		{			
			return array($this->map( $tempTransaction),$begin,$rowCount );
		}else
		{
			return 0; // no result for query
		}//else
	}//func
	
	public function getTransaction($id)
	{
		$id=intval($id);
		if ($id>0)
		{
			$tempTransaction = R::dispense('internet_transaction');
			$tempTransaction = R::load('internet_transaction',$id);
			$newTransaction = new internetTransaction();
			
			$newTransaction->resNum			=$tempTransaction->resNum		;
			$newTransaction->refNum			=$tempTransaction->refNum		;
			$newTransaction->totalAmount	=$tempTransaction->totalAmount	;
			$newTransaction->payment		=$tempTransaction->payment		;
			$newTransaction->dateStart		=$tempTransaction->dateStart	;
			$newTransaction->lastUrl		=$tempTransaction->lastUrl		;
			$newTransaction->ipAddress		=$tempTransaction->ipAddress	;
			$newTransaction->timeStart		=$tempTransaction->timeStart	;
			$newTransaction->email			=$tempTransaction->email		;
			$newTransaction->adminId		=$tempTransaction->adminId		;
			$newTransaction->name			=$tempTransaction->name			;
			$newTransaction->phone		    =$tempTransaction->phone		;
			$newTransaction->comment		=$tempTransaction->comment		;
			$newTransaction->balanceId 	    =$tempTransaction->balanceId 	;
			$newTransaction->tempCredit	    =$tempTransaction->tempCredit	;
			$newTransaction->planId		    =$tempTransaction->planId		;
			$newTransaction->telgroupId  	    =$tempTransaction->telgroupId  	;
			
			
			return $newTransaction;
			
		}//if
		return 0;
	}//func
	
	public function listTransactionByUser(
					$user,
					$begin=0,
					$end=30)
	{

        if(GSMS::$class['session']->checkAdmin())
        {
            return $this->listTransactions($begin,$end);
        }
        else
        {
            return $this->searchTransaction(
			'',//startdate
			'',//end date
			0, //telgroupId
			0,	//planId
                $user);
        }
	}
		
	public function getTransactionByResNum(
					$resNum)
	{
		$arr =  $this->searchTransaction(
			'',//startdate
			'',//end date
			0,//telgroupId
			0,//planId
			0,//userId
			$resNum);
			
			
		if(count($arr)>0)
			return $arr[0][0];
		return 0;
        
	}
	
	public function searchTransaction(
					$BeginCreateDate='',
					$EndCreateDate='',
					$telgroupId=0,
					$PlanId='', 
					$UserId=0,
					$resNum='',
					$refNum='',
					$begin=0,
					$end=0)
	{

		if($BeginCreateDate != '' ) 
			$EndCreateDate  = ($EndCreateDate != '' ? $EndCreateDate : GSMS::$class['calendar']->now());
			
		if(intval($begin)==0)
			$begin=0;
			
		if(intval($end)==0 )
			$end=GSMS::$config['page_item_per_page'];
		
	
		$q=	'' ;
		$q.=	($BeginCreateDate == '' ? '' : ($q!=''? ' and ' : '' ) .'`start_date` >=   \''.$BeginCreateDate.'\'  and `start_date` <= \''.$EndCreateDate.'\'') ;
		
		
		$q.=	($resNum =='' ? '' : ($q!=''? ' and ' : '' ) .'`res_num` = \''.$resNum.'\'   ');
		$q.=	($refNum =='' ? '' : ($q!=''? ' and ' : '' ) .'`ref_num` = \''.$refNum.'\'   ');
		
		$q.=	($UserId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`admin_id`='.$UserId.'   ');
		$q.=	($PlanId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`plan_id`='.$PlanId.'   ');
		$q.=	($telgroupId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`telgroup_id`='.$telgroupId.'   ');

		
		
		if($q!='')
			$q=' where '.$q ;
	
		//$tempTransaction = R::dispense('internet_transaction');
		$query = 'select * from `internet_transaction`  ';
		$rowCount = count(R::getAll($query ));
		$tempTransaction = R::getAll($query.$q. ' limit '.$begin.','.$end);
		 
		$_SESSION['query_count']= $rowCount;
		$_SESSION['query']= $query;

		if($rowCount>0)
		{
			return array($this->map($tempTransaction),$begin,$rowCount);
		}else
		{
			return 0; // no result for query
		}//else
	}//func
	
	public function review($sql,$result_count , $begin=0,$end=30)
	{
		{
			return 0; // no result for query
		}//else
	}

    public function toString($id=0)
	{
		if ($id==0)
		{
			return $this->name;
		}
		else
		{
			$tempTransaction = R::dispense('internet_transaction');
			$rows = R::load('internet_transaction',$id);	
			
			
			return $rows->name;
			
		}//else
	}//func
	
	private function map($row)
	{
	
		$tempTransactions= array();
		$count = count($row);
		for($i = 0 ; $i< $count; $i++ )
		{
			$tempTransaction=new internetTransaction();
			$tempTransaction->resNum		=$row[$i]['res_num']	;
			$tempTransaction->refNum		=$row[$i]['ref_num'];
			$tempTransaction->totalAmount	=$row[$i]['total_amount'];
			$tempTransaction->payment		=$row[$i]['payment'];
			$tempTransaction->dateStart		=$row[$i]['date_start'];
			$tempTransaction->lastUrl		=$row[$i]['last_url'];
			
			$tempTransaction->ipAddress		=$row[$i]['ip_address'];
			$tempTransaction->timeStart		=$row[$i]['time_start'];
			$tempTransaction->email			=$row[$i]['email'];
			$tempTransaction->adminId		=$row[$i]['admin_id'];
			$tempTransaction->name			=$row[$i]['name'];
			$tempTransaction->phone			=$row[$i]['phone'];
			$tempTransaction->comment		=$row[$i]['comment'];
			$tempTransaction->balanceId 	=$row[$i]['balance_id'];
			$tempTransaction->tempCredit	=$row[$i]['temp_credit'];
			$tempTransaction->planId		=$row[$i]['plan_id'];
			$tempTransaction->telgroupId  	    =$row[$i]['telgroup_id'];
			
			$tempTransactions[] = $tempTransaction;
		}
		return $tempTransactions;
	}

	public function getCount()
	{
		$tempTransaction = R::dispense('internet_transaction');
		$row = R::getAll('select count(`id`)as cnt from  `internet_transaction` ');
		return  $row[0]['cnt'];
		
	}//func
	
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
