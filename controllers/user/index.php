<?php //allahoma sale ala mohammad va ale mohammad
//class contain all admin function on view layer start 4-2-91 by nasser niazy in gooya smslearning system
class index
{
    private $User;

    public function __construct()
    {
        if (GSMS::$class['session']->checkLogin() == true) 
		{
			//login
            $this->user = GSMS::$class['session']->getUser();

            if ($this->user['UserType'] == 1) {
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/admin/index");
            } elseif ($this->user['UserType'] == 2) {
                //GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/user/index");
            } else {
                GSMS::$class['session']->logout();
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
            }
        }else{
			//not login
			GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
		}
        if (!isset(GSMS::$class['template']))
            GSMS::load('template', 'core');
    }

    //fun

    public function logout()
    {
        GSMS::$class['session']->logout();
        GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
    }

    public function index()
    {
        $inf = array('page_title' => 'پنل کاربری', 'activeTab' => 'dashboard');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'user_header');
        $user = GSMS::$class['session']->getUser();

        $body  = '
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="card">
					<div class="card-header card-chart" data-background-color="green">
						<div class="ct-chart" id="dailySalesChart"></div>
						سرعت بارگذاری صفحه
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="card">
					<div class="card-header card-chart" data-background-color="orange">
						<div class="ct-chart" id="completedTasksChart">
						 </div>
						میزان بار سرور
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="row"><div class="tools_title">سفارش</div>
			<div class="toolsbox">
			
			
				<div class="col-md-4 col-sm-6"><a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/orderRegister" ><div id="insert"></div> ثبت سفارش جدید</a></div>
				
				<div class="col-md-4 col-sm-6"><a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/allOrders" ><div id="archive"></div>لیست سفارش ها</a></div>
				
				';
						
			 
			$body.='
			
			</div>
		</div><br/>
		
		<div class="row"><div class="tools_title">امورمالی</div>
			<div class="toolsbox">
			
				<div class="col-md-4 col-sm-6"><a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/insertOnMoney" ><div id="list_cats"></div>واریز وجه آنلاین</a></div>
				
				<div class="col-md-4 col-sm-6"><a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/listTransBalance" ><div id="list_admins"></div>لیست تراکنش ها</a></div>
			
			</div>
		</div><br/>';
		 

		 
		 
		$body.='
		<div class="row">
		<div class="tools_title">کاربری</div>
			<div class="toolsbox">
			
				<div class="col-md-4 col-sm-6"><a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'users/configuration" ><div id="configuration"></div>ویرایش پروفایل</a></div> 	
				
				<div class="col-md-4 col-sm-6"><a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'users/change_password" ><div id="change_password"></div>تغییر رمز</a></div> 	
				
				
			
			<br/>
			</div> 	
		 
		</div><br/>
		';
        $inf = array('title' => 'پنل کاربری', 'body' => $body);
        GSMS::$class['template']->load($inf,'site_index');
        GSMS::$class['template']->load($inf,'site_footer');
    }

 
	
}

//class
?>
