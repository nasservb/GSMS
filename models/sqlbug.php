<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all sqlbug functionality on control(controller) layer start 7-2-91 by nasser niazy in gooya smslearning system
class sqlbug 
{
	public $id;
	public $error_code;
	public $describe;
	public $time;
	public $file;
	public $operator_ip;
	public $sql;
	public $message;
	public $read;
	public $username;
 	public function __construct()
	{
		GSMS::$class['system_log']->log('DEBUG','sqlbug started successfull');
	}
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun
	public function getBy_date($startDate,$finishDate)
	{
		GSMS::load('admin','class');
		$id=intval($id);
		if ($id>0)
		{
			$row='';$max=0;
			$query=GSMS::$class['DB']->run('select  * from  `sqlbug` 
									where ((`time`<=\''.$finishDate.'\') and
									(`time`>=\''.$startDate.'\')',
									'sqlbug.php',$row,$max,'select requested sqlbug in date');
			$tempSqlbugs=array();
			if($max>0)
			{
				for($i=0 ;$i<$max;$i++)
				{
					$tempSqlbug=new sqlbug();
					$row=$query[$i];
					$tempSqlbug->id=$row['user_id'];
					$tempSqlbug->error_code=$row['error_code'];
					$tempSqlbug->describe=$row['describe'];
					$tempSqlbug->time=$row['time'];
					$tempSqlbug->file=$row['file'];
					$tempSqlbug->operator_ip=& GSMS::$class['admin']->getAdmin(intval($row['admin_id']));
					$tempSqlbug->sql=$row['sql'];
					$tempSqlbug->message=$row['message'];
					$tempSqlbug->read=($row['user_id']=='yes' ? true:false);
					$tempSqlbug->username=$row['username'];
					$tempSqlbugs[$i]=$tempSqlbug;
				}//for
			}//if
			return $tempSqlbugs;
		}//if
	}//func
	public function listSqlbugs($begin=0,$end=0)
	{
		if($begin>$end )
		{
			GSMS::$class['system_log']->log('debug','the parameter is not recognizable');
			return 17;	//bad parameter send
		}//if

		//alahoma salle ala mohammaden va ale mohammad
		$row='';$max=0;
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];

		GSMS::$class['DB']->run('select  count(*)as cnt from  `sqlbug` ',
							'sqlbug.php',$row,$max,'list bug');
									
		$result_count = $row['cnt'];			
		GSMS::$class['session']->set('query_count',$result_count);
		GSMS::$class['session']->set('query', 'select * from `sqlbug`  ');
		
		
		$query=GSMS::$class['DB']->run('select  * from  `sqlbug` 
							limit '.$begin .','.$end,
							'sqlbug.php',$row,$max,'list bug');
							
							
		$tempSqlbugs=array();
		if($result_count>0)
		{
		
			for($i=0 ;$i<$max;$i++)
			{
				$row=$query[$i];
				$tempSqlbug=new sqlbug();
				$tempSqlbug->id=$row['user_id'];
				$tempSqlbug->error_code=$row['error_code'];
				$tempSqlbug->describe=$row['describe'];
				$tempSqlbug->time=$row['time'];
				$tempSqlbug->file=$row['file'];
				$tempSqlbug->operator_ip= $row['userip'];
				$tempSqlbug->sql=$row['sql'];
				$tempSqlbug->message=$row['message'];
				$tempSqlbug->read=($row['user_id']=='yes' ? true:false);
				$tempSqlbug->username=$row['username'];
				$tempSqlbugs[$i]=$tempSqlbug;
			}//for
			return array($tempSqlbugs,$begin,$result_count);
		}
		else
		{
			return 404;
		}//else
	}//func
	public function getSqlbug($id)
	{
		$id=intval($id);
		if ($id>0)
		{
			$row='';$max=0;
			GSMS::$class['DB']->run('select  * from  `user` where `user_id`='.$id,
							'user.php',$row,$max,'select requested user');
			if($max==1)
			{
				$tempSqlbug=new sqlbug();
				$tempSqlbug->id=$row['user_id'];
				$tempSqlbug->error_code=$row['error_code'];
				$tempSqlbug->describe=$row['describe'];
				$tempSqlbug->time=$row['time'];
				$tempSqlbug->file=$row['file'];
				$tempSqlbug->operator_ip=$row['userip'];
				$tempSqlbug->sql=$row['sql'];
				$tempSqlbug->message=$row['message'];
				$tempSqlbug->read=($row['user_id']=='yes' ? true:false);
				$tempSqlbug->username=$row['username'];
				return $tempSqlbug;
			}else
			return 0;
		}//if
	}//func
	public function toString($id=0)
	{
		if ($id==0)
		{
			return $this->message;
		}
		else
		{
			$row='';$max=0;
			GSMS::$class['DB']->run('select `message` from  `sqlbug` where `sqlbug_id`='.$id,
							'sqlbug.php',$row,$max,'select toString for sqlbug');
			if($max==1)
			{
				return $row['message'];
			}else {
				return 404;
			}//else
		}//else
	}//func
	
	public function getCount()
	{
		$row='';$max=0;
		GSMS::$class['DB']->run('select count(`sqlbug_id`)as cnt from  `sqlbug` ','sqlbug.php',$row,$max,'select getCount for sqlbug');
		return  $row['cnt'];
		
	}//func

}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}