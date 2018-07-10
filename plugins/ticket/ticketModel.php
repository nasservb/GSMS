<?php //allahoma sale ala mohammad va ale mohammad 


class ticketModel
{
	public $id;
	public $content;
	public $createDate;
	public $userId;
	public $itemId;
	public $itemType;
	public $parentId;
	public $title;
	public $ownerName;
	public $accepted;
	public $readed;
	public $softversion;
	public $ip;

 	public function __construct()
	{
			
		$this->id=0;
        $this->parentId=0;
        $this->accepted=0;
        $this->readed=0;
		$this->itemId=0;
		$user=GSMS::$class['session']->getUser();
		$this->userId=$user['UserID'];
		$this->createDate=GSMS::$class['calendar']->now();
		$this->ip=GSMS::$class['input']->ip_address();
		GSMS::$class['system_log']->log('DEBUG','ticketModel class Initialized');
		
	}//fun
	
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun

	public function save()
	{
		$tempTicket = R::dispense('ticket');
		if(intval($this->id) > 0)
		{
			$tempTicket = R::load('ticket',$this->id);
		}
		
		
		$tempTicket->content	=$this->content	;
		$tempTicket->createDate=$this->createDate;
		$tempTicket->userId	=$this->userId	;
		$tempTicket->itemId	=$this->itemId	;
		$tempTicket->itemType	=$this->itemType	;
		$tempTicket->parentId	=$this->parentId	;
		$tempTicket->name		=$this->name		;
		$tempTicket->email		=$this->email		;
		$tempTicket->accepted	=$this->accepted	;
		$tempTicket->readed	=$this->readed		;
		$tempTicket->softversion	=$this->softversion		;
		$tempTicket->ip	=$this->ip		;
		$tempTicket->owner_name	=$this->ownerName		;

		$this->id = R::store( $tempTicket );
		
	}//func
	
	public function listTickets($begin=0,$end=0)
	{

        $tempTickets = R::dispense('ticket');
		
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		
		$query='select * from `ticket` ';
		$rowCount = count(R::getAll($query));
		$tempTickets = R::getAll($query . ' limit '. $begin . ','. $end);
		
		if(count($tempTickets)>0)
		{			
			return array($this->map( tempTickets),$begin,$rowCount );
		}else
		{
			return 0; // no result for query
		}//else
	}//func
	
	public function getTicket($id)
	{
		$id=intval($id);
		if ($id>0)
		{
			$tempTicket = R::dispense('ticket');
			$tempTicket = R::load('ticket',$id);
			$newTicket = new ticketModel();
			
			
			$newTicket->id		=$tempTicket->id	;
			$newTicket->content		=$tempTicket->content	;
			$newTicket->createDate	=$tempTicket->createDate;
			$newTicket->userId		=$tempTicket->userId	;
			$newTicket->itemId		=$tempTicket->itemId	;
			$newTicket->itemType		=$tempTicket->itemType	;
			$newTicket->parentId		=$tempTicket->parentId	;
			$newTicket->title			=$tempTicket->title		;
			$newTicket->ownerName		=$tempTicket->owner_name	;
			$newTicket->accepted		=$tempTicket->accepted	;
			$newTicket->readed		=$tempTicket->readed	;
			$newTicket->softversion		=$tempTicket->softversion	;
			$newTicket->ip		=$tempTicket->ip	;
			
			return $newTicket;
			
		}//if
		return 0;
	}//func
	
	public function deleteTicket($id=0)
	{
	
		$id=intval($id);
		if($id==0)
			$id= $this->id;
			
		if ($id>0)
		{
			$tempTicket = R::dispense('ticket');
			$tempTicket = R::exec('delete   from `ticket` where `parent_id`='.$id);
			$tempTicket = R::exec('delete   from `ticket` where `id`='.$id);
			
			return 1;
		}//if
		return 0;
	}//func

	public function listTicketsByParent(
					$parent, 
					$accepted=0,
					$begin=0,
					$end=0)
	{
		return $this->searchTicket(
							$begin,
							$end,
							'',//title
							'',//date_begin
							'',//date_end
							0,//item
							'',//ItemType
							'',//describe
							0,//user
                            $accepted,
							$parent , 
							' id asc');
	}
	
	
	public function listTicketsByItem(
					$item,
					$itemType,
					$accepted=0,
					$begin=0,
					$end=0)
	{
		return $this->searchTicket(
							$begin,
							$end,
							'',//title
							'',//date_begin
							'',//date_end
							$item,//item
							$itemType,//ItemType
							'',//describe
							0,//user
                            $accepted);
	}
	
	public function listTicketsByUser(
					$user,
                    $accepted=0,
					$begin=0,
					$end=30)
	{

        if(GSMS::$class['session']->checkAdmin())
        {
            return $this->listTickets($begin,$end);
        }
        else
        {
            return $this->searchTicket(
                $begin,
                $end,
                '',//title
                '',//date_begin
                '',//date_end
                0,//item
                '',//ItemType
                '',//describe
                $user,
                $accepted);
        }

	}
	
	public function searchTicket(
					$begin=0,
					$end=0,
					$title='',
					$BeginCreateDate='',
					$EndCreateDate='',
					$ItemId=0,
					$ItemType='', 
					$Content='',
					$UserId=0,
                    $accepted=2,
                    $parentId=0,
					$order = ''
					)
	{

		if($BeginCreateDate != '' ) 
			$EndCreateDate  = ($EndCreateDate != '' ? $EndCreateDate : GSMS::$class['calendar']->now());
		
		if(intval($begin)==0)
			$begin=0;
			
		if(intval($end)==0 )
			$end=GSMS::$config['page_item_per_page'];
		
		if($end> GSMS::$config['page_item_per_page'] )
			$end= $end  - $begin;
		
	
		$q=	'' ;
		$q.=		($title == '' ? '' :'`title` like \'%'.$title.'%\'  ') ;
		$q.=	($BeginCreateDate == '' ? '' : ($q!=''? ' and ' : '' ) .'`create_date` >=   \''.$BeginCreateDate.'\'  and `create_date` <= \''.$EndCreateDate.'\'') ;
		
		
		$q.=	($Content =='' ? '' : ($q!=''? ' and ' : '' ) .'`content` like \'%'.$Content.'%\'   ');
		$q.=	($UserId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`user_id`='.$UserId.'   ');
		$q.=	($parentId == -1 ? '' : ($q!=''? ' and ' : '' ) .'`parent_id`='.$parentId.'   ');
		$q.=	($ItemId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`item_id`='.$ItemId.'   ');

		if($accepted == 0 || $accepted == 1)//if 2 show all 
		{
			$q.=	 ($q!=''? ' and ' : '' ) .'`accepted`='.$accepted.'   ' ;
		}
		
		
		$q.=	($ItemType == '' ? '' : ($q!=''? ' and ' : '' ) .'`item_type`=\''.$ItemType.'\'  ');
		if($q!='')
			$q=' where '.$q ;
		
		if($order != '' )
			$q .= ' order by '. $order ; 
		
	
		$tempTicket = R::dispense('ticket');
		$query = 'select * from `ticket`  ';
		$rowCount = count(R::getAll($query.$q ));
		$tempTickets = R::getAll($query.$q. ' limit '.$begin.','.$end);
		
		
		$_SESSION['query_count']= $rowCount;
		$_SESSION['query']= $query;

		if($rowCount>0)
		{
			return array($this->map($tempTickets),$begin,$rowCount);
		}else
		{
			return 0; // no result for query
		}//else
	}//func
	
	public function review($sql,$result_count , $begin=0,$end=30)
	{
		 
		return 0; // no result for query
		 
	}

    public function toString()
	{
		
		if ($this->id==0)
		{
			return $this->title;
		}
		else
		{
			
			 
			return $this->title;
			 
			
			
		}//else
	}//func
	
	private function map($row)
	{
	
		$tempTickets= array();
		$count = count($row);
		for($i = 0 ; $i< $count; $i++ )
		{
			$tempTicket=new ticketModel();
			$tempTicket->id	=$row[$i]['id']	;
			$tempTicket->content	=$row[$i]['content']	;
			$tempTicket->createDate=$row[$i]['create_date'];
			$tempTicket->userId	=$row[$i]['user_id']	;
			$tempTicket->itemId	=$row[$i]['item_id']	;
			$tempTicket->itemType	=$row[$i]['item_type']	;
			$tempTicket->parentId	=$row[$i]['parent_id']	;
			$tempTicket->title		=$row[$i]['title']		;
			$tempTicket->ownerName		=$row[$i]['owner_name']		;
			$tempTicket->accepted	=$row[$i]['accepted']		;
			$tempTicket->readed	=$row[$i]['readed']		;
			$tempTicket->softversion	=$row[$i]['softversion']		;
			$tempTicket->ip	=$row[$i]['ip']		;

			$tempTickets[] = $tempTicket;
		}
		return $tempTickets;
	}

	public function getCount()
	{
		$tempTicket = R::dispense('ticket');
		$row = R::getAll('select count(`id`)as cnt from  `ticket` ');
		return  $row[0]['cnt'];
		
	}//func
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
