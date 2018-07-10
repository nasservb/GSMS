<?php //allahoma sale ala mohammad va ale mohammad 

class users
{
	private $user;
	
	public function __construct()
    {
		if (GSMS::$class['session']->checkLogin() == false){
			//not login
            GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
		} else {
			$this->user = GSMS::$class['session']->getUser();
			if ($this->user['UserType'] == 1) {
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/admin/index");
            } elseif ($this->user['UserType'] == 2) 
			{
				//
			}
			else {
                GSMS::$class['session']->logout();
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
            }
		}
        GSMS::load('template', 'core');
        GSMS::$class['system_log']->log('DEBUG', 'admin class started successfull');  
    }

    function index()
    {
		
        $body=' <a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'users/configuration" ><i class="material-icons">build</i>ویرایش پروفایل</a></td>
				
				 <a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'users/change_password" ><i class="material-icons">vpn_key</i>تغییر رمز</a></td>
				 <a class="btn btn-danger" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'index/logout" ><i class="material-icons">exit_to_app</i>خروج</a>	';
						
		GSMS::$class['template']->message('پروفایل کاربری'  ,$body,'user',"",false,false,array('activeTab'=>'profile')); 
		
    }
	
	public function uploadAjaxFile()
    {
        ini_set('file_uploads', 'On');
		ini_set('post_max_size', '20M');
		ini_set('upload_max_filesize', '20M');

        if (isset($_FILES)) {
			$fileName = $_FILES['file']['name'];
			if (move_uploaded_file($_FILES['file']['tmp_name'], GSMS::$tempDir . $fileName)) 
			{
				GSMS::load("calendar", 'libs');
				GSMS::load("filesystem", 'libs');

				$path = GSMS::$config['photo_archive_path'] . DIRECTORY_SEPARATOR;

				$user = GSMS::$class['session']->getUser();

				$user_name = GSMS::$class['filesystem']->sanitize($user['UserName'], true, true);
				$path .= $user_name . DIRECTORY_SEPARATOR;
				$pathDB = $user_name . DIRECTORY_SEPARATOR;

				if (!file_exists($path))
					mkdir($path, 0755);

				$path .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;
				$pathDB .= GSMS::$class['calendar']->date('y_m_d') . DIRECTORY_SEPARATOR;

				if (!file_exists($path))
					mkdir($path, 0755);

				$file_type_arr = explode('.',$fileName );
				$file_type = $file_type_arr[count($file_type_arr)-1];
				
				$new_path =  rand(100,100000) . '.'. $file_type;                     

				$date = GSMS::$class['calendar']->now();

				$pathDB .= $new_path;
				 
				rename(GSMS::$tempDir . $fileName, $path .$new_path);

				GSMS::load('picture', 'models');

				$picture = new picture();

				$picture->Title= '#';
				$picture->CreateDate= $date;
				$picture->PicturePath= $pathDB;
				$picture->Description = 'user file in '. $date . 'by : '. $user['UserName'];
				$picture->UserId=$user['UserID'];
				$picture->ItemId=0;
				$picture->ItemType='groupIconTemp'; 
				$picture->save(); 
			} else {
				exit("فایل قابل کپی برداری نیست");

			}
           
        } else {
            exit("تصویر نامفهوم است");
        }
    }
	
    //func
    function configuration()
    {		
		$user = GSMS::$class['session']->getUser();
		$adminid=$user['UserID']; 
        GSMS::load('admin', 'models');
		
        if (!isset($_POST['title']) ) 
		{           
			$tempOstan = R::dispense('ostan');
			$inf['ostan'] = R::getAll('select * from ostan ');
			
            $inf['admin'] =GSMS::$class['admin']->getAdmin($adminid);
			
            GSMS::load('configuration', 'user_view', 'users', $inf);
        } 
		else 
		{
			GSMS::load('picture', 'models');
			$picId=0;
			$picture = new picture();
			$pics = $picture->listUserTempPictures(0,0,$this->user['UserID']);
			if(is_array($pics) && count($pics)>0)
			{
				$tempRes = R::getAll('select * FROM `picture` WHERE `Item_type` = \'groupIcon\' and `user_id`='.$this->user['UserID']);
				foreach($tempRes as $resValue)
				{
					$path=GSMS::$config['photo_archive_path'].$resValue['picture_path'];
					@unlink($path);
				}
				R::exec('Delete FROM `picture` WHERE `Item_type` = \'groupIcon\' and `user_id`='.$this->user['UserID']);
				$picture = $pics[0];
				$pics[0]->Title =  'تصویر نشانه تجاری:';
				$pics[0]->Description =  'تصویر نشانه تجاری:'.$this->user['UserID'];
				$pics[0]->ItemType = 'groupIcon';
				$picId = $pics[0]->Id;
				$pics[0]->save();
			}
			
			$user = GSMS::$class['session']->getUser();
			
			
			$tempAdmin =GSMS::$class['admin']->getAdmin($adminid);
			
			$tempAdmin->title= GSMS::$class['input']->post('title');
			$tempAdmin->name= GSMS::$class['input']->post('name');
			$tempAdmin->family= GSMS::$class['input']->post('family');
			$tempAdmin->mail= GSMS::$class['input']->post('mail');
			$tempAdmin->melli= GSMS::$class['input']->post('melli');
			//$tempAdmin->username= GSMS::$class['input']->post('mail');
			$tempAdmin->mobile= GSMS::$class['input']->post('mobile'); 
			
			list($y,$m,$d)= explode('/',GSMS::$class['input']->post('createDate'));
			$tempAdmin->date  = sprintf("%04d-%02d-%02d", $y, $m, $d);
			
			$tempAdmin->icon_picture_id = $picId;
			$tempAdmin->description= GSMS::$class['input']->post('description');
			$tempAdmin->ostan_id = GSMS::$class['input']->post('ostan');
			$tempAdmin->shahr_id = GSMS::$class['input']->post('shahr');
			//$tempAdmin->credit =0 ; 				
			$tempAdmin->home_address =  GSMS::$class['input']->post('homeAddress');		
			$tempAdmin->work_address =  GSMS::$class['input']->post('workAddress');		
			$tempAdmin->work_phone = GSMS::$class['input']->post('workPhone');			
			$tempAdmin->home_postal_code=GSMS::$class['input']->post('homePostal');	
			$tempAdmin->home_phone = GSMS::$class['input']->post('homePhone');			
			//$tempAdmin->porsant	=GSMS::$class['input']->post('porsant');			
			//$tempAdmin->code	=GSMS::$class['input']->post('code');			
			$tempAdmin->branch_code	=0;		
			$tempAdmin->branching_code	=0;	
			$tempAdmin->sale_point_code	=0;	
			$tempAdmin->creator_id = $user['UserID'];							
			//$tempAdmin->admin_type =5;				
			$tempAdmin->area='';				
			$tempAdmin->google_x='';			
			$tempAdmin->google_y='';			
			$tempAdmin->work_postal_code = GSMS::$class['input']->post('workPostal');		
			$tempAdmin->primary_pay_value =0;
			
			$smsNotic = GSMS::$class['input']->post('is_sms_notic');
			if($smsNotic)
				$tempAdmin->is_sms_notic=1;
			$emailNotic = GSMS::$class['input']->post('is_email_notic');
			if($emailNotic)
				$tempAdmin->is_email_notic=1;
			
					
			$tempAdmin->agent_id=GSMS::$class['input']->post('agent_id');		
			$tempAdmin->marketer_id=GSMS::$class['input']->post('marketer_id');		
			$tempAdmin->advisor_id=GSMS::$class['input']->post('advisor_id');		
			$tempAdmin->seller_branch_code=0;
			
			$pos = GSMS::$class['input']->post('google_position');
			$pos =str_replace('(','',$pos);
			$pos =str_replace(')','',$pos);
			list($x,$y) = explode(',',$pos); 
			$tempAdmin->google_x= floatval($x);
			$tempAdmin->google_y=floatval($y);
			//$tempAdmin->save();
            $tempAdmin->name = GSMS::$class['input']->post('name');
            $tempAdmin->family = GSMS::$class['input']->post('family'); //family
            $tempAdmin->mail = GSMS::$class['input']->post('mail');
            $tempAdmin->userName = GSMS::$class['input']->post('username');
            $tempAdmin->describe = GSMS::$class['input']->post('describe');
            $tempAdmin->mobile = GSMS::$class['input']->post('mobile');
            $tempAdmin->adminType = 2;
            $result = $tempAdmin->save();
			
			
			unset($tempAdmin);
			GSMS::$class['template']->message('ویرایش پروفایل','پروفایل با موفقیت ویرایش شد','user',
			'alert alert-success col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'profile'));
			return ;
        }
        //if
    }
    
	//func
    function profile()
    {
		
		$user = GSMS::$class['session']->getUser();
		$adminid=$user['UserID']; 
        GSMS::load('admin', 'models');
		
        if (!isset($_POST['submit']) ) 
		{           
            $tempAdmin =GSMS::$class['admin']->getAdmin($adminid);
			
            GSMS::load('profile', 'user_view', 'users', $tempAdmin);

        } 
		else 
		{ 
			$tempAdmin = GSMS::$class['admin']->getAdmin(GSMS::$class['input']->post('admin_id'));
            $tempAdmin->name = GSMS::$class['input']->post('name');
            $tempAdmin->family = GSMS::$class['input']->post('family'); //family
            $tempAdmin->mail = GSMS::$class['input']->post('mail');
            $tempAdmin->userName = GSMS::$class['input']->post('username');
            $tempAdmin->description = GSMS::$class['input']->post('describe');
            $tempAdmin->mobile = GSMS::$class['input']->post('mobile');
            $tempAdmin->adminType = 2;

            $result = $tempAdmin->save();
			
			/*
            $inf = array('page_title' => 'ویرایش پروفایل');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'ویرایش پروفایل');
            GSMS::$class['template']->panel_header($inf);
			*/
			unset($tempAdmin);
            if ($result == 1)
			{
                //$body = '<div class="message-success"> پروفایل با موفقیت ویرایش شد';
				GSMS::$class['template']->message('ویرایش پروفایل','پروفایل با موفقیت ویرایش شد','user',
				'alert alert-success col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'profile'));
				return ;
            }
			else
			{
                //$body = '<div class="message-warning">پروفایل ویرایش نشد';
				GSMS::$class['template']->message('ویرایش پروفایل','پروفایل ویرایش نشد','user',
				'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'profile'));
				return ;
			}

            /*$body .= '<br><a class="back_btn" href="' .  GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => ' ویرایش پروفایل', 'body' => $body);
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
			*/
            
        }
        //if
    }
	
	//func
    function change_password()
    {
        $oldpass = GSMS::$class['input']->post('oldpass');
        GSMS::load('admin', 'models');
        if ($oldpass == '') 
		{
            GSMS::load('change_password', 'user_view', 'users');
        } 
		else 
		{
			/*
            $inf = array('page_title' => 'ویرایش رمز عبور');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'صفحه ی مدیریت ');
            GSMS::$class['template']->panel_header($inf);
			*/
            //--------------------------------------------
            $oldpass = GSMS::$class['input']->post('oldpass');
            $newpass = GSMS::$class['input']->post('newpass');
            $newpass2 = GSMS::$class['input']->post('newpass_again');
			
            if ($newpass == '' || $newpass2 == '' || $oldpass == '') 
			{
				GSMS::$class['template']->message('ویرایش مدیر','یکی از رمز ها وارد نشده است','user',
					'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'profile'));
				return ;
            }
            if ($newpass != $newpass2) 
			{
				GSMS::$class['template']->message('ویرایش مدیر','رمز ها با هم طابق نیستند','user',
					'alert alert-danger col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'profile'));
				return ;
            }
            //if
            $result = GSMS::$class['admin']->changePass($oldpass, $newpass);
			//var_dump($result);
            switch ($result) 
			{
                case 309:
                    $body = '<div class="alert alert-danger">تعداد تلاش مجاز شما تمام شده</div>';
                    break;
                case 500:
                    $body = '<div class="alert alert-danger">نام کاربر یا رمز عبور مقداردهی نشده</div>';
                    break;
                case 303:
                    $body = '<div class="alert alert-danger">رمز عبور صحیح نیست</div>';
                    break;
                case 304:
                    $body = '<div class="alert alert-danger">زمان دیگری تلاش کنید </div>';
                    break;
                case 45:
                    $body = '<div class="alert alert-success">رمز با موفقیت ویرایش شد</div>';
                    break;
            }
			GSMS::$class['template']->message('ویرایش مدیر', $body,'user',
				'col-lg-4 col-md-4 col-sm-6 pull-right',true, false, array('activeTab' => 'profile'));
			return ;
            //swithc
            //$body .= '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] .'">برگشت</a>';
        }
        //if
    }
    

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
