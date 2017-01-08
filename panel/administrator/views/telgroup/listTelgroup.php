<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class listTelgroup
{

    function listTelgroup($tempGroupArray)
    {

        $inf = array('page_title' => 'لیست گروه ها ');
        GSMS::$class['template']->header($inf);
        $inf = array('page_title' => 'لیست گروه ها ');
        GSMS::$class['template']->load($inf, 'admin_header');

		
        list($tempGroup, $begin, $itemCount) = $tempGroupArray;
		
		if (count($tempGroup) == 0) {
            $body = 'گروهی یافت نشد<br/><a class="back_btn" href="'
				. GSMS::$class['template']->info['admin_url'] . '">برگشت</a>';
			$inf = array('title' => 'لیست گروه ها ', 'body' => $body);
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
		
        $body = '<div class="row" dir="rtl"><tr>';
 
        $date = '';

       
        $body .= ' <br/>';

        for ($i = 0; $i < count($tempGroup); $i++) {

            $body .= '
			
			<div class="music_item">
				
				<a href="' . GSMS::$class['template']->info['index'] . 'telgroups/telgroupView/' . $tempGroup[$i]->id . '">
					<div class="bicBox">
						<img class="music_cover"
							id="img' . $i . '"  width="50"  height="40"
							src="'.GSMS::$class['template']->info['index_url'].'iconGroupView/' .
							$tempGroup[$i]->iconPictureId. '/'.$tempGroup[$i]->telgroupTypeId . '"/>
					</div>
					<div class="music_title" >   ' . $tempGroup[$i]->title . '</div>
					<div class="music_owner" > ' . substr($tempGroup[$i]->description,0, 200 ) . '</div>
					<div class="music_date" >' . substr($tempGroup[$i]->createDate, 0, 10) . '</div>
				</a>	
				<div class="music_rate">
					  ' . $tempGroup[$i]->userId . ' 
				</div>	
				<a  target="_blank"  class="btn btn" href="' . 
					 $tempGroup[$i]->telegramAddress . '">مشاهده</a>
			'.
				(
				($tempGroup[$i]->isAccepted == 1 ) ? 		
				('<a  target="_blank"  class="btn btn-warning" href="' . 
					GSMS::$class['template']->info['admin_url'] . 'telgroups/remove/' . ($tempGroup[$i]->id*34) . '">حذف</a>' )
					: 
				'<a target="_blank" class="btn btn-success" href="' . 
					GSMS::$class['template']->info['admin_url'] . 'telgroups/accept/' . ($tempGroup[$i]->id*34) . '">تایید</a>' 
				)
				.  '
			<script>$("#input' . $tempGroup[$i]->id . '").raty({ half: true ,readOnly: true});</script>	
			</div>';

        }
        //for
		if($itemCount > 1000) 
		{
			$itemCount= $begin   + 1000;
		}
		
		$body .= '</div>';
		$body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] .  'telgroups/lastTelgroup/', $begin, $itemCount);

         $body .= ' </div>
		  <br/>
		  <a class="back_btn" href="' . GSMS::$class['template']->info['user_url'] . '">برگشت</a>
		  
		  ';


        $inf = array('title' => 'لیست گروه ها', 'body' => $body);
        GSMS::$class['template']->index($inf);
        GSMS::$class['template']->load($inf, 'site_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}