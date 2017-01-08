<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all admin functionality on control(controller) layer start 7-2-91 by nasser niazy in gooya smslearning system
class admin 
{
	
	public $id		;	
	public $name	;			
	public $family	;			
	public $mail	;			
	public $melli	;			
	public $username;			
	public $password;			
	public $description;			
	public $admin_type			;///[1=admin,2=user,3=employ]
	public $mobile				;
	public $insert_date				;
	public $date				;
	public $creator_id				;
	public $icon_picture_id		;
	public $credit				;
	public $home_address		;
	public $home_postal_code	;
	public $home_phone			;
	public $work_address		;
	public $work_phone		;
	public $work_postal_code;	
	public $ostan_id			;	
	public $shahr_id			;	
	public $title			;	
	public $google_x		;	
	public $google_y		;	
	
	public $is_email_notic		;	
	public $is_sms_notic		;	
	public $permission	;
		
 	public function __construct()
	{
		$this->admin_type=0;	
		GSMS::load('log','class');	
		$this->insert_date=GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG','admin class Initialized');
	}//fun
	
	function __set($propertyName,$propertyValue)
	{
		$this->propertyName=$propertyValue;
	}//fun
	
	public function save()
	{
		if($this->id==0)
		{
			$row='';
			$max=0;
			
			GSMS::$class['DB']->run('INSERT INTO `admin` 
							(
								`admin_id` ,
								`name` ,
								`description` ,
								`family`,
								`mail`,
								`melli`,
								`username`,
								`password`,
								`admin_type`,
								`mobile`,
								`date` , 
								`insert_date` , 
								`credit`			,	
								`home_address`		,
								`work_address`		,
								`work_phone`		,
								`home_postal_code`	,
								`home_phone`		, 
								`icon_picture_id`	,
								`creator_id`		,
								`ostan_id`			,
								`shahr_id`			, 
								`google_x`			,
								`google_y`			,
								`work_postal_code`	,  		
								`title`,			
								`permission`,			
								`is_email_notic`,			
								`is_sms_notic` 
							)
							VALUES 
							(
								NULL ,  
								\''.$this->name.'\', 
								\''.$this->description.'\',  
								\''.$this->family.'\',
								\''.$this->mail.'\',
								\''.$this->melli.'\',
								\''.$this->username.'\',
								\''.GSMS::$class['session']->encode($this->password).'\',
								\''.$this->admin_type.'\',
								\''.$this->mobile.'\',
								\''.$this->date.'\',
								\''.$this->insert_date.'\',
								\''.$this->credit				.'\', 
								\''.$this->home_address		.'\', 
								\''.$this->work_address		.'\', 
								\''.$this->work_phone		.'\', 
								\''.$this->home_postal_code	.'\', 
								\''.$this->home_phone			.'\',  
								\''.$this->icon_picture_id		.'\', 
								\''.$this->creator_id				.'\', 
								\''.$this->ostan_id				.'\', 
								\''.$this->shahr_id				.'\',  
								\''.$this->google_x			.'\', 
								\''.$this->google_y			.'\', 
								\''.$this->work_postal_code	.'\',  
								\''.$this->title.'\',
								\''.$this->permission.'\',
								\''.$this->is_email_notic.'\',
								\''.$this->is_sms_notic.'\' 
								)',
							'admin.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'insert admin'	//sql code subject	
							);
			//GSMS::$class['log']->Log('create admin','inserting admin'.$this->name,'admin.php','save');
			return 1;
		}
		else
		{
			$row='';
			$max=0;
			GSMS::$class['DB']->run('UPDATE `admin`
							SET 
								`name`=\''.$this->name.'\', 
								`description`=\''.$this->description.'\',  
								`family`=\''.$this->family.'\',
								`melli`=\''.$this->melli.'\',
								`mail`=\''.$this->mail.'\',
								`admin_type`=\''.$this->admin_type.'\',
								'.(isset($this->password)?
										'`password`=\''.GSMS::$class['session']->encode($this->password).'\',' : '')
								.'`mobile`=\''.$this->mobile.'\',
								`date`=\''.$this->date.'\',
								`insert_date`=\''.$this->insert_date.'\',
								`credit`=\''.$this->credit				.'\',
								`home_address`=\''.$this->home_address		.'\',
								`work_address`=\''.$this->work_address		.'\',
								`work_phone`=\''.$this->work_phone		.'\',
								`home_postal_code`=\''.$this->home_postal_code	.'\',
								`home_phone`=\''.$this->home_phone			.'\',
								`icon_picture_id`=\''.$this->icon_picture_id				.'\',
								`creator_id`=\''.$this->creator_id				.'\',
								`ostan_id`=\''.$this->ostan_id				.'\',
								`shahr_id`=\''.$this->shahr_id				.'\', 
								`google_x`=\''.$this->google_x			.'\',
								`google_y`=\''.$this->google_y			.'\',
								`title`=\''.$this->title	.'\',  
								`permission`=\''.$this->permission	.'\',  
								`work_postal_code`=\''.$this->work_postal_code	.'\',  
								`is_email_notic`=\''.$this->is_email_notic			.'\',
								`is_sms_notic`=\''.$this->is_sms_notic			.'\' 
							WHERE `admin_id` ='.$this->id,
							'admin.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'update admin'	//sql code subject	
							);
			//GSMS::$class['log']->Log('edit admin','updating admin'.$this->name,'admin.php','save');
			return 1;
		}//else
	}//func
	 
	public function searchAdmin(
		$begin=0,
		$end=30,
		$admin_type=2	,///[1=admin,2=user,3=employ]
		$name='',
		$family='',
		$mail='',				
		$melli='',				
		$username='',			
		$description='',		
			
		$mobile='',				
		$BeginCreateDate='',				
		$EndCreateDate='',								
		$home_address='',		
		$work_address='',		
		$home_postal_code='',	
		$work_postal_code='',
		$home_phone='',						
		$work_phone='',						
		 
		$ostan_id='',				
		$shahr_id='',  			 
		$sort=2  //id[1=asc,2=deac]
		
	)
	{
		$row='';
		$max=0;
		if($begin<0 )
			$begin = 0 ; 
		
		if($BeginCreateDate != '' ) 
			$EndCreateDate  = ($EndCreateDate != '' ? $EndCreateDate : GSMS::$class['calendar']->now());
			
		if(intval($begin)==0)
			$begin=0;
			
		if(intval($end)==0 )
			$end=GSMS::$config['page_item_per_page'];
		
		if($end> GSMS::$config['page_item_per_page'] )
			$end= $end  - $begin;	
		
		$q=		($name == '' ? '' :'`name` like \'%'.$name.'%\'  ') ;
		$q.=	($BeginCreateDate == '' ? '' : ($q!=''? ' and ' : '' ) .'`date` >=   \''.$BeginCreateDate.'\'  and `date` <= \''.$EndCreateDate.'\'') ;
		
		
		$q.=	($family				 =='' ? '' : ($q!=''? ' and ' : '' ) 	.'`family` like \'%'	  		.$family			.'%\'   ');
		$q.=	($mail				 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`mail` like \'%'		  		.$mail				 .'%\'   ');
		$q.=	($melli				 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`melli` like \'%'		  		.$melli				 .'%\'   ');
		$q.=	($username			 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`username` like \'%'	  		.$username			 .'%\'   ');
		$q.=	($description			 =='' ? '' : ($q!=''? ' and ' : '' ) 	.'`description` like \'%' 		.$description		.'%\'   ');
		$q.=	($admin_type			 =='0' ? '' : ($q!=''? ' and ' : '' )	.'`admin_type` = \''	  		.$admin_type		.'\'   ');
		$q.=	($mobile				 =='' ? '' : ($q!=''? ' and ' : '' ) 	.'`mobile` like \'%'	  		.$mobile			.'%\'   ');
		$q.=	($home_address		 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`home_address` like \'%'		.$home_address		 .'%\'   ');
		$q.=	($work_address		 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`work_address` like \'%'		.$work_address		 .'%\'   ');
		$q.=	($work_phone		 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`work_phone` like \'%'		.$work_phone		 .'%\'   ');
		$q.=	($home_postal_code	 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`home_postal_code` = \''		.$home_postal_code	 .'\'   ');
		// $q.=	($branch_code			 =='' ? '' : ($q!=''? ' and ' : '' ) 	.'`branch_code` = \''		.$branch_code		.'\'   ');
		// $q.=	($branching_code		 =='' ? '' : ($q!=''? ' and ' : '' ) 	.'`branching_code` = \''	.$branching_code	.'\'   ');
		// $q.=	($sale_point_code		 =='' ? '' : ($q!=''? ' and ' : '' ) 	.'`sale_point_code` = \''	.$sale_point_code	.'\'   ');
		// $q.=	($code				 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`code` = \''				.$code				 .'\'   ');
		$q.=	($ostan_id				 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`ostan_id` = \''			.$ostan_id				 .'\'   ');
		$q.=	($shahr_id				 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`shahr_id` = \''			.$shahr_id				 .'\'   ');
		$q.=	($title				 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`title` like \'%'				.$title				 .'%\'   ');
		$q.=	($work_postal_code	 =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`work_postal_code` like \'%'	.$work_postal_code	 .'%\'   ');
		// $q.=	($seller_branch_code =='' ? '' : ($q!=''? ' and ' : '' ) 		.'`seller_branch_code` = \''.$seller_branch_code .'\'   ');
		
		if($q!='')
			$q=' where '.$q ;
		
		GSMS::$class['DB']->run('select count(*)as cnt from  `admin` '.$q,
								'admin.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'searchAdmin count'	//sql code subject	
								);
		
		$result_count = $row['cnt'];
		
		
		switch ($sort)
		{//						[1=>likeCount,2=>rate,3=>viewCount,4=>commentCount,5=>date_newest,]
			case 0:
					//unsort
					break;
			case 1:
					$q.= ' order by admin_id asc ';
					break;
					
			case 2:
					$q.= ' order by admin_id desc ';
					break;
					
			
		}
	
		
		
		$_SESSION['query_count']= $result_count;
		$_SESSION['query']= 'select * from `admin`  '.$q;

		$row='';
		$max=0;
		
		$tempAdminRows=GSMS::$class['DB']->run('select *  from  `admin` '.$q.' limit '.$begin.','.$end,
								'admin.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'searchAdmin '	//sql code subject	
								);
		
		if($max ==0 )
			return array(array(),$begin,0);
		else 
			return array($this->map($tempAdminRows),$begin,$result_count);
		
	
	}
	public function getAdmin($id)
	{
		$id=intval($id);
		if ($id>0)
		{
			$row='';$max=0;
			GSMS::$class['DB']->run('select * from `admin` where `admin_id`='.$id,
							'admin.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'select requested admin'	//sql code subject	
							);
						
			if($max==1)
			{
				return $this->map(array(0 => $row),false);
			}
			else
				return 0;
		}//if
	}//func
	
	public function getAdminByUsername($username)
	{
		if(strlen($username) < 4 )
		{
			return 0 ; 
			
		}
		$row='';$max=0;
		GSMS::$class['DB']->run('select * from `admin` where `username`=\''.$username."'",
						'admin.php',	//file of code
						$row,			//variable to return first row			
						$max,			//variable to return row count	
						'select requested admin'	//sql code subject	
						);
		
		return $this->map(array(0 => $row),false);
		
		
	}//func
	
	public function getAdminByCode($code)
	{
		$row='';
		$max=0;
		GSMS::$class['DB']->run('select * from `admin` where `code`=\''.$code."'",
						'admin.php',	//file of code
						$row,			//variable to return first row			
						$max,			//variable to return row count	
						'select requested admin'	//sql code subject	
						);
		 
		return $this->map(array(0 => $row),false);
	}//func

	public function changePass($oldpass,$newpass)
	{
		if( GSMS::$class['session']->is_register('login_count')==false)
		{
			GSMS::$class['session']->register('login_count');
			GSMS::$class['session']->set('login_count',0);
		}//if
		$validcount= GSMS::$class['session']->get('login_count'); 
		$validcount++;
		if ($validcount>5) return 309;//	try count is out of max
		if ($oldpass=='' || $newpass=='' )return 500; //insert user and pass
		$row='';$max=0;
		$user=GSMS::$class['session']->getUser();
		GSMS::$class['DB']->run("select * from `admin` where (`username`='".$user['UserName']."')
											and(`password`='".GSMS::$class['session']->encode($oldpass)."')",
											'admin.php',	//	file of code
											$row,			//variable to return first row
											$max,			//variable to return row count
											'check pass');	//code subject
		if($max==0)
		{
			GSMS::$class['session']->set('login_count',$validcount);
			return 303;//dont match by any user pass
		}
		elseif($max>1)
		{
			GSMS::$class['DB']->logsql("select * from `admin` where (`username`='".$user['UserName']."')
													and(`password`='".$oldpass."')",
													"admin.php",		//error_file
													$user['UserID'],	//user_id
													$user['UserName'],	//user_name
													"report injection",	//error_subject
													"",					//error_code
													"");				//error_message
			GSMS::$class['session']->set('login_count',$validcount);
			return 304;	//try to injection
		}
		elseif($max==1)
		{
			$tempAdmin =& admin::getAdmin($user['UserID']);
			$tempAdmin->password=$newpass;
			$tempAdmin->save();
			return 45;//successfull update pass
		}//if
	}//func
	public function toString($id=0)
	{
		if ($id==0)
		{
			return $this->userName;
		}
		else
		{
			$row='';$max=0;
			GSMS::$class['DB']->run('select `username` from  `admin` where `admin_id`='.$id,
							'admin.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'select toString for admin'	//sql code subject	
							);
			if($max==1)
			{
				return $row['username'];
			}
			else 
			{
				return 404;
			}//else
		}//else
	}//func
	
	public function getRow($row)
	{
		$tempAdmin=new admin();
				
		$tempAdmin->id					=$row['admin_id'];
		$tempAdmin->name				=$row['name'];
		$tempAdmin->family				=$row['family'];
		$tempAdmin->mail				=$row['mail'];
		$tempAdmin->melli				=$row['melli'];
		$tempAdmin->username			=$row['username'];
		$tempAdmin->mobile				=$row['mobile'];
		$tempAdmin->admin_type			=$row['admin_type'];
		$tempAdmin->date				=$row['date'];
		$tempAdmin->insert_date			=$row['insert_date'];
		$tempAdmin->description			=$row['description'];
		$tempAdmin->credit				=$row['credit'];
		$tempAdmin->home_address		=$row['home_address'];
		$tempAdmin->work_address		=$row['work_address'] ;
		$tempAdmin->work_phone			=$row['work_phone'] ;
		$tempAdmin->home_postal_code	=$row['home_postal_code'] ;
		$tempAdmin->home_phone			=$row['home_phone'] ;
		// $tempAdmin->porsant				=$row['porsant'] ;
		// $tempAdmin->branch_code			=$row['branch_code'] ;
		// $tempAdmin->branching_code		=$row['branching_code'] ;
		// $tempAdmin->sale_point_code		=$row['sale_point_code'] ;
		// $tempAdmin->code				=$row['code'] ; 
		$tempAdmin->title				=$row['title'] ;
		$tempAdmin->permission			=$row['permission'] ;
		$tempAdmin->google_x			=$row['google_x'] ;
		$tempAdmin->google_y			=$row['google_y'] ;
		$tempAdmin->creator_id 			=$row['creator_id'] ;
		$tempAdmin->icon_picture_id 	=$row['icon_picture_id'] ;
		$tempAdmin->ostan_id 			=$row['ostan_id'] ;
		$tempAdmin->shahr_id 			=$row['shahr_id'] ;
		$tempAdmin->work_postal_code	=$row['work_postal_code'] ;
		// $tempAdmin->primary_pay_value	=$row['primary_pay_value'] ; 
		$tempAdmin->is_email_notic		=$row['is_email_notic'] ; 
		$tempAdmin->is_sms_notic		=$row['is_sms_notic'] ; 
		// $tempAdmin->seller_branch_code	=$row['seller_branch_code'] ; 
		return $tempAdmin;
	}
	
	public function map($res,$multi=true )
	{
		if(count($res)>0  ) 
		{	
			if( $multi==true)
			{
				$tempAdmins =array();
				for($i=0 ;$i<count($res);$i++)
				{
					$tempAdmins[$i] =$this->getRow($res[$i]); 
				}//for
				 
				return $tempAdmins;
			}
			elseif($multi == false )
			{
				return $this->getRow($res[0]);  // no result for query
			}
		}
		else
		{
			return 0 ; 
		}
	}//func

}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
