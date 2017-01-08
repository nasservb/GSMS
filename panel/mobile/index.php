<?php  //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class index
{
    public function __construct()
    { 
        ini_set('display_errors', 'off'); 
		error_reporting(E_ERROR );

    }
	

    function index()
    {
        $this->listgroup();
    }
     
	public function lastGroup2($begin = 0, $end = 15)
	{
		
		//GSMS::load('visit','class');
		//GSMS::$class['visit']->log('lastGroup2');

		GSMS::load('telgroup','class');
		$tempGroups = GSMS::$class['telgroup']->searchTelgroup(
							$begin,
							$end,
							0,//user
							0,//beginDate
							0,//endDate
						
							0,//cat
							'',//$Title='',
							'',//$Description='',
							'',//$Tag='',
							1,//accept
							'',//ownerMobile
							'',//telegramAddress
							0,//ostan
							0,//shahr
							0,//vip
							5,//sort
							1,//type
							'',1
							);

		echo (json_encode( $tempGroups));
	
	}

	function search($begin = 0, $end = 15)
    {
		
            echo( json_encode(array('for','test')));
         
    }
    function searchTransaction($begin = 0, $end = 15)
    {
		
		$begin = intval(GSMS::$class['input']->post('begin'));
        $end = (isset($_POST['end']) ? GSMS::$class['input']->post('end') :100);
		$user = GSMS::$class['session']->getUser();
		
		$inf['balance'] =
			R::getAll('select b.*,bt.name as balanceTypeName from balance b left join `balance_type` bt on b.balance_type_id=bt.id  '.( $this->user['UserID']>0 ? ' where b.`admin_id`= '. $this->user['UserID'] : '' ) 
				. ' order by b.id desc limit ' .$begin . ','  . $end );
			 		
		$inf['begin'] =$begin; 
		
		$item=R::getAll('select count(b.id)as cnt  from balance b left join `balance_type` bt on b.balance_type_id=bt.id  '.( $this->user['UserID']>0 ? ' where b.`admin_id`= '. $this->user['UserID'] : '' )  ); 
		$inf['count'] = $item[0]['cnt'];
		
        echo (json_encode( $inf));
         
    }
    function insert()
    {
		 GSMS::load('visit','class');
		 $data= substr(GSMS::$class['input']->post('q') . 
				 ' , user = ' . 	GSMS::$class['input']->post('user') . 
				 ' , v = ' . GSMS::$class['input']->post('v')
				 ,0,490);
				
		 GSMS::$class['visit']->log('mobileInsert',$data);
		 

		 
		if(isset($_POST['pass']) && $_POST['pass'] == '1266' )
		{
			GSMS::load("telgroup", "class");
			
			$tempGroup = new telgroup();
			 
			$selectedType  =1;
			switch (GSMS::$class['input']->post('type')) 
			{
				case 'group':$selectedType  =1 ;break;
				case 'id':$selectedType  =2 ;break;
				case 'sticker':$selectedType  =3 ;break;
				case 'robot':$selectedType  =4 ;break;
				case 'channel':$selectedType  =7 ;break;
				case 'ads':$selectedType  =9 ;break;
				case 'order':$selectedType  =11 ;break;
				default:$selectedType  =1 ;break;
			}
			
			if((isset($_POST['isEdit'])) && (GSMS::$class['input']->post('isEdit')== 'true') )
			{
				//$tempGroup =GSMS::$class['telgroup']->getTelgroup(GSMS::$class['input']->post('id'));
				
			}
			
			// if(
				// ($selectedType !=9 && $selectedType !=11 ) && 
				// ($tempGroup->id ==0) && 
				// ($tempGroup->isTelgroupExsist(
					// GSMS::$class['input']->post('address'),
					// GSMS::$class['input']->post('admin')))
					// )
			// {
				// $tempGroup->id =1;
				// $tempGroup->title = "با تشکر از حسن توجه شما . ";
				// $tempGroup->description ="این مورد قبلآ به ثبت رسیده است . با جستجو می توانید آن را پیدا کنید . اگر پیدا نکردید شاید هنوز توسط مدیریت تایید نشده است . ";//chanel
				// $tempGroup->telegramAddress ="";//chanel
				// $tempGroup->ostanId=0;
				// $tempGroup->shahrId=0;
				// $tempGroup->tag="";
				// $tempGroup->memberCount=0;
				// $tempGroup->telgroupCategoryId=0;
				// $tempGroup->telgroupTypeId=1;
				// $tempGroup->isVIP=0;
				// $tempGroup->isSuperGroup=0;
				// $tempGroup->iconPictureId=0;
				
				
			// }
			
			if(
				($tempGroup->id >0) && 
				(GSMS::$class['input']->post('user') != $tempGroup->userId ) 
				)
			{ 
				$tempGroup->id =1;
				$tempGroup->title = "عدم دسترسی ";
				$tempGroup->description ="  در تکرار ویرایش گروه های دیگران بلاک خواهید شد.";
				$tempGroup->telegramAddress ="";//chanel
				$tempGroup->ostanId=0;
				$tempGroup->shahrId=0;
				$tempGroup->tag="";
				$tempGroup->memberCount=0;
				$tempGroup->telgroupCategoryId=0;
				$tempGroup->telgroupTypeId=1;
				$tempGroup->isVIP=0;
				$tempGroup->isSuperGroup=0;
				$tempGroup->iconPictureId=0;
			}
			elseif(($selectedType !=9 && $selectedType !=11 ) && 
			GSMS::$class['input']->post('address') == "" &&   GSMS::$class['input']->post('admin')=="") 
			{ 
				$tempGroup->id =1;
				$tempGroup->title = "با تشکر از حسن توجه شما . ";
				$tempGroup->description ="   اطلاعات ورودی ناقص است  .";
				$tempGroup->telegramAddress ="";//chanel
				$tempGroup->ostanId=0;
				$tempGroup->shahrId=0;
				$tempGroup->tag="";
				$tempGroup->memberCount=0;
				$tempGroup->telgroupCategoryId=0;
				$tempGroup->telgroupTypeId=1;
				$tempGroup->isVIP=0;
				$tempGroup->isSuperGroup=0;
				$tempGroup->iconPictureId=0;
			}
			elseif(GSMS::$class['input']->post('user') == "" &&   GSMS::$class['input']->post('v')=="") 
			{ 
				$tempGroup->id =1;
				$tempGroup->title = "با تشکر از حسن توجه شما . ";
				$tempGroup->description ="  نسخه برنامه خود را ارتقا دهید  .";
				$tempGroup->telegramAddress ="";//chanel
				$tempGroup->ostanId=0;
				$tempGroup->shahrId=0;
				$tempGroup->tag="";
				$tempGroup->memberCount=0;
				$tempGroup->telgroupCategoryId=0;
				$tempGroup->telgroupTypeId=1;
				$tempGroup->isVIP=0;
				$tempGroup->isSuperGroup=0;
				$tempGroup->iconPictureId=0;
			}
			else
			{
				GSMS::load("admin", "class");
				$tempBlockAdmin = GSMS::$class['admin']->getAdmin(GSMS::$class['input']->post('user')) ; 
				
				if( $tempBlockAdmin->is_block > 0  ) 
				{
					$d_arr  = GSMS::$class['calendar']->getdate(strtotime(date("Y-m-d")."-2 days"));
					$expireDate  =  sprintf("%04d-%02d-%02d", $d_arr['year'], $d_arr['mon'], $d_arr['mday']);
					
					if($expireDate >= $tempBlockAdmin->block_date ) 
					{
						$tempBlockAdmin->is_block = 0 ; 
						$tempBlockAdmin->blockdesc = ''; 
						$tempBlockAdmin->save() ; 
					}
					else
					{
						$tempGroup = new telgroup();
			  
						$tempGroup->id =1;
						$tempGroup->title = "عدم دسترسی ";
						 $tempGroup->description =$tempBlockAdmin->blockdesc;
						$tempGroup->telegramAddress ="";//chanel
						$tempGroup->ostanId=0;
						$tempGroup->shahrId=0;
						$tempGroup->tag ="";
						$tempGroup->memberCount=0;
						$tempGroup->telgroupCategoryId=0;
						$tempGroup->telgroupTypeId=1;
						$tempGroup->isVIP=0;
						$tempGroup->isSuperGroup=0;
						$tempGroup->iconPictureId=0;  
						$tempGroup->coverPictureId =0; 
						$tempGroup->userId =  0; 
						$tempGroup->calcRate = 0;
						$tempGroup->isPublic = 1;
						$tempGroup->isDeleted = 0; 
						$tempGroup->likeCount = 0;
						$tempGroup->viewCount = 0;
						$tempGroup->isVIP = 0; 
						$tempGroup->commentCount = 0;
						$tempGroup->softversion	=''; 
						//$tempGroup->createDate  = '1394-12-12';
						//$tempGroup->insertDate  ='1394-12-12':
						$tempGroup->ownerMobile  ='';
						$tempGroup->memberCount =0;
						
						
						
						
						$tempGroupBlock = new telgroup();
						$tempGroupBlock->ostanId=GSMS::$class['input']->post('ostan');
					
						$tempGroupBlock->shahrId=GSMS::$class['input']->post('shahr');
						
						$tempGroupBlock->telgroupCategoryId=GSMS::$class['input']->post('cat') ;
						
						$tempGroupBlock->title = GSMS::$class['input']->post('name');
						$tempGroupBlock->description = GSMS::$class['input']->post('description') ;
						$tempGroupBlock->telegramAddress = GSMS::$class['input']->post('address');
						
						$tempGroupBlock->tag = GSMS::$class['input']->post('tag');
						
						$tempGroupBlock->userId =  GSMS::$class['input']->post('user');
						$tempGroupBlock->isAccepted = 0;
						$tempGroupBlock->calcRate = 0;
						$tempGroupBlock->isPublic = 1;
						$tempGroupBlock->isDeleted = 0;
						$tempGroupBlock->isSuperGroup =( GSMS::$class['input']->post('isSupper')=='true' ? 1 : 0);
						$tempGroupBlock->coverPictureId = 0;
						$tempGroupBlock->iconPictureId =0;
						$tempGroupBlock->likeCount = 0;
						$tempGroupBlock->viewCount = 0;
						$tempGroupBlock->isVIP = 0;
						$tempGroupBlock->telgroupTypeId = $selectedType;
						 
						$tempGroupBlock->commentCount = 0;
						$tempGroupBlock->softversion	= intval(GSMS::$class['input']->post('v')) ;
						
						$tempGroupBlock->createDate  =  GSMS::$class['calendar']->date('Y-m-d');
						$tempGroupBlock->insertDate  = GSMS::$class['calendar']->date('Y-m-d');
						$tempGroupBlock->ownerMobile  = GSMS::$class['input']->post('admin');
						$tempGroupBlock->memberCount  = intval(GSMS::$class['input']->post('member'));
						
						$tempGroupBlock->save();
					}					
				}
				
				if( $tempBlockAdmin->is_block == 0  ) 
				{
					$iconId =0;
					if (isset($_FILES)) 
					{
						
						
						$fileName = $_FILES['fileUpload']['name'];
						if (!file_exists(GSMS::$tempDir . $fileName)) 
						{

							if (move_uploaded_file($_FILES['fileUpload']['tmp_name'], GSMS::$tempDir . $fileName)) 
							{
								GSMS::load("calendar", "lib");
								GSMS::load("filesystem", "lib");
								
								$path = GSMS::$config['photo_archive_path']. DIRECTORY_SEPARATOR;
								
								$user=GSMS::$class['session']->getUser();
								
								$path .= $user['UserName'] . DIRECTORY_SEPARATOR;
								$pathDB  = $user['UserName'] . DIRECTORY_SEPARATOR;
								
								if (!file_exists($path))
									mkdir($path, 0755);	
								
								$path .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
								$pathDB .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
								
								if (!file_exists($path))
									mkdir($path, 0755);
									
								$path .= 'images' . DIRECTORY_SEPARATOR;
								$pathDB .= 'images'  . DIRECTORY_SEPARATOR;
								
								if (!file_exists($path))
									mkdir($path, 0755);
								
								$new_fileName = GSMS::$class['filesystem']->sanitize($fileName,true,true);
							
								$new_path = $new_fileName;
								while(file_exists( $path .$new_path))
								{
									$new_path = rand() . $new_fileName ; 
								}
								$tempPicture =R::dispense('picture');
								$tempPicture->title = GSMS::$class['input']->post('title');
								$tempPicture->description = GSMS::$class['input']->post('description');
								$tempPicture->picturePath = $pathDB . $new_path.'.jpg';
								$tempPicture->createDate = GSMS::$class['calendar']->now();
								//$tempPicture->userId = $user['UserID'];
								$tempPicture->itemId = $group_id;
								$tempPicture->itemType = 'groupIcon';
								$iconId = R::store($tempPicture );
								rename(GSMS::$tempDir . $fileName,$path .$new_path.'.jpg');
							}
						}	
					
					
					}
				
					$tempGroup->ostanId=GSMS::$class['input']->post('ostan');
					
					$tempGroup->shahrId=GSMS::$class['input']->post('shahr');
					
					$tempGroup->telgroupCategoryId=GSMS::$class['input']->post('cat') ;
					
					$tempGroup->title = GSMS::$class['input']->post('name');
					$tempGroup->description = GSMS::$class['input']->post('description') ;
					$tempGroup->telegramAddress = GSMS::$class['input']->post('address');
					
					$tempGroup->tag = GSMS::$class['input']->post('tag');
					
					$tempGroup->userId =  GSMS::$class['input']->post('user');
					$tempGroup->isAccepted = 1;
					$tempGroup->calcRate = 0;
					$tempGroup->isPublic = 1;
					$tempGroup->isDeleted = 0;
					$tempGroup->isSuperGroup =( GSMS::$class['input']->post('isSupper')=='true' ? 1 : 0);
					$tempGroup->coverPictureId = (($tempGroup->id ==0) ? 0 :intval($tempGroup->coverPictureId));
					$tempGroup->iconPictureId = ( $iconId !=0  ? $iconId  :intval($tempGroup->iconPictureId));
					$tempGroup->likeCount = (($tempGroup->id ==0) ? 0 :intval($tempGroup->likeCount));
					$tempGroup->viewCount = (($tempGroup->id ==0) ? 0 :intval($tempGroup->viewCount));
					$tempGroup->isVIP = (($tempGroup->id ==0) ? 0 :intval($tempGroup->isVIP));
					$tempGroup->telgroupTypeId = $selectedType;
					 
					$tempGroup->commentCount = (($tempGroup->id ==0) ? 0 :intval($tempGroup->commentCount));
					$tempGroup->softversion	=((isset($_POST['v'])) ?  intval(GSMS::$class['input']->post('v')) : '12' ) ;
					
					$tempGroup->createDate  =  GSMS::$class['calendar']->date('Y-m-d');
					$tempGroup->insertDate  = GSMS::$class['calendar']->date('Y-m-d');
					$tempGroup->ownerMobile  = GSMS::$class['input']->post('admin');
					$tempGroup->memberCount  = intval(GSMS::$class['input']->post('member'));
					
					$tempGroup->save();
					
					
				}
				
			}
			
			echo (json_encode(array($tempGroup))) ; 
			
			return;
		}
		
		
		echo( json_encode(array(100,'access denied')));
    }

	function insertComment($itemId=0)
	{
		GSMS::load('visit','class');
		GSMS::$class['visit']->log('mobileInsertComment','itemId='.$itemId);
		
		if(isset($_POST['pass']) && $_POST['pass'] == '1266')
		{		
			GSMS::load('comment','class');
			$tempComment = new comment();
			if (GSMS::$class['input']->post('type') == '')
			{
				$tempComment->name=GSMS::$class['input']->post('name');
			}
			else 
			{
				$name = explode(' ', GSMS::$class['input']->post('name'));
				///خواندن ادمین از جدول
				$tempComment->name= $name[0];
				GSMS::load('telgroup','class');
				
				$inf=GSMS::$class['telgroup']->getTelgroup($itemId);
				$inf->commentCount =intval($inf->commentCount)+1;
			
				$inf->save();
			}
			
			$tempComment->email= GSMS::$class['input']->post('mobile');
			
			$tempComment->content= GSMS::$class['input']->post('text');
			$tempComment->createDate= GSMS::$class['calendar']->now();
			$tempComment->itemId=  $itemId;

			$tempComment->softversion= intval(GSMS::$class['input']->post('v'));
			$tempComment->userId= GSMS::$class['input']->post('user');
			$type = 'contact';
			switch(intval(GSMS::$class['input']->post('type') ))
			{
				case 0 : $type = 'contact';break;
				case 1 : $type = 'telgroup';break;
				case 2 : $type = 'telid';break;
				case 3 : $type = 'telsticker';break;
				case 4 : $type = 'telrobot';break;
				case 7 : $type = 'telchannel';break;
				case 9 : $type = 'ads';break;
				case 10: $type = 'comment';break;
			}
			$tempComment->itemType=$type;
			$tempComment->save();
			echo( json_encode(array(1,'success')));
		}
		echo( json_encode(array(100,'access denied')));
	}
		 
    public function getComments($itemId)
	{
		GSMS::load('telgroup','class');
		GSMS::load('comment','class');
		
		GSMS::load('visit','class');
		GSMS::$class['visit']->log('mobileGetComments','itemId='.$itemId);
		
		if (isset($_POST['pass']) && $_POST['pass'] == '1266')
		{
			$inf= GSMS::$class['comment']->searchComment(
						'',//$Name='',
						'',//$BeginCreateDate='',
						'',//$EndCreateDate='',
						$itemId,//=0,
						'',//$ItemType='', 
						'',//$Content='',
						0,//$UserId=0,
						0,//$begin=0,
						30,//$end=0,
						0//$accepted=0
						);

			echo json_encode($inf);
		}
		else 
		{
			echo( json_encode(array(100,'access denied')));
		}
	}

	 
	public function lastGroup($begin = 0, $end = 15)
	{
		 GSMS::load('visit','class'); 
		 GSMS::$class['visit']->log('mobileLastGroup' );
		if (isset($_POST['pass']) && $_POST['pass'] == '1266')
		{
			//$r =rand(1,2); 
			$r =2; 
			if ($r == 2)
			{		
			
				GSMS::load('telgroup','class');
				$tempGroups = GSMS::$class['telgroup']->searchTelgroup(
								$begin,
								$end,
								0,//user
								0,//beginDate
								0,//endDate
							
								0,//cat
								'',//$Title='',
								'',//$Description='',
								'',//$Tag='',
								1,//accept
								'',//ownerMobile
								'',//telegramAddress
								0,//ostan
								0,//shahr
								0,//vip
								5,//sort
								1,//type
								'',//ownerId
								1//ismobile
								);
			
				GSMS::load("planRegistered", "class");
				$ads =  GSMS::$class['planRegistered']->getAdsGroup('view_in_site_main' , 5) ; 
				$p =count($ads);
				for($i=0;$i<$p;$i++)
				{
					array_push( $tempGroups[0],$ads[$i]);	
				}	
				 $temp = new telgroup(); 
				$temp->title=" 	 برنامه نسخه جدید رایگان استیکر";
				//$temp->description="  نسخه کامل برنامه رو از بازار بخرید.  با نام ' جستجو در تلگرام'جستجو کنید . با نماد قرمز رنگ     ";
				$temp->description=" این نسخه بزودی از کار می افتد .کلمه 'جستجو در تلگرام '  را در برنامه بازار جستجو کنید .";
				$temp->ownerId = "نسخه کامل با سوپر گروه ، کانال ، ویرایش گروه و کانال ، استیکر ، ربات ، آی دی  گروه و کانال ویژه با گرافیک بسیار بالا   ";
				
				$temp->telegramAddress ="https://telegram.me/joinchat/BwkjnzvToXVkpso9xHLRdg";//chanel
				$temp->ostanId=0;
				$temp->shahrId=0;
				$temp->tag="این نسخه دیگر امکان درج گروه ندارد .";
				$temp->memberCount=70;
				$temp->telgroupCategoryId=0;
				$temp->telgroupTypeId=1;
				
				//array_push( $tempGroups[0],$temp);
				 $tempGroups[0][0]=$temp;
				
				echo (json_encode( $tempGroups));
			}
			else 
			{
				 $temp = new telgroup(); 
				$temp->title=" 	 برنامه نسخه جدید رایگان ";
				//$temp->description="  نسخه کامل برنامه رو از بازار بخرید.  با نام ' جستجو در تلگرام'جستجو کنید . با نماد قرمز رنگ     ";
				$temp->description=" این نسخه دیگر پشتیبانی نمی شود .کلمه 'جستجو در تلگرام '  را در برنامه بازار جستجو کنید .";
				$temp->ownerId = "نسخه کامل با سوپر گروه ، کانال ، ویرایش گروه و کانال ، استیکر ، ربات ، آی دی  گروه و کانال ویژه با گرافیک بسیار بالا   ";
				// $temp->title="برنامه مشکل نداره  ";
				// $temp->description="  اگه گروه ها باز نمیشه نسخه تلگرامتون رو بروز کنید  ";
				// $temp->ownerId = "اگرهم با نسخه قدیمی آدرس گروهتون رو درج کنید افرادی که تلگرام جدید دارن نمی تونن برن داخل گروه";
				//$temp->telegramAddress ="https://telegram.me/joinchat/BwkjnwKqUPKuWIhzaqzUgw";
				$temp->telegramAddress ="https://telegram.me/joinchat/BwkjnzvToXVkpso9xHLRdg";//chanel
				$temp->ostanId=0;
				$temp->shahrId=0;
				$temp->tag="نسخه جدید را رایگان از بازار دریافت کنید . ";
				$temp->memberCount=70;
				$temp->telgroupCategoryId=0;
				$temp->telgroupTypeId=1;
				echo (json_encode( array(array($temp),1,1)));
			}
		}
	}
	
	 
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}