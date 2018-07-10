<?php 

class ticket
{
	private $user;
	
	private $level; 
	
 	public function __construct()
	{
		$this->user = GSMS::$class['session']->getUser();
		if ($this->user['UserType'] == 1) 
		{
			$this->level= 'admin';
		} 
		elseif ($this->user['UserType'] == 2) 
		{
			$this->level= 'user';
		}
		elseif ($this->user['UserType'] == 3) 
		{
			$this->level= 'employ';
		}
		
		GSMS::load('ticketModel', 'plugins','ticket');
		
		
		if (! array_key_exists('ticket',GSMS::$class['template']->info['employ_main_menu']))
		{
		
			GSMS::$class['template']->info['employ_main_menu']['ticket'] = array(
												'tab'=>'tickets',
												'url'=>'ticket',
												'icon'=>'call',
												'title'=>'تیکت پشتیبانی',
											);
			
			GSMS::$class['template']->info['admin_main_menu']['ticket'] = array(
												'tab'=>'tickets',
												'url'=>'ticket',
												'icon'=>'call',
												'title'=>'تیکت پشتیبانی',
											);
			
			GSMS::$class['template']->info['user_main_menu']['ticket'] = array(
											'tab'=>'tickets',
											'url'=>'ticket',
											'icon'=>'call',
											'title'=>'تیکت پشتیبانی',
										);
		}							
		

		
	}
	
	
	public function install () 
	{
		//init db
		$q= 'CREATE TABLE `ticket` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8,
  `create_date` varchar(20) CHARACTER SET latin1 NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `owner_name` text CHARACTER SET utf8,
  `title` text CHARACTER SET utf8,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_type` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `accepted` tinyint(11) NOT NULL DEFAULT \'0\',
  `readed` tinyint(4) NOT NULL DEFAULT \'0\',
  `softversion` int(11) UNSIGNED DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
';

		try
		{
			$row='';
			$max=0;
			GSMS::$class['DB']->run($q,
							'ticket.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'describe `ticket`'	//sql code subject	
							);
		}
		catch (Exception $e)
		{
			$row='';
			$max=0;
			GSMS::$class['DB']->run($q,
							'ticket.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							$q  	//sql code subject	
							);
		}		
	}
	
	public function uninstall () 
	{
		//remove db
	}
	
	public function active () 
	{
		//
	}
	
	
	public function deactive () 
	{
		//
	}
	
	function index()
	{
		$this->listTickets();
	}
	
	function deleteTicket($id)
    {
		if($id < 1)
		{
			GSMS::$class['template']->message('خطا در حذف تیکت','پارامتر به درستی مقدار دهی نشده است .',$this->level,
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		
		
		
		$tempTicket = new ticketModel();
		$tempTicket = $tempTicket->getTicket($id);
		
		if(!is_object($tempTicket) || $tempTicket->id < 1)
		{	
			GSMS::$class['template']->message('مشاهده تیکت','تیکت وجود ندرد.',$this->level,
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		
		if($tempTicket->userId != $this->user['UserID'] && $this->user['UserType'] == 2  )
		{
			GSMS::$class['template']->message('خطا در حذف تیکت','تیکت متعلق به کاربر دیگری است  .',$this->level,
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		
		
        if( !$tempTicket->deleteComment())
        {
			 $body = '<div dir="rtl" class="alert alert-warning"> تیکت یافت نشد.</div>';
           
        }
		else
		{
			$body = '<div dir="rtl" class="alert alert-info">تیکت با موفقیت حذف شد .</div>';
            
		}
		 
		GSMS::$class['template']->message('حذف تیکت', $body ,$this->level,'' , false ,false , array('activeTab'=>'tickets'));
		 
    }
	
	function viewTicket($id)
    {
		if($id < 1)
		{
			GSMS::$class['template']->message('خطا در نمایش تیکت','پارامتر به درستی مقدار دهی نشده است .',$this->level,
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		
		
		$tempTicket = new ticketModel();
		
		$tempTicket = $tempTicket->getTicket($id);
		
		if(!is_object($tempTicket) || $tempTicket->id < 1)
		{	
			GSMS::$class['template']->message('مشاهده تیکت','تیکت وجود ندرد.',$this->level,
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		
		if($tempTicket->userId != $this->user['UserID'] && $this->user['UserType'] ==2  )
		{
			GSMS::$class['template']->message('خطا در دسترسی تیکت','تیکت متعلق به کاربر دیگری است  .',$this->level,
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		
		
        if(isset($_POST['ticket_id']))
		{
			GSMS::load('admin','models'); 
			
			$admin = new admin();
			$admin = $admin->getAdmin($this->user['UserID']);
			
			$parentTicket =$tempTicket->getTicket($id);
				
			if(is_object($parentTicket))
			{
				$parentTicket->readed= 2;  
				$parentTicket->save(); 
			}
			
			
			$newTicket = new ticketModel();
            $newTicket->ownerName= $admin->getFullName();
            $newTicket->title= $admin->title;
            $newTicket->content= GSMS::$class['input']->post('content');
            
            
            $newTicket->userId= $this->user['UserID'];
            $newTicket->parentId= $id ;
            $newTicket->itemType= 'ticket';
            $newTicket->save();
			
			GSMS::$class['template']->message(
				'پاسخ به تیکت' ,
				'پاسخ شما با موفقیت ثبت شد.' , 
				$this->level,
				'alert alert-success col-lg-4 col-md-4 col-sm-6 pull-right',
				array('activeTab' => 'tickets'));
		}
		else
		{
			
			$inf['level'] = $this->level;			
			$inf['ticket'] = $tempTicket;
			$inf['response'] =$tempTicket->listTicketsByParent($id,-1); 
			
			if($tempTicket->readed == 0)
				$tempTicket->readed= 1;
			$tempTicket->save(); 
			
			GSMS::load('viewTicket', 'plugins' , 'ticket/views', $inf);
		}
    }
	
	function listTickets($begin = 0, $end = 30)
    {
       
		$tempTicket = new ticketModel();
		
		$inf['level'] = $this->level;
		
		$userId = ($this->user['UserType'] == 2 ? $this->user['UserID'] : 0);
        
		//admin can view all ticket
		$inf['tickets'] = $tempTicket->searchTicket(
					$begin,
					$end,
					'',//$Name=
					'',//$BeginCreateDate=
					'',//$EndCreateDate=
					0,//$ItemId=
					'', //$ItemType=
					'',//$Content=
					$userId,//$UserId=
                    2);//$accepted=0
		
        GSMS::load('listTickets', 'plugins', 'ticket/views', $inf);

    }
	
	
	function insertTicket() 
    {
        if(!isset($_POST['submit'])) // free result
        {
             GSMS::load('insertTicket', 'plugins', 'ticket/views',array('level'=> $this->level)); 
        }
        else
        {
            $tempTicket = new ticketModel();
            $tempTicket->title= GSMS::$class['input']->post('title');
            
            $tempTicket->content= GSMS::$class['input']->post('content');
            
            $tempTicket->itemId=  0;
			
            if(isset($_POST['parent_id']))		
			{			
				GSMS::load('admin','models');		
				$admin = new admin();
				$admin = $admin->getAdmin($this->user['UserID']);
			
				$tempTicket->ownerName=$admin->getFullName();
				$tempTicket->parentId=  GSMS::$class['input']->post('parent_id');
			}	
            $tempTicket->userId= $this->user['UserID'];
            $tempTicket->itemType= 'ticket';
            $tempTicket->save();

			
            $body = 'تیکت شما با موفقیت ذخیره شد .   به زودی کارشناسان ما به آن پاسخ خواهند داد .'; 
			GSMS::$class['template']->message(
							'درج تیکت پشتیبانی' ,		//title
							$body,					//body
							$this->level,					//part
							'alert alert-success',	//css class
							true,					//format output
							false,						//back link
							array('activeTab'=>'ticket')); //extra argument 
							
        }

    }

	
}