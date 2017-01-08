<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class about
{
	
    public function about(  )
    {
		$inf = array('page_title' => '  درباره سایت     ');
        GSMS::$class['template']->header($inf); 
        GSMS::$class['template']->load($inf,'site_header');
        $user = GSMS::$class['session']->getUser();
		
		$body='<div  style="padding: 19px;  line-height: 25px;">
		<div class="message-info">
		<h3>   درباره سایت     </h3>
		
<div class="section">

	<header class="section-main-title">
		<h3><span id="news-title"><span class="masha_index masha_index1" rel="1"></span>درباره ما</span></h3>
	</header>

	<div class="content">در دست تهیه</div>
	
</div>
		
		
<a class="btn  btn-success" href="'.GSMS::$class['template']->info['index'].'acceptor/insertAcceptor">ثبت نام رایگان </a>
<br/> 
		</div>
		</div><br/>
		<a class="btn " href="'.GSMS::$class['template']->info['index_url'].'">برگشت</a>
		';
		
		
		$inf = array('title' => ' درباره سایت', 'body' => $body,  'align'=>'right');
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->footer($inf);
	}

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}