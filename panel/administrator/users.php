<?php //allahoma sale ala mohammad va ale mohammad 
//class users for all user managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system
class users
{
    public function __construct()
    {
        if (GSMS::$class['session']->checkLogin() == true) 
		 {
            $this->user = GSMS::$class['session']->getUser();

            if ($this->user['UserType'] == 1) 
			{
                GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/admin/index");
            } elseif ($this->user['UserType'] == 2) 
			{
                //GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index . "/user/index");
            } 
        }
		else 
		{
			GSMS::$class['session']->logout();
			GSMS::$class['router']->redirect(GSMS::$siteURL . GSMS::$index);
		}
        GSMS::load('user', 'class');
        GSMS::load('template', 'lib');
        GSMS::$class['system_log']->log('DEBUG', 'users class started successfull');
    }

    function index()
    {
        $this->propertyName = $propertyValue;
        $this->list_users();
    }

    //fun

    function create_user()
    {
        $username = GSMS::$class['input']->post('username');
        if ($username == '') {
            //free result
            GSMS::load('create_user', 'admin_view', 'users');
        } else {
            $inf = array('page_title' => 'تعریف کاربر جدید');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'صفحه ی مدیریت ');
            GSMS::$class['template']->panel_header($inf);

            GSMS::load('admin', 'class');
            $tempAdmin = new admin();

            if (is_object($tempAdmin->getAdminByUsername(GSMS::$class['input']->post('username')))) {
                $body = 'کاربر دیگری با این نام کاربری وجود دارد   ' .
                    '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
                $inf = array('title' => 'تعریف کاربر جدید', 'body' => $body, 'dir' => 'ltr');
                GSMS::$class['template']->index($inf);
                GSMS::$class['template']->footer($inf);
            }
            $tempAdmin->name = GSMS::$class['input']->post('name');
            $tempAdmin->family = GSMS::$class['input']->post('family'); //family
            $tempAdmin->describe = GSMS::$class['input']->post('describe');

            $tempAdmin->mail = GSMS::$class['input']->post('mail');
            $tempAdmin->userName = GSMS::$class['input']->post('username');
            $tempAdmin->password = GSMS::$class['input']->post('pass');
            $tempAdmin->adminType = GSMS::$class['input']->post('user_type');


            $tempAdmin->mobile = GSMS::$class['input']->post('mobile');
            $tempAdmin->date = GSMS::$class['calendar']->now();

            $result = $tempAdmin->save();

            if ($result == 1)
                $body = 'کاربر با موفقیت درج شد' .
                    '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            else
                $body = 'کاربر درج نشد' .
                    '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'تعریف کاربر جدید', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            unset($tempAdmin);
        }
        //if
    }

    //func

    function edit_user($adminid)
    {
        $name = GSMS::$class['input']->post('name');
        GSMS::load('admin', 'class');
        if ($name == '') {
            $tempAdmin = admin::getAdmin($adminid);
            GSMS::load('edit_user', 'admin_view', 'users', $tempAdmin);
        } else {
            $tempAdmin =& admin::getAdmin(GSMS::$class['input']->post('admin_id'));
            $tempAdmin->name = GSMS::$class['input']->post('name');
            $tempAdmin->family = GSMS::$class['input']->post('family'); //family
            $tempAdmin->mail = GSMS::$class['input']->post('mail');
            $tempAdmin->userName = GSMS::$class['input']->post('username');
            $tempAdmin->describe = GSMS::$class['input']->post('describe');
            $tempAdmin->mobile = GSMS::$class['input']->post('mobile');
            $tempAdmin->adminType = 2;

            $result = $tempAdmin->save();
            $inf = array('page_title' => 'ويرايش مدير');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'صفحه ي مديريت ');
            GSMS::$class['template']->panel_header($inf);
            if ($result == 1)
                $body = 'مدير با موفقيت ويرايش شد';
            else
                $body = 'مدير ويرايش نشد';

            $body .= '<br><a class="back_btn" href="' .
                GSMS::$class['template']->info['user_url'] .
                'users/list_users">برگشت</a>';
            $inf = array('title' => ' ويرايش مدير', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            unset($tempAdmin);
        }
        //if
    }

    //func

    function view_user($adminid)
    {
        //free result
        GSMS::load('admin', 'class');
        $tempAdmin = admin::getAdmin($adminid);
        GSMS::load('view_user', 'admin_view', 'users', $tempAdmin);
    }

    function user_photos($userid = 0, $begin = 0, $end = 0)
    {
        $current_user = GSMS::$class['session']->getUser();

        if ($userid == 0)
            $userid = $current_user['UserID'];
        //free result
        GSMS::load('photo', 'class');
        $tempPhoto = GSMS::$class['photo']->listPhotosByUser($userid, $begin, $end);
        GSMS::load('list_photo', 'admin_view', 'users', $tempPhoto);
    }

    function photographer_photos($userid = 0, $begin = 0, $end = 0)
    {
        $current_user = GSMS::$class['session']->getUser();

        if ($userid == 0)
            $userid = $current_user['UserID'];
        //free result
        GSMS::load('photo', 'class');
        $tempPhoto = GSMS::$class['photo']->listPhotosByPhotographer($userid, $begin, $end);
        GSMS::load('list_photo', 'admin_view', 'users', $tempPhoto);
    }

    function list_users($begin = 0, $end = 0)
    {

        //------------------------
        GSMS::load('admin', 'class');
        $tempAdmins[] = admin::listAdmins(2, $begin, $end);
        $tempAdmins[] = $begin;
        $tempAdmins[] = $end;

        GSMS::load('list_users', 'admin_view', 'users', $tempAdmins);

    }

    //func

    function list_photographers($begin = 0, $end = 0)
    {
        //------------------------
        GSMS::load('admin', 'class');
        $tempAdmins[] = admin::listAdmins(3, $begin, $end);
        $tempAdmins[] = $begin;
        $tempAdmins[] = $end;

        GSMS::load('list_photographers', 'admin_view', 'users', $tempAdmins);
    }

    //func

    function user_requests($begin = 0, $end = 0)
    {
        //free result
        GSMS::load('request', 'class');
        $tempRequests = GSMS::$class['request']->list_requests(0, $begin, $end);
        GSMS::load('user_requests', 'admin_view', 'users', $tempRequests);

    }

    //func

    function response_request($request_id = 0)
    {
        //free result
        GSMS::load('request', 'class');
        if (!isset($_POST['submit'])) {
            $tempRespons = GSMS::$class['request']->get_request($request_id);
            GSMS::load('response_request', 'admin_view', 'users', $tempRespons);
        } else {
            //save response

            GSMS::load('request', 'class');
            $user = GSMS::$class['session']->getUser();
            $tempRequest = new request();
            $tempRequest->title = GSMS::$class['input']->post('title');
            $tempRequest->describe = GSMS::$class['input']->post('describe');
            $tempRequest->parentRequest = GSMS::$class['input']->post('req_id');
            $tempRequest->responsePhoto = GSMS::$class['input']->post('response');

            $result = $tempRequest->save();

            $inf = array('page_title' => 'پاسخ جدید');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'صفحه ی مدیریت ');
            GSMS::$class['template']->panel_header($inf);
            if ($result == 1)
                $body = 'پاسخ با موفقیت درج شد' .
                    '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . 'users/user_requests">برگشت</a>';
            else
                $body = 'پاسخ درج نشد' .
                    '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . 'users/user_requests">برگشت</a>';
            $inf = array('title' => 'پاسخ جدید', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
        }

    }

    //func

    function user_statistic()
    {
        GSMS::load('admin', 'class');

        $info['users'] = admin::listAdminsAndPhoto(2);
        $info['photographers'] = admin::listAdminsAndPhoto(3);

        GSMS::load('user_statistic', 'admin_view', 'users', $info);
    }

    function view_request($request_id)
    {
        //free result
        GSMS::load('request', 'class');
        $tempRequests = GSMS::$class['request']->get_request($request_id);
        GSMS::load('view_request', 'admin_view', 'users', $tempRequests);

    }

    //func

    function edit_request($request_id)
    {
        //free result
        GSMS::load('request', 'class');
        $tempRequests = GSMS::$class['request']->get_request($request_id);
        GSMS::load('request_photo', 'admin_view', 'users', $tempRequests);

    }

    //func

    function select_result($begin = 0, $end = 30)
    {
        GSMS::load("photo", "class");
        $tempPhotos = array();
        if (isset($_POST['submit'])) {

            $user = GSMS::$class['session']->getUser();
            $date_begin = GSMS::$class['input']->post('date_enable') == 'on' ? GSMS::$class['input']->post('date_a') : '';
            $date_end = GSMS::$class['input']->post('date_enable') == 'on' ? GSMS::$class['input']->post('date_b') : '';

            $tempPhotos = GSMS::$class['photo']->searchPhotos
                (
                    GSMS::$class['input']->post('q'), //$title='',
                    $date_begin, //$date='',
                    $date_end,
                    GSMS::$class['input']->post('key'), //$key='',
                    GSMS::$class['input']->post('place'),
                    '', //$insert_date='',
                    GSMS::$class['input']->post('desc'), //$describe='',

                    '', //$user=($user['UserID']),
                    GSMS::$class['input']->post('photographer'), //$photographer=0,
                    GSMS::$class['input']->post('cat'), //$category=0,
                    $begin,
                    $end);
        } elseif (isset($_SESSION['query_count']) && $_SESSION['query_count'] > 0) {
            $tempPhotos = GSMS::$class['photo']->review($_SESSION['query'], $_SESSION['query_count'], $begin, $end);
        } else {
            $user = GSMS::$class['session']->getUser();
            $tempPhotos = GSMS::$class['photo']->listPhotosByUser($user['UserID']);
        }
        //else
        GSMS::load('search_result', 'admin_view', 'users', $tempPhotos);
    }

    function selectPhoto()
    {
        GSMS::load('category', 'class');
        GSMS::load('admin', 'class');

        list($inf['categorys'], ,) = GSMS::$class['category']->list_categorys();
        $inf['admins'] = GSMS::$class['admin']->listAdmins(3); //for photographer

        GSMS::load('search', 'admin_view', 'users', $inf);
    }

    function request_photo()
    {
        if (!isset($_POST['submit'])) {
            GSMS::load('request_photo', 'admin_view', 'users');
        } else {
            GSMS::load('request', 'class');
            $tempRequest = new request();
            $tempRequest->title = GSMS::$class['input']->post('title');
            $tempRequest->describe = GSMS::$class['input']->post('describe');
            if (isset($_POST['req_id']))
                $tempRequest->id = GSMS::$class['input']->post('req_id');

            $result = $tempRequest->save();

            $inf = array('page_title' => 'درخواست جدید');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'صفحه ی مدیریت ');
            GSMS::$class['template']->panel_header($inf);
            if ($result == 1)
                $body = 'درخواست با موفقیت درج شد' .
                    '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            else
                $body = 'درخواست درج نشد' .
                    '<br><a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'درخواست جدید', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
        }

    }

    function requests($begin = 0, $end = 0)
    {
        $current_user = GSMS::$class['session']->getUser();

        //free result
        GSMS::load('request', 'class');
        $tempRequest = GSMS::$class['request']->list_requests($current_user['UserID'], 0, $begin, $end);

        GSMS::load('list_request', 'admin_view', 'users', $tempRequest);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}
