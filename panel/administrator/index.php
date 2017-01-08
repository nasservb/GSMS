<?php //allahoma sale ala mohammad va ale mohammad
//class contain all admin function on view layer start 4-2-91 by nasser niazy in gooya smslearning system
class index
{
    private $User;

    public function __construct()
    {
        if (GSMS::$class['session']->checkLogin() == false) 
		{
            $this->user = GSMS::$class['session']->getUser();

            if ($this->user['UserType'] == 1) {
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/admin/index");
            } elseif ($this->user['UserType'] == 2) {
                //GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/user/index");
            } else {
                GSMS::$class['session']->logout();
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
            }
        }
        if (!isset(GSMS::$class['template']))
            GSMS::load('template', 'lib');
    }

    //fun

    public function logout()
    {
        GSMS::$class['session']->logout();
        GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
    }

    public function index()
    {
        $inf = array('page_title' => 'پنل کاربری');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->panel_header($inf);
        $user = GSMS::$class['session']->getUser();

        $body  = '
		<div class="tools"><div class="tools_title">امکانات اصلی</div>
			<div class="toolsbox">
			<table dir="rtl"><tr>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/registerOrder" ><div id="insert"></div> ثبت سفارش جدید</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/newOrders" ><div id="list_group"></div>لیست سفارش های جدید</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/currentOrders" ><div id="run"></div>لیست سفارش های در دست اجرا </a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/prevOrders" ><div id="archive"></div>لیست سفارش های قبلی </a></td>
				';
						
// 				 <td align="center"><a class="tools_link" href="'.
// 						GSMS::$class['template']->info['user_url'] 
// 						.'orders/searchRegister" ><div id="configuration"></div>جستجوی سفارش</a></td>
				 
			$body.='</tr></table>
			<br/>
			</div>
		</div><br/>
		
		<div class="tools"><div class="tools_title">حسابداری</div>
			<div class="toolsbox">
			<table dir="rtl"><tr>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/insertOnMoney" ><div id="list_cats"></div>واریز وجه آنلاین</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/insertReceipt" ><div id="add_cats"></div>ثبت فیش بانکی</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url']
				.'accounting/listReceipt" ><div id="requests"></div>لیست فیش های واریزی </a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/listTransBalance" ><div id="list_admins"></div>لیست تراکنش های مالی </a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/listFactures" ><div id="cats_statistic"></div>مشاهده صورتحساب ها</a></td>
				
			</tr></table>
			<br/>
			</div>
		</div><br/>';
		 
		
// 		<div class="tools"><div class="tools_title">پشتیبانی</div>
// 			<div class="toolsbox">
// 			<table dir="rtl"><tr>
// 				<td align="center"><a class="tools_link" href="'.
// 						GSMS::$class['template']->info['user_url'] 
// 						.'advisor/insertAdvisor" ><div id="add_cats"></div>ثبت درخواست پشتیبانی</a></td>
// 				<td align="center"><a class="tools_link" href="'.
// 						GSMS::$class['template']->info['user_url'] 
// 						.'advisor/insertAdvisor" ><div id="list_accept"></div>لیست درخواست های قبلی</a></td>
// 				<td align="center"><a class="tools_link" href="'.
// 						GSMS::$class['template']->info['user_url'] 
// 						.'advisor/listAdvisor" ><div id="add_store"></div>مشاهده آنلاین سفارش</a></td>
// 				<td align="center"><a class="tools_link" href="'.
// 						GSMS::$class['template']->info['user_url'] 
// 						.'advisor/statistic" ><div id="user_photos"></div>امتیاز دهی به عملکرد پشتیبانی</a></td>
// 				
// 			</tr></table>
// 			<br/>
// 			</div>
// 		</div><br/>
		 
		 
		$body.='<div class="tools"><div class="tools_title">کاربری</div>
			<div class="toolsbox">
			<table dir="rtl"><tr>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'admins/configuration" ><div id="configuration"></div>تنظیمات</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'admins/edit_admin" ><div id="edit_admin"></div>ویرایش پروفایل</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'admins/change_password" ><div id="change_password"></div>تغییر رمز</a></td>
				<td align="center"><a class="tools_link" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'index/logout" ><div id="logout_photo"></div>خروج</a></td>	
				
			</tr></table>
			<br/>
			</div>
		</div><br/>	
		
			</div>
		</div><br/>
		';
        $inf = array('title' => 'پنل کاربری', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

    //func index

    public function home($begin = 0, $end = 30)
    {
		GSMS::load("telgroup", "class");
		
		$tempGroups = GSMS::$class['telgroup']->listtelgroups($begin, $end );
		
		//GSMS::load('home','site_view','telgroup',$tempGroups);
		
		GSMS::load('indexPage','user_view','telgroup',$tempGroups);
    }
	
}

//class
?>
