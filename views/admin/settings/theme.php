<?php //allahoma sale ala mohammad va ale mohammad
 

class theme
{
   
   function theme($information)
	{
		GSMS::load('template', 'core');
		 
		$inf=array('page_title'=>'انتخاب قالب سایت');
		GSMS::$class['template']->header($inf);
		$inf=array('page_title'=>'انتخاب قالب سایت');
		GSMS::$class['template']->panel_header($inf);
		
		
		list($tempThemes) = $information['themes'];
		list($activeThemes) = $information['active'];
		
		 
		$body ='';
		$body ='<table class="data_table" dir="rtl"><tr>';
		for($i=0;$i< count($tempThemes);$i++)
		{
			$body .= '<td>
			<div class="post_preview" dir="rtl" align="right"><br/>
				<a href="'.GSMS::$siteURL.GSMS::$outputDir.'themes/' .$tempThemes[$i]->value. '/screenshot.jpg">
					<img class="post_thume"
						id="img'. $i . '"
						src="'. GSMS::$siteURL.GSMS::$outputDir.'themes/' .$tempThemes[$i]->value. '/screenshot.jpg">
				</a>			
				
				<div class="pic-title" >  عنوان  :' .$tempThemes[$i]->value .'</div>
				
				<div class="pic-btn">
                    <a href="'.GSMS::$class['template']->info['admin_url'].'settings/themes/' .$tempThemes[$i]->id.'" rel="bookmark">
                        <div class="'. (( $tempThemes[$i]->value == $activeThemes->value) ? 'page_btn_disabled':  'read_more').'">تنظیم به پیش فرض</div>
                    </a> 
                    
			    </div>
			</div></td>';
				
			$body .= (($i+1) %3  == 0 )? '</tr><tr>' :''; 
		}//for
		
		$body .='</table>';
		
		$body .='<br/><a class="back_btn" href="'
				.GSMS::$class['template']->info['admin_url'].'">برگشت</a>';
		$inf=array('title'=>'انتخاب قالب سایت','body'=>$body,'dir'=>'ltr');
		GSMS::$class['template']->index($inf);
		GSMS::$class['template']->footer($inf);
	}
	
}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}