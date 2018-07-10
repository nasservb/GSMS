<?php //allahoma sale ala mohammad va ale mohammad
//class contain all admin function on view layer start 4-2-91 by nasser niazy in gooya smslearning system
class index
{
	private $User;
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
		if(!isset(GSMS::$class['template']))
			GSMS::load('template','core');
		$this->User=GSMS::$class['session']->getUser();
	}//fun
	public function logout()
	{
		GSMS::$class['session']->logout();
		GSMS::$class['router']->redirect(GSMS::$siteURL.GSMS::$index);
	}	
	public function index()
	{
		$inf=array('page_title'=>'صفحه ی مدیریت','activeTab'=>'dashboard');
		GSMS::$class['template']->header($inf); 
		GSMS::$class['template']->load($inf,'admin_header');
		$user=GSMS::$class['session']->getUser();
		$body='';
		 
		$body.='
		
		<br/>	
		<div class="row">
			<div class="tools_title">سفارش</div>
			<div class="toolsbox">
				 <a class="btn btn-info  col-md-4 col-md-3" href="'.
						GSMS::$class['template']->info['admin_url'] 
						.'orders/search" ><div id="search"></div>جستجوی سفارش</a>
				<a class="btn btn-info  col-md-4 col-md-3" href="'.
						GSMS::$class['template']->info['admin_url'] 
						.'orders/ordersArchive" ><div id="archive"></div>آرشیو سفارش ها </a>
			</div>
		</div>
		<br/> 
		<div class="row">
			<div class="tools_title">امور مالی</div>			
			<div class="toolsbox">
					<a class="btn btn-info col-md-4 col-md-3"  href="'.GSMS::$class['template']->info['admin_url'] 
						.'accounting/listFactures" ><div id="cats_statistic"></div>مشاهده صورتحساب ها</a>
					<a class="btn btn-info col-md-4 col-md-3"  href="'.GSMS::$class['template']->info['admin_url']  
						.'accounting/listInternetTrans" ><div id="list_admins"></div>لیست تراکنش های اینترنتی </a>
												
			</div>
		</div>
		<br/>
		<div  class="row">
			<div class="tools_title">مدیریت</div>
			<div class="toolsbox">
				<a class="btn btn-info col-md-4 col-md-3" href="services/servicetypelist" ><div id="add_cats"></div>ویرایش سرویس ها</a>
				<a class="btn btn-info col-md-4 col-md-3" href="services/addservice" ><div id="add_cats"></div>ثبت سرویس جدید</a>
			</div>
		</div>			
       <br/>
		<div  class="row">
			<div class="tools_title">مشتریان</div>
			<div class="toolsbox">
				<a class="btn btn-info col-md-4 col-md-3" href="customers/listCustomers" ><div id="list_events"></div>لیست مشتریان</a>
				<a class="btn btn-info col-md-4 col-md-3" href="customers/addCustomer" ><div id="user_create"></div>ثبت مشتری جدید</a>
			</div>
		</div>		 
       <br/>
		<div  class="row">
			<div class="tools_title">مدیران</div>
			<div class="toolsbox">
				<a class="btn btn-info col-md-4 col-md-3" href="customers/editProfile" ><div id="edit_admin"></div>ویرایش پروفایل</a>
				<a class="btn btn-info col-md-4 col-md-3" href="customers/changePassword" ><div id="change_password"></div>تغییر رمز</a> 
			</div>
		</div>
		 ';
		$inf=array('title'=>'امکانات','body'=>$body );
		GSMS::$class['template']->load($inf,'admin_index');
		GSMS::$class['template']->load($inf,'admin_footer');
	}//func index

 
}//class
?>
