<?php //allahoma sale ala mohammad va ale mohammad 
//class admin for all administrator managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system
class customers 
{
	
 	public function __construct()
	{
		 if (GSMS::$class['session']->checkLogin() == true) 
		 {
            $this->user = GSMS::$class['session']->getUser();

            if ($this->user['UserType'] == 1) 
			{
                //GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/admin/index");
            } elseif ($this->user['UserType'] == 2) 
			{
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/user/index");
            } elseif ($this->user['UserType'] == 3) 
			{
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/employ/index");
            } 
        }
		else 
		{
			GSMS::$class['session']->logout();
			GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
		}
		GSMS::load('template','core');
		GSMS::$class['system_log']->log('DEBUG','admins class started successfull');
	}
	
	public function index()
	{
		$body = ' 
		<a class="btn btn-info col-md-4 col-md-3" href="'.GSMS::$class['template']->info['admin_url'].'customers/addCustomer">ثبت مشتری جدید  </a>  
		<a class="btn btn-info col-md-4 col-md-3" href="'.GSMS::$class['template']->info['admin_url'].'customers/listCustomers">لیست مشتریان </a>
		
		
		<a class="btn btn-info col-md-4 col-md-3" href="'.GSMS::$class['template']->info['admin_url'].'customers/addEmployer" >ثبت کارمند جدید</a>
		<a class="btn btn-info col-md-4 col-md-3" href="'.GSMS::$class['template']->info['admin_url'].'customers/listEmployer" >لیست کارمندان</a>
					
		<a class="btn btn-info col-md-4 col-md-3" href="'.GSMS::$class['template']->info['admin_url'].'customers/editProfile"> ویرایش پروفایل </a> 
		<a class="btn btn-info col-md-4 col-md-3" href="'.GSMS::$class['template']->info['admin_url'].'customers/changePassword">  تغییر رمزعبور </a> 
		' ;
		
		GSMS::$class['template']->message('مشتریان',$body,'admin','',false ,false , array('activeTab'=>'customers'));
	}//fun
	
	public function editProfile()
	{ 
		$user = GSMS::$class['session']->getUser();
        $adminid=$user['UserID'];     
		
		GSMS::load('admin','models');
		if(!isset($_POST['name']))
		{
			
			$tempAdmin =GSMS::$class['admin']->getAdmin($adminid);
			GSMS::load('edit_profile','admin_view','customers',$tempAdmin);
			
		}
		else
		{
			$tempAdmin = GSMS::$class['admin']->getAdmin($this->user['UserID']);
			$tempAdmin->name= GSMS::$class['input']->post('name');
			$tempAdmin->family=GSMS::$class['input']->post('family');//family
			$tempAdmin->mail=GSMS::$class['input']->post('mail');
			$tempAdmin->description=GSMS::$class['input']->post('describe');
			$tempAdmin->mobile=GSMS::$class['input']->post('mobile');
	
			$result=$tempAdmin->save(); 
			$body='';
			if($result==1)
			{
				$body='پروفایل با موفقیت ویرایش شد';
				GSMS::$class['template']->message('ویرایش پروفایل',$body,'admin',
				'alert alert-success col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'customers'));			
			}
			else
			{
				$body='پروفایل ویرایش نشد';
				GSMS::$class['template']->message('ویرایش پروفایل',$body,'admin',
				'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'customers'));			
			}
			unset($tempAdmin);
		}//if
	}//func
	
	public function changePassword()
	{
		$oldpass = GSMS::$class['input']->post('oldpass');
		GSMS::load('admin','models');
		if($oldpass=='')
		{
			GSMS::load('change_password','admin_view','customers');
		}
		else
		{
			$body =	'';
			$oldpass=GSMS::$class['input']->post('oldpass');
			$newpass=GSMS::$class['input']->post('newpass');
			$newpass2=GSMS::$class['input']->post('newpass_again');
			if($newpass=='' || $newpass2=='' || $oldpass=='')
			{
				$body ='یکی از رمز ها وارد نشده است';
				
				GSMS::$class['template']->message('تغییر رمز',$body,'admin',
				'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
				return;
			 
			}
			if($newpass!=$newpass2)
			{
				$body ='رمز ها با هم مطابق نیستند<br>'; 
				GSMS::$class['template']->message( 'تغییر رمز',$body,'admin',
				'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
				return;
			}//if
			$result= GSMS::$class['admin']->changePass($oldpass,$newpass);
			switch ($result)
			{
				case 309:$body='تعداد تلاش مجاز شما تمام شده';break;
				case 500:$body='نام کاربر یا رمز عبور مقداردهی نشده';break;
				case 303:$body='رمز عبور صحیح نیست';break;
				case 304:$body='زمان دیگری تلاش کنید ';break;
				case 45:$body='رمز با موفقیت ویرایش شد';break;
			}//swithc  
			GSMS::$class['template']->message(' تغییر رمز' ,$body,'admin',
			'alert alert-'.($result == 45 ? 'success': 'danger'),true, false, array('activeTab' => 'tickets'));
			return; 
		}//if
	}//func
	
	public function addCustomer()
	{
		$username = GSMS::$class['input']->post('username');
		if($username=='')
		{	
			//free result
			GSMS::load('create_user','admin_view','customers');
		}
		else
		{
			if(strlen($username) < 4 )
			{		
				$body=' طول نام کاربری کمتر از حد مجاز مجاز است .' ; 
				GSMS::$class['template']->message( 'تعریف مشتری جدید',$body,'admin', 'alert alert-warning'); 
				return; 
			}
			
			GSMS::load('admin','models');
			$tempAdmin=new admin();
			$tempAdmin2=$tempAdmin->getAdminByUsername(GSMS::$class['input']->post('username'));
			
			if(is_object($tempAdmin2 )&&  $tempAdmin2->id>0)
			{
				$body=' مشتری دیگری با این نام کاربری وجود دارد    '; 
				GSMS::$class['template']->message( 'تعریف مشتری جدید',$body,'admin', 'alert alert-warning'); 
				return; 
			}
			
			$tempAdmin->name= GSMS::$class['input']->post('name');
			$tempAdmin->family=GSMS::$class['input']->post('family');//family
			$tempAdmin->description=GSMS::$class['input']->post('describe');
			
			$tempAdmin->mail=GSMS::$class['input']->post('mail');
			$tempAdmin->username=GSMS::$class['input']->post('username');
			$tempAdmin->password=GSMS::$class['input']->post('pass');
			$tempAdmin->admin_type=2;
			

			$tempAdmin->mobile=GSMS::$class['input']->post('mobile');
			$tempAdmin->date=GSMS::$class['calendar']->now();
			
			$result=$tempAdmin->save();
			
			if($result==1)
				$body='
				<div class="alert alert-success">
				مشتری با موفقیت درج شد'.
						' </div>';
			else
				$body='
				<div class="alert alert-danger">
				مشتری درج نشد'.
					' </div>'; 
					
			GSMS::$class['template']->message('تعریف مشتری جدید' ,$body,'admin', '',false); 			
			unset($tempAdmin);
			return; 
		}
	}//func
	
	public function editCustomer($adminid)
	{
		//$name = GSMS::$class['input']->post('name');
		if($adminid < 1)
			return ;
		GSMS::load('admin','models');
		$tempAdmin=GSMS::$class['admin']->getAdmin($adminid);
		if(!is_object($tempAdmin) || $tempAdmin->id < 1)
		{	
			GSMS::$class['template']->message('ويرايش مشتری','مشتری وجود ندرد.','admin',
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		if(!isset($_POST['submit']))
		{
			$tempOstan = R::dispense('ostan');
			$inf['ostan'] = R::getAll('select * from ostan ');
			
            $inf['admin'] =$tempAdmin;			

			GSMS::load('edit_user','admin_view','customers',$inf);
		}
		else
		{
			//$tempAdmin= GSMS::$class['admin']->getAdmin($adminid);
			$tempAdmin->name= GSMS::$class['input']->post('name');
			$tempAdmin->family=GSMS::$class['input']->post('family');//family
			$tempAdmin->mail=GSMS::$class['input']->post('mail');
			$tempAdmin->description=GSMS::$class['input']->post('describe');
			$tempAdmin->mobile=GSMS::$class['input']->post('mobile');
			
			
			$result=$tempAdmin->save();
			$body= '';
			if($result==1)
				$body='<div class="alert alert-success">مشتری با موفقيت ويرايش شد</div>';
			else
				$body='<div class="alert alert-warning">مشتری ويرايش نشد</div>';					
			 			
			GSMS::$class['template']->message('ویرایش مشتری',$body,'admin', '',false); 
			unset($tempAdmin);
			return; 
		}//if
	}//func
	
	public function viewCustomer($adminid)
	{
		if($adminid < 1)
			return ;
		GSMS::load('admin','models');
		$tempAdmin=GSMS::$class['admin']->getAdmin($adminid);
		if(!is_object($tempAdmin) || $tempAdmin->id < 1)
		{	
			GSMS::$class['template']->message('نمایش اطلاعات مشتری','مشتری وجود ندرد.','admin',
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		
		GSMS::load('view_user','admin_view','customers',$tempAdmin);
	}
	
	public function listCustomers($begin=0,$end=0)
	{ 
		GSMS::load('admin','models');		
		$tempAdmins = GSMS::$class['admin']->searchAdmin($begin,$end,2);		
		
		GSMS::load('list_users','admin_view','customers',$tempAdmins);
		
	}//func
	
	public function listEmployer($begin=0,$end=30)
	{
		GSMS::load('admin','models');	
		 
		$tempEmployers = (new admin())->getAllEmployers($begin, $end);
		GSMS::load('list_admin','admin_view','customers',$tempEmployers);
	}//func
	
	public function addEmployer()
	{
		$username = GSMS::$class['input']->post('username');
		if($username=='')
		{	
			//free result
			$info['part'] =R::getAll('select * from order_type'); 
			GSMS::load('create_admin','admin_view','customers',$info );
		}
		else
		{
			$inf=array('page_title'=>'تعریف کاربر جدید','activeTab'=>'customers');
			GSMS::$class['template']->header($inf); 
			GSMS::$class['template']->load($inf,'admin_header');
			
			if(strlen($username) < 4 )
			{		
				$body='<div class="alert alert-warning">طول نام کاربری کمتر از حد مجاز مجاز است .'.
						'</div><br><a class="btn btn-primary" href="'.GSMS::$class['template']->info['admin_url'].'/customers/addEmployer">برگشت</a>';
				$inf=array('title'=>'تعریف کاربر جدید','body'=>$body,'activeTab'=>'customers');
				
				GSMS::$class['template']->load($inf,'admin_index');
				GSMS::$class['template']->load($inf,'admin_footer');
				return;
			}
			
			GSMS::load('admin','models');
			$tempAdmin=new admin();
			$tempAdmin2=$tempAdmin->getAdminByUsername(GSMS::$class['input']->post('username'));
			
			if(is_object($tempAdmin2 )&&  $tempAdmin2->id>0)
			{
				$body='<div class="alert alert-warning">کاربر دیگری با این نام کاربری وجود دارد   '.
						'</div><a class="btn btn-primary" href="'.GSMS::$class['template']->info['admin_url'].'/customers/addEmployer">برگشت</a>';
				$inf=array('title'=>'تعریف کاربر جدید','body'=>$body,'activeTab'=>'customers');
				GSMS::$class['template']->load($inf,'admin_index');
				GSMS::$class['template']->load($inf,'admin_footer');
				return;
			}
			
			$tempAdmin->name= GSMS::$class['input']->post('name');
			$tempAdmin->family=GSMS::$class['input']->post('family');//family
			$tempAdmin->description=GSMS::$class['input']->post('describe');
			
			$tempAdmin->permission=implode(",", GSMS::$class['input']->post('permission_list'));
			$tempAdmin->permission=(intval($tempAdmin->permission)==0 ? 0 : $tempAdmin->permission);
			
			$tempAdmin->mail=GSMS::$class['input']->post('mail');
			$tempAdmin->username=GSMS::$class['input']->post('username');
			$tempAdmin->password=GSMS::$class['input']->post('pass');
			$tempAdmin->admin_type=GSMS::$class['input']->post('user_type');
			

			$tempAdmin->mobile=GSMS::$class['input']->post('mobile');
			$tempAdmin->date=GSMS::$class['calendar']->now();
			$prms=GSMS::$class['input']->post('permission_list');
			$prmSt = '0,';
			foreach($prms as $prmsValue )
			{
				$prmSt .= $prmsValue . ',';
			}
			$prmSt = substr($prmSt, 0, strlen($prmSt)-1);
			$tempAdmin->permission = $prmSt;
			//var_dump($tempAdmin);
			//return ;
			$result=$tempAdmin->save2();
			
			
			//$tempAdmin->save();
			
			if($result==1)
				$body='
				<div class="alert alert-success">
				کاربر با موفقیت درج شد'.
						'<br>
						</div>';
			else
				$body='
				<div class="alert alert-danger">
				کاربر درج نشد'.
				'<br></div><a class="btn btn-primary" href="'.GSMS::$class['template']->info['admin_url'].'">برگشت</a>';
			GSMS::$class['template']->message('تعریف کارمند جدید' ,$body,'admin', '',false);
			unset($tempAdmin);
			return ;
		}//if
	}//func

	public  function editEmployer($adminid)
	{
		if($adminid < 1)
			return ;
		GSMS::load('admin','models');
		$tempAdmin=GSMS::$class['admin']->getAdmin($adminid);
		if(!is_object($tempAdmin) || $tempAdmin->id < 1)
		{	
			GSMS::$class['template']->message('ويرايش کارمند','کارمند وجود ندرد.','admin',
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'tickets'));
			return;
		}
		if(!isset($_POST['submit']))
		{
			$info['tempAdmin'] = $tempAdmin;
			$info['part'] =R::getAll('select * from order_type'); 
			GSMS::load('edit_admin','admin_view','customers',$info);
		}
		else
		{
			//$tempAdmin= GSMS::$class['admin']->getAdmin($adminid);
			$tempAdmin->name= GSMS::$class['input']->post('name');
			$tempAdmin->family=GSMS::$class['input']->post('family');//family
			$tempAdmin->mail=GSMS::$class['input']->post('mail');
			$tempAdmin->description=GSMS::$class['input']->post('describe');
			$tempAdmin->mobile=GSMS::$class['input']->post('mobile');
			$tempAdmin->admin_type=GSMS::$class['input']->post('user_type');
			
			$prms=GSMS::$class['input']->post('permission_list');
			$prmSt = '0,';
			foreach($prms as $prmsValue )
			{
				$prmSt .= $prmsValue . ',';
			}
			$prmSt = substr($prmSt, 0, strlen($prmSt)-1);
			$tempAdmin->permission = $prmSt;
			
			$result=$tempAdmin->save();
			$body= '';
			if($result==1)
				$body='<div class="alert alert-success">کارمند با موفقيت ويرايش شد</div>';
			else
				$body='<div class="alert alert-warning">مشتری ويرايش نشد</div>';					
			 			
			GSMS::$class['template']->message('ویرایش کارمند',$body,'admin', '',false); 
			unset($tempAdmin);
			return; 
		}//if
	}
	
	public function viewEmployer($adminid)
	{
		if($adminid < 1)
			return ;
		GSMS::load('admin','models');
		$tempAdmin=GSMS::$class['admin']->getAdmin($adminid);
		if(!is_object($tempAdmin) || $tempAdmin->id < 1)
		{	
			GSMS::$class['template']->message('نمایش اطلاعات کارمند','کارمند وجود ندارد.','admin',
			'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',false, false, array('activeTab' => 'tickets'));
			return;
		}
		$info['tempAdmin'] = $tempAdmin;
		$info['part'] =R::getAll('select * from order_type'); 
		GSMS::load('view_admin','admin_view','customers',$info);
	}
	
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
