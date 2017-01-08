<?php //allahoma sale ala mohammad va ale mohammad 
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system
class settings
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
        GSMS::load('template', 'lib');
        GSMS::$class['system_log']->log('DEBUG', 'settings class started successfull');
    }

    function index()
    {
        //$this->propertyName=$propertyValue;
    }

    function commentAccept($id)
	{
		GSMS::load('comment', 'class');

        $tempComment =GSMS::$class['comment']->getComment($id);
		
        $inf = array('page_title' => 'تایید نظر');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'تایید نظر');
        GSMS::$class['template']->panel_header($inf);
		
         if(!is_object($tempComment))
        {
			 $body = '<div dir="rtl" class="alert alert-warning"> نظر یافت نشد.</div>';
           
        }
		else
		{
			$tempComment->accepted = true; 
			$tempComment->save();
			
			$body = '<div dir="rtl" class="alert alert-info">نظر با موفقیت تایید شد .</div>';
            
		}
		$inf = array(
					'title' =>'تایید نظر', 
					'body' => $body.
					'<br/><a class="back_btn" href="'
						. GSMS::$class['template']->info['user_url'] . 
						'settings/comments">برگشت</a>',
					'dir' => 'ltr');
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
	}
	
    function commentDelete($id)
    {
		GSMS::load('comment', 'class');

        $tempComment =GSMS::$class['comment']->getComment($id);
		
        $inf = array('page_title' =>'مشاهده نظر');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' =>'مشاهده نظر');
        GSMS::$class['template']->panel_header($inf);
		
        if(!is_object($tempComment)|| !$tempComment->deleteComment())
        {
			 $body = '<div dir="rtl" class="alert alert-warning"> نظر یافت نشد.</div>';
           
        }
		else
		{
			$body = '<div dir="rtl" class="alert alert-info">نظر با موفقیت حذف شد .</div>';
            
		}
		$inf = array(
					'title' =>'مشاهده نظر', 
					'body' => $body.
					'<br/><a class="back_btn" href="'
						. GSMS::$class['template']->info['user_url'] . 
						'settings/comments">برگشت</a>',
					'dir' => 'ltr');
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
    }

    function commentView($id)
    {
		GSMS::load('comment', 'class');

        $inf =GSMS::$class['comment']->getComment($id);
		
        GSMS::load('view_comment', 'user_view', 'settings', $inf);
    }

    function comments($begin = 0, $end = 30)
    {
        GSMS::load('comment', 'class');
        $user=GSMS::$class['session']->getUser();

        $inf['comments'] =GSMS::$class['comment']->listCommentsByUser($user['UserID'],-1,$begin,$end);
		
        GSMS::load('list_comment', 'user_view', 'settings', $inf);

    }

    function unacceptedComments($begin = 0, $end = 30)
    {

        GSMS::load('comment', 'class');
        $inf['comments'] =GSMS::$class['comment']->getUnacceptedComment($begin,$end);

        GSMS::load('unaccepted_comment', 'user_view', 'settings', $inf);
    }

    //fun
    function list_sqlbugs($begin = 0, $end = 30)
    {
        GSMS::load('sqlbug', 'class');

        $tempSqlbugs =& sqlbug::listSqlbugs($begin, $end);

        GSMS::load('list_sqlbugs', 'admin_view', 'settings', $tempSqlbugs);
    }

    function search_in_sqlbug()
    {
    }

    public function today_events($begin = 0, $end = 0)
    {
    }

    function list_events($begin = 0, $end = 0)
    {
    }

    function search_in_events()
    {
    }

    function themes($id = 0)
    {
        GSMS::load('option', 'class');
        if ($id == 0) {
            $themes = GSMS::$class['option']->get_optionsByKey('theme');
            list($active_theme) = GSMS::$class['option']->get_optionsByKey('theme_active');
            GSMS::load('theme', 'admin_view', 'settings', array('themes' => $themes, 'active' => $active_theme));
        } else {

            $inf = array('page_title' => 'تغییر قالب');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'تغییر قالب');
            GSMS::$class['template']->panel_header($inf);


            $themes = GSMS::$class['option']->get_option($id);
            list($active_theme) = GSMS::$class['option']->get_optionsByKey('theme_active');

            if (count($themes) == 0 || count($active_theme) == 0) {
                $body = 'قالب پیدا نشد . خطا در اطلاعات پیکر بندی  وجود دارد . با پشتیبانی تماس بگیرید .</table><br><a class="back_btn" href="'
                    . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
                $inf = array('title' => 'تغییر قالب', 'body' => $body, 'dir' => 'ltr');
                GSMS::$class['template']->index($inf);
                GSMS::$class['template']->footer($inf);
                return;
            }

            $active_theme[0]->value = $themes[0]->value;
            $active_theme[0]->save();


            $body = 'قالب با موفقیت تغییر یافت .</table><br><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'تغییر قالب ', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
    }

	private function get_optionsByKey($key)
	{
		GSMS::load('option', 'class');
		$temp = GSMS::$class['option']->get_optionsByKey($key);
		return $temp[0][0];
	}
	
    function configuration()
    {
        
        if (!isset($_POST['submit'])) 
		{
			$configs['photo_resize'] = $this->get_optionsByKey('photo_resize');
			
            $configs['photo_archive_path'] = $this->get_optionsByKey('photo_archive_path');
            $configs['photo_width'] = $this->get_optionsByKey('photo_width');
            $configs['photo_height']= $this->get_optionsByKey('photo_height');
            $configs['photo_small_width'] = $this->get_optionsByKey('photo_small_width');
            $configs['photo_small_height'] = $this->get_optionsByKey('photo_small_height');
           
            GSMS::load('configuration', 'admin_view', 'settings', $configs);
        } else {

            $inf = array('page_title' => 'تغییر تنظیمات');
            GSMS::$class['template']->header($inf);
            $inf = array('page_title' => 'تغییر تنظیمات');
            GSMS::$class['template']->panel_header($inf);


            $configs['photo_resize'] = $this->get_optionsByKey('photo_resize');
            $configs['photo_archive_path'] = $this->get_optionsByKey('photo_archive_path');
            $configs['photo_width'] = $this->get_optionsByKey('photo_width');
            $configs['photo_height']= $this->get_optionsByKey('photo_height');
            $configs['photo_small_width'] = $this->get_optionsByKey('photo_small_width');
            $configs['photo_small_height'] = $this->get_optionsByKey('photo_small_height');

            if (!is_object($configs['photo_resize'])) {
                $body = 'تنظیمات پیدا نشد . خطا در اطلاعات پیکر بندی  وجود دارد . با پشتیبانی تماس بگیرید .</table><br><a class="back_btn" href="'
                    . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
                $inf = array('title' => 'تغییر تنظیمات', 'body' => $body, 'dir' => 'ltr');
                GSMS::$class['template']->index($inf);
                GSMS::$class['template']->footer($inf);
                return;
            }


            $configs['photo_archive_path']->value = GSMS::$class['input']->post('photo_archive_path');

            if (GSMS::$class['input']->post('photo_width') != '')
                $configs['photo_width']->value = GSMS::$class['input']->post('photo_width');

            if (GSMS::$class['input']->post('photo_height') != '')
                $configs['photo_height']->value = GSMS::$class['input']->post('photo_height');

            $configs['photo_resize']->value = GSMS::$class['input']->post('photo_resize');
            $configs['photo_small_width']->value = GSMS::$class['input']->post('photo_small_width');
            $configs['photo_small_height']->value = GSMS::$class['input']->post('photo_small_height');

            $configs['photo_resize']->save();
            $configs['photo_archive_path']->save();
            $configs['photo_width']->save();
            $configs['photo_height']->save();
            $configs['photo_small_width']->save();
            $configs['photo_small_height']->save();

            $body = ' تنظیمات با موفقیت تغییر یافت .</table><br><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'تغییر تنظیمات', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
    }

    function reports()
    {
        GSMS::load('sqlbug', 'class');
        GSMS::load('photo', 'class');
        GSMS::load('category', 'class');
        GSMS::load('admin', 'class');
        GSMS::load('request', 'class');

        $inf['bugs'] = GSMS::$class['sqlbug']->getCount();
        $inf['requests'] = GSMS::$class['request']->getCount();
        $inf['photos'] = GSMS::$class['photo']->getCount();
        $inf['categoris'] = GSMS::$class['category']->getCount();

        $inf['admins'] = GSMS::$class['admin']->getCount(1);
        $inf['users'] = GSMS::$class['admin']->getCount(2);
        $inf['photographers'] = GSMS::$class['admin']->getCount(3);

        GSMS::load('reports', 'admin_view', 'settings', $inf);

    }

    function system_log($begin = 0, $end = 30)
    {
        GSMS::load('sqlbug', 'class');
        $inf = array('page_title' => 'ليست خطا های بانک اطلاعاتی');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'ليست خطا های بانک اطلاعاتی ');
        GSMS::$class['template']->panel_header($inf);
        $message =& GSMS::$class['system_log']->getLogs();
        $body = '';
        $max = count($message);
        if ($max == 0) {
            $body = 'خوشبختانه خطایی یافت نشد</table><br><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
            $inf = array('title' => 'ليست خطا های بانک اطلاعاتی', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            exit();
        }
        //if
        if (count($message) >= GSMS::$config['page_item_per_page'] ||
            $begin != 0
        ) {
            // paging code
            if (count($message) < GSMS::$config['page_item_per_page']) $body = ' end page ';
            $mx = (300 / GSMS::$config['page_item_per_page']);
            for ($i = 0; $i < $mx; $i++) {
                $body .= ($i != 0 ? '::' : '');
                if (($i * GSMS::$config['page_item_per_page']) == $begin) {
                    $body .= ($i + 1);
                    continue;
                }
                $body .= '<a href=\'' .
                    GSMS::$class['template']->info['user_url'] .
                    'settings/system_log/' . ($i * GSMS::$config['page_item_per_page']) .
                    '/' . ($i + 1) * GSMS::$config['page_item_per_page'] . '\'>' .
                    ($i + 1) . '</a>';
            }
            //for
        }
        //if
        $body .= '<table class="data_table"><tr>
		<td>شماره</td>
		<td>متن</td>
		</tr>';
        for ($i = 0; $i < $max; $i++) {
            $body .= '<tr id="' . ($i % 2 == 0 ? 'tr_even' : 'tr_odd') . '">' .
                '<td>' . $i . '</td>' .
                '<td>' . $message[$i] . '</td>' .
                '</tr>';
        }
        //for
        $body .= '</table><br><a class="back_btn" href="'
            . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' => 'ليست خطا های بانک اطلاعاتی', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
    }

    function system_log_archive()
    {
    }
    //////////////////////////////////////////////////////////////////////////////////

    private function winosname()
    {
        $wUnameB = php_uname("v");
        $wUnameBM = php_uname("r");
        $wUnameB = eregi_replace("build ", "", $wUnameB);
        if ($wUnameBM == "5.0" && ($wUnameB == "2195")) {
            $wVer = "Windows 2000";
        }
        if ($wUnameBM == "5.1" && ($wUnameB == "2600")) {
            $wVer = "Windows XP";
        }
        if ($wUnameBM == "5.2" && ($wUnameB == "3790")) {
            $wVer = "Windows Server 2003";
        }
        if ($wUnameBM == "6.0" && (php_uname("v") == "build 6000")) {
            $wVer = "Windows Vista";
        }
        if ($wUnameBM == "6.0" && (php_uname("v") == "build 6001")) {
            $wVer = "Windows Vista SP1";
        }
        return $wVer;
    }

    private function checkos()
    {
        if (substr(PHP_OS, 0, 3) == "WIN") {
            $osType =
                $this->winosname();
            $osbuild = php_uname('v');
            $os = "windows";
        } elseif (PHP_OS == "FreeBSD") {
            $os = "nocpu";
            $osType = "FreeBSD";
            $osbuild = php_uname('r');
        } elseif (PHP_OS == "Darwin") {
            $os = "nocpu";
            $osType = "Apple OS X";
            $osbuild = php_uname('r');
        } elseif (PHP_OS == "Linux") {
            $os = "linux";
            $osType = "Linux";
            $osbuild = php_uname('r');
        } else {
            $os = "nocpu";
            $osType = "Unknown OS";
            $osbuild = php_uname('r');
        }
        return $osType;
    }

    private function ZahlenFormatieren($Wert)
    {
        if ($Wert > 1099511627776) {
            $Wert = number_format($Wert / 1099511627776, 2, ".", ",") . " TB";
        } elseif ($Wert > 1073741824) {
            $Wert = number_format($Wert / 1073741824, 2, ".", ",") . " GB";
        } elseif ($Wert > 1048576) {
            $Wert = number_format($Wert / 1048576, 2, ".", ",") . " MB";
        } elseif ($Wert > 1024) {
            $Wert = number_format($Wert / 1024, 2, ".", ",") . " kB";
        } else {
            $Wert = number_format($Wert, 2, ".", ",") . " Bytes";
        }

        return $Wert;
    }

    private function getStat($_statPath)
    {
        if (trim($_statPath) == '') {
            $_statPath = '/proc/stat';
        }

        ob_start();
        passthru('cat ' . $_statPath);
        $stat = ob_get_contents();
        ob_end_clean();


        if (substr($stat, 0, 3) == 'cpu') {
            $parts = explode(" ", preg_replace("!cpu +!", "", $stat));
        } else {
            return false;
        }

        $return = array();
        $return['user'] = $parts[0];
        $return['nice'] = $parts[1];
        $return['system'] = $parts[2];
        $return['idle'] = $parts[3];
        return $return;
    }

    private function getCpuUsage($_statPath = '/proc/stat')
    {
        $time1 = getStat($_statPath) or die("getCpuUsage(): couldn't access STAT path or STAT file invalid\n");
        sleep(1);
        $time2 = getStat($_statPath) or die("getCpuUsage(): couldn't access STAT path or STAT file invalid\n");

        $delta = array();

        foreach ($time1 as $k => $v) {
            $delta[$k] = $time2[$k] - $v;
        }

        $deltaTotal = array_sum($delta);
        $percentages = array();

        foreach ($delta as $k => $v) {
            $percentages[$k] = round($v / $deltaTotal * 100, 2);
        }
        return $percentages;
    }

    function server_usage()
    {

        $inf = array('page_title' => 'مدیریت عملکرد سرور');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'مدیریت عملکرد سرور');
        GSMS::$class['template']->panel_header($inf);
        $body .= '
			
		<SCRIPT LANGUAGE="JavaScript"> 
		<!-- Begin 
			function getthedate(){ 
				var mydate=new Date(); 
				var hours=mydate.getHours(); 
				var minutes=mydate.getMinutes(); 
				var seconds=mydate.getSeconds(); 
				var dn="AM"; 
				if (hours>=12) dn="PM"; 
				if (hours>12) hours=hours-12;        
				if (hours==0) hours=12; 
				if (minutes<=9) minutes="0"+minutes; 
				if (seconds<=9)    seconds="0"+seconds; 
				

				var cdate="<span dir=\"ltr\" style=\"color:#054EAE\">زمان سیستم:</span> &nbsp;&nbsp;&nbsp;<span style=\"color:#051F3C\">"+hours+":"+minutes+":"+seconds+" "+dn+"</span><BR>";
				if (document.all) 
					document.all.clock.innerHTML=cdate; 
				else if (document.getElementById) 
					document.getElementById("clock").innerHTML=cdate; 
				else 
					document.write(cdate); 
			} 
			if (!document.all&&!document.getElementById) getthedate(); 

			function goforit(){ 
				if (document.all||document.getElementById) setInterval("getthedate()",1000); 
			} 
			window.onload=goforit; 
		// End --> 
		</SCRIPT>
		<table cellspacing="2" cellpadding="2">
		<tr>';

        if ($servername == "") {
            $theservername = $_SERVER['SERVER_NAME'];
        } else {
            $theservername = $servername;
        }
        if ($customos == "") {
            $osname = $this->checkos();
        } else {
            $os = "nocpu";
            $osname = $customos;
        }
        if (php_sapi_name() == "apache2handler") {
            $httpapp = "Apache";
        } else {
            $httpapp = php_sapi_name();
        }


        if (PHP_OS == "WINNT") {
            $os = "windows";
            $osbuild = php_uname('v');
        } elseif (PHP_OS == "Linux") {
            $os = "linux";
            $osbuild = php_uname('r');
        } else {
            $os = "nocpu";
            $osbuild = php_uname('r');
        }

        $frei = disk_free_space(GSMS::$config['photo_archive_path']);
        $insgesamt = disk_total_space(GSMS::$config['photo_archive_path']);
        $belegt = $insgesamt - $frei;
        $prozent_belegt = 100 * $belegt / $insgesamt;
        $body .= '
		<td align="left" valign="top" style="color:#051F3C"><span style="color:#054EAE">فضای  سرور:</span><br>
		استفاده شده = <b dir="ltr">' . $this->ZahlenFormatieren($belegt) . '</b>(' . round($prozent_belegt, "2") . ' %)<br>
		<div class="prg"><img width=' . round($prozent_belegt, "2") . '%" border="0"></div><br>
		فضای خالی = <b dir="ltr">' . $this->ZahlenFormatieren($frei) . '</b><br>
		کل فضا = <b dir="ltr">' . $this->ZahlenFormatieren($insgesamt) . '</b></td>';

        {
            if ($os == "windows") {
                $wmi = new COM("Winmgmts://");
                $cpus = $wmi->execquery("SELECT * FROM Win32_Processor");
                $body .= '<td align="left" valign="top" style="color:#051F3C"><span style="color:#054EAE">پردازشگر:</span><br>';
                $body .= ' مشغولیت پردازشگر: <b dir="ltr">';
                foreach ($cpus as $cpu) {
                    $body .= "" . $cpu->loadpercentage . "%<br />";
                }
                $body .= '</b><div class="prg"><img width="' . round($cpu->loadpercentage, "2") . '%" border="0"></div><br>';
                $body .= '<span dir="ltr" style="color:#054EAE">زمان سرور: </span>';
                $thetimeis = getdate(time());
                $thehour = $thetimeis['hours'];
                $theminute = $thetimeis['minutes'];
                $thesecond = $thetimeis['seconds'];
                if ($thehour > 12) {
                    $thehour = $thehour - 12;
                    $dn = "PM";
                } else {
                    $dn = "AM";
                }
                $body .= "$thehour: $theminute:$thesecond $dn <br>";
                $body .= '<span id="clock"></span>';
                $body .= '</td>';
            } elseif ($os == "linux") {

                $cpu = getCpuUsage();
                $cpulast = 100 - $cpu['idle'];
                $body .= '<td align="left" valign="top" style="color:#051F3C"><span style="color:#054EAE">پردازشگر:</span><br>';
                $body .= " مشغولیت پردازشگر: <b dir='ltr'> " . round($cpulast, "0") . "%</b><br>";
                $body .= '<div class="prg"><img width=' . round($cpulast, "2") . '%" border="0"></div><br>';
                $body .= '<span dir="ltr" style="color:#054EAE">زمان سرور: </span>';
                $thetimeis = getdate(time());
                $thehour = $thetimeis['hours'];
                $theminute = $thetimeis['minutes'];
                $thesecond = $thetimeis['seconds'];
                if ($thehour > 12) {
                    $thehour = $thehour - 12;
                    $dn = "PM";
                } else {
                    $dn = "AM";
                }
                $body .= "$thehour: $theminute:$thesecond $dn <br>";
                $body .= '<span id="clock"></span>';
                $body .= '</td>';
            } elseif ($os == "nocpu") {
                $body .= "";
            } else {
                $body .= 'CPU Load<br>';
                $body .= "CPU Load: There Was An Error.<br>";
            }
        }
        $body .= '</tr></table>';
        $body .= '</table><br><a class="back_btn" href="'
            . GSMS::$class['template']->info['user_url'] . '">برگشت</a>';
        $inf = array('title' => 'مدیریت عملکرد سرور', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);

    }
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}