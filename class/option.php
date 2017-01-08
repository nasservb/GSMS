<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all category functionality on control(controller) layer start 24-7-93 by nasser niazy in gooya smslearning system
class option 
{
	public $id;
	public $key;
	public $value;

    /**
     *
     */
    public function __construct()
	{
		
		GSMS::$class['system_log']->log('DEBUG','option class Initialized');
	}//fun
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun
	public function save()
	{
		$user=GSMS::$class['session']->getUser();
		if($this->id==0)
		{
			$row='';
			$max=0;
			
				GSMS::$class['DB']->run('INSERT INTO `option` 
							(					
							`option_id`,			
							`key`	,		
							`value`				
							)
							VALUES 
							(
								NULL , 
								\''.$this->key.'\', 
								\''.$this->value.'\' 
								)',
							'option.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'insert option'	//sql code subject	
							);
			}
			else 
			{
							
				GSMS::$class['DB']->run('UPDATE `option`
							SET 	
								
								`key`	=\''.$this->key.'\',
								`value`=\''. $this->value.'\'	
							WHERE `option_id` ='.$this->id,
							'option.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'update option'	//sql code subject	
							);
			}
			
		
			return 1;
		
	}//func
	// you not able to see someone who have not your child!
	public function list_options( $begin=0,$end=0)
	{
		
		$row='';
		$max=0;
		 
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		 
		$q_count=GSMS::$class['DB']->run('select count(*)as cnt from `option`'  , 
								'option.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'list option '	//sql code subject	
								);	
								
		
		$query=GSMS::$class['DB']->run('select * from `option`   order by `request_id` desc limit '.$begin.','. $end , 
								
								'option.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'list option '	//sql code subject	
								);
		$tempOptions=array();
		
		if( $q_count[0]['cnt']>0)
		{
			for($i=0 ;$i<$max;$i++)
			{
				$tempOption=new option();
				$row=$query[$i];
				$tempOption->id=$row['option_id'];
				$tempOption->key=$row['key'];
				$tempOption->value=$row['value'];
				
				$tempOptions[$i] = $tempOption;
			}//for
			return array( $tempOptions,$begin, $q_count[0]['cnt']);
		}else
		{
			return 404; // no result for query
		}//else
	}//func
	
	public function get_optionsByKey($key, $begin=0,$end=0)
	{
		
		$row='';
		$max=0;
		 
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		 
		$q_count=GSMS::$class['DB']->run('select count(*)as cnt from `option` where `key`=\''. $key  . '\'', 
								'option.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'list option  by key'	//sql code subject	
								);	
								
		
		$query=GSMS::$class['DB']->run('select * from `option` where `key`= \''. $key . '\'  order by `option_id` desc limit '.$begin.','. $end , 
								
								'option.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'list option '	//sql code subject	
								);
		$tempOptions=array();
		
		if( $q_count[0]['cnt']>0)
		{
			for($i=0 ;$i<$max;$i++)
			{
				$tempOption=new option();
				$row=$query[$i];
				$tempOption->id=$row['option_id'];
				
				$tempOption->key=$row['key'];
				$tempOption->value=$row['value'];
				
				$tempOptions[$i] = $tempOption;
			}//for
			return array( $tempOptions,$begin, $q_count[0]['cnt']);
		}else
		{
			return 404; // no result for query
		}//else
	}//func
	
	public function get_optionsByValue($value, $begin=0,$end=0)
	{
		
		$row='';
		$max=0;
		 
		if(intval($begin)==0)$begin=0;
		if(intval($end)==0 )$end=GSMS::$config['page_item_per_page'];	
		 
		$q_count=GSMS::$class['DB']->run('select count(*)as cnt from `option` where `value`=\''. $value  . '\'', 
								'option.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'list option  by key'	//sql code subject	
								);	
								
		
		$query=GSMS::$class['DB']->run('select * from `option` where `key`= \''. $key . '\'  order by `option_id` desc limit '.$begin.','. $end , 
								
								'option.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'list option '	//sql code subject	
								);
		$tempOptions=array();
		
		if( $q_count[0]['cnt']>0)
		{
			for($i=0 ;$i<$max;$i++)
			{
				$tempOption=new option();
				$row=$query[$i];
				$tempOption->id=$row['option_id'];
				
				$tempOption->key=$row['key'];
				$tempOption->value=$row['value'];
				
				$tempOptions[$i] = $tempOption;
			}//for
			return array( $tempOptions,$begin, $q_count[0]['cnt']);
		}else
		{
			return 404; // no result for query
		}//else
	}//func
	
	public function get_option($id)
	{
		$id=intval($id);
		GSMS::load('admin','class');	
		if ($id>0)
		{
			$row='';$max=0;
			GSMS::$class['DB']->run('select * from `option` where `option_id`='.$id ,
							'option.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'select option '	//sql code subject	
							);
			if($max==1)
			{
				$tempOption=new option();
				$tempOption->id=$row['option_id'];
				$tempOption->key=$row['key'];
				$tempOption->value=$row['value'];

				return ( $tempOption );

			}else
				return 404;
		}//if
	}//func

	public function toString($id=0)
	{
		if ($id==0)
		{
			return $this->value;
		}
		else
		{
			$row='';$max=0;
			GSMS::$class['DB']->run('select `value` from  `option` where `option_id`='.$id,
							'option.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'select toString for option'	//sql code subject	
							);
			if($max==1)
			{
				return $row['value'];
			}else {
				return 404;
			}//else
		}//else
	}//func
	
	public function del_option($id)
	{
	
		$row='';$max=0;
		GSMS::$class['DB']->run('delete  from  `option` where `option_id`='.$id,
						'option.php',	//file of code
						$row,			//variable to return first row			
						$max,			//variable to return row count	
						'del option'	//sql code subject	
						);

	}//func

	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
