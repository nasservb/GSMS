<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all photo functionality on control(controller) layer start 24-7-93 by nasser niazy
class comment
{
	public $id;
	public $content;
	public $createDate;
	public $userId;
	public $itemId;
	public $itemType;
	public $parentId;
	public $name;
	public $email;
	public $accepted;
	public $readed;
	public $softversion;
	public $ip;

 	public function __construct()
	{
		GSMS::load('log','class');	
		$this->id=0;
        $this->accepted=0;
        $this->readed=0;
		$user=GSMS::$class['session']->getUser();
		$this->userId=$user['UserID'];
		$this->CreateDate=GSMS::$class['calendar']->now();
		$this->ip=GSMS::$class['input']->ip_address();
		GSMS::$class['system_log']->log('DEBUG','comment class Initialized');
	}//fun
	
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun

	public function save()
	{
		$tempComment = R::dispense('comment');
		if($this->id != 0)
		{
			list($tempComment) = R::load('comment',$this->id);
		}
		
		$tempComment->content	=$this->content	;
		$tempComment->createDate=$this->createDate;
		$tempComment->userId	=$this->userId	;
		$tempComment->itemId	=$this->itemId	;
		$tempComment->itemType	=$this->itemType	;
		$tempComment->parentId	=$this->parentId	;
		$tempComment->name		=$this->name		;
		$tempComment->email		=$this->email		;
		$tempComment->accepted	=$this->accepted	;
		$tempComment->readed	=$this->readed		;
		$tempComment->softversion	=$this->softversion		;
		$tempComment->ip	=$this->ip		;

		$this->id = R::store( $tempComment );
		
	}//func
	
	public function listComments($begin=0,$end=0)
	{

        $tempComments = R::dispense('comment');
		
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		
		$query='select * from `comment` ';
		$rowCount = count(R::getAll($query));
		$tempComments = R::getAll($query . ' limit '. $begin . ','. $end);
		
		if(count($tempComments)>0)
		{			
			return array($this->map( tempComments),$begin,$rowCount );
		}else
		{
			return 0; // no result for query
		}//else
	}//func
	
	public function getComment($id)
	{
		$id=intval($id);
		if ($id>0)
		{
			$tempComment = R::dispense('comment');
			$tempComment = R::load('comment',$id);
			$newComment = new comment();
			
			$newComment->id		=$tempComment->id	;
			$newComment->content		=$tempComment->content	;
			$newComment->createDate	=$tempComment->createDate;
			$newComment->userId		=$tempComment->userId	;
			$newComment->itemId		=$tempComment->itemId	;
			$newComment->itemType		=$tempComment->itemType	;
			$newComment->parentId		=$tempComment->parentId	;
			$newComment->name			=$tempComment->name		;
			$newComment->email		=$tempComment->email	;
			$newComment->accepted		=$tempComment->accepted	;
			$newComment->readed		=$tempComment->readed	;
			$newComment->softversion		=$tempComment->softversion	;
			$newComment->ip		=$tempComment->ip	;
			
			return $newComment;
			
		}//if
		return 0;
	}//func
	
	public function deleteComment($id=0)
	{
	
		$id=intval($id);
		if($id==0)
			$id= $this->id;
			
		if ($id>0)
		{
			$tempComment = R::dispense('comment');
			$tempComment = R::exec('delete   from `comment` where `id`='.$id);
			
			return 1;
		}//if
		return 0;
	}//func

	public function listCommentsByItem(
					$item,
					$itemType,
					$accepted=0,
					$begin=0,
					$end=0)
	{
		return $this->searchComment(
							'',//title
							'',//date_begin
							'',//date_end
							$item,//item
							$itemType,//ItemType
							'',//describe
							0,//user
							$begin,
							$end,
                            $accepted);
	}
	
	public function listCommentsByUser(
					$user,
                    $accepted=0,
					$begin=0,
					$end=30)
	{

        if(GSMS::$class['session']->checkAdmin())
        {
            return $this->listComments($begin,$end);
        }
        else
        {
            return $this->searchComment(
                '',//title
                '',//date_begin
                '',//date_end
                0,//item
                '',//ItemType
                '',//describe
                $user,
                $begin,
                $end,
                $accepted);
        }

	}
	
	public function searchComment(
					$Name='',
					$BeginCreateDate='',
					$EndCreateDate='',
					$ItemId=0,
					$ItemType='', 
					$Content='',
					$UserId=0,
					$begin=0,
					$end=0,
                    $accepted=0)
	{

		if($BeginCreateDate != '' ) 
			$EndCreateDate  = ($EndCreateDate != '' ? $EndCreateDate : GSMS::$class['calendar']->now());
			
		if(intval($begin)==0)
			$begin=0;
			
		if(intval($end)==0 )
			$end=GSMS::$config['page_item_per_page'];
		
	
		$q=	'' ;
		$q.=		($Name == '' ? '' :'`name` like \'%'.$Name.'%\'  ') ;
		$q.=	($BeginCreateDate == '' ? '' : ($q!=''? ' and ' : '' ) .'`create_date` >=   \''.$BeginCreateDate.'\'  and `create_date` <= \''.$EndCreateDate.'\'') ;
		
		
		$q.=	($Content =='' ? '' : ($q!=''? ' and ' : '' ) .'`Content` like \'%'.$Content.'%\'   ');
		$q.=	($UserId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`user_id`='.$UserId.'   ');
		$q.=	($ItemId == 0 ? '' : ($q!=''? ' and ' : '' ) .'`Item_Id`='.$ItemId.'   ');

		if($accepted == 0 || $accepted == 1)//if 2 show all 
		{
			$q.=	 ($q!=''? ' and ' : '' ) .'`accepted`='.$accepted.'   ' ;
		}
		
		
		$q.=	($ItemType == '' ? '' : ($q!=''? ' and ' : '' ) .'`Item_Type`=\''.$ItemType.'\'  ');
		if($q!='')
			$q=' where '.$q ;
	
		$tempComment = R::dispense('comment');
		$query = 'select * from `comment`  ';
		$rowCount = count(R::getAll($query.$q ));
		$tempComments = R::getAll($query.$q. ' limit '.$begin.','.$end);
		
		
		$_SESSION['query_count']= $rowCount;
		$_SESSION['query']= $query;

		if($rowCount>0)
		{
			return array($this->map($tempComments),$begin,$rowCount);
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

    public function toString()
	{
		
		if ($this->id==0)
		{
			return $this->name;
		}
		else
		{
			
			switch($this->itemType) 
			{
				case 'telgroup' :
					GSMS::load('telgroup', 'class');
					$tempGroup = GSMS::$class['telgroup']->getTelgroup($this->itemId) ; 
					
					return $tempGroup->title;
					break;
				case '': 
					return $this->name;
					break;
			}
			
			
		}//else
	}//func
	
	private function map($row)
	{
	
		$tempComments= array();
		$count = count($row);
		for($i = 0 ; $i< $count; $i++ )
		{
			$tempComment=new comment();
			$tempComment->id	=$row[$i]['id']	;
			$tempComment->content	=$row[$i]['content']	;
			$tempComment->createDate=$row[$i]['create_date'];
			$tempComment->userId	=$row[$i]['user_id']	;
			$tempComment->itemId	=$row[$i]['item_id']	;
			$tempComment->itemType	=$row[$i]['item_type']	;
			$tempComment->parentId	=$row[$i]['parent_id']	;
			$tempComment->name		=$row[$i]['name']		;
			$tempComment->email		=$row[$i]['email']		;
			$tempComment->accepted	=$row[$i]['accepted']		;
			$tempComment->readed	=$row[$i]['readed']		;
			$tempComment->softversion	=$row[$i]['softversion']		;
			$tempComment->ip	=$row[$i]['ip']		;

			$tempComments[] = $tempComment;
		}
		return $tempComments;
	}

	public function getCount()
	{
		$tempComment = R::dispense('comment');
		$row = R::getAll('select count(`id`)as cnt from  `comment` ');
		return  $row[0]['cnt'];
		
	}//func
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
