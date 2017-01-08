<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class search_result
{

    function search_result($tempPhotosArray)
    {

        list($tempPhotos, $begin, $itemCount) = $tempPhotosArray;

        if (count($tempPhotos) == 0 || $tempPhotos == 404) {
            $body = 'تصویری یافت نشد<br/><a class="back_btn" href="'
                . GSMS::$class['template']->info['user_url'] . 'users/selectPhoto">برگشت</a>';
            $inf = array('title' => 'لیست تصاویر', 'body' => $body, 'dir' => 'ltr');
            GSMS::$class['template']->index($inf);
            GSMS::$class['template']->footer($inf);
            return;
        }
        $body = '
			<style>
				.post_preview{

				   width: 250px;

				   height: 150px;

				   margin: 10px;

				   padding: 0;
				   
				   float:left;clear: right;

				   background: #6fb2e5;

				   font-size:16px;

				   box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;

				   -o-box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;

				   -webkit-box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;

				   -moz-box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;
				}

				.post_thume{

				left: 5px; top: 0px; width: 120px; height: 80px; opacity: 1;float:left;

				box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;

				   -o-box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;

				   -webkit-box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;

				   -moz-box-shadow: 0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff;

				margin-left:10px;

				position:relative;}
				.read_more{
				  display: inline-block;
				  *display: inline;
				  padding: 4px 12px;
				  margin-bottom: 0;
				  *margin-left: .3em;
				  font-size: 16px;
				  line-height: 20px;
				  color: #333333;
				  text-align: center;
				  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
				  vertical-align: middle;
				  cursor: pointer;
				  background-color: #c0f5f5;
				  *background-color: #c6e6e6;
				  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
				  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
				  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
				  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
				  background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
				  background-repeat: repeat-x;
				  border: 1px solid #cccccc;
				  *border: 0;
				  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
				  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
				  border-bottom-color: #b3b3b3;
				  -webkit-border-radius: 4px;
					 -moz-border-radius: 4px;
						  border-radius: 4px;
				  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#ffffffff\', endColorstr=\'#ffe6e6e6\', GradientType=0);
				  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
				  *zoom: 1;
				  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
					 -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
						  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
				}

			</style>
			<script>
			function add(id)
			{
				window.parent.setValue(id);
			}
			</script>
			
			<table dir="rtl"><tr>';


        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['user_url'] . 'users/select_result', $begin, $itemCount);


        $body .= '<br/>';


        $date = '';
        for ($i = 0; $i < count($tempPhotos); $i++) {
            if ($tempPhotos[$i]->date != $date) {
                $body .= '</tr><tr>تاریخ :' . $tempPhotos[$i]->date . '</tr><tr>';
                $date = $tempPhotos[$i]->date;
            }
            $body .= '<td>
				<div class="post_preview" dir="rtl" align="right"><br/>
					<a href="' . GSMS::$class['template']->info['user_url'] . 'photographer/photo_view/' . $tempPhotos[$i]->id . '">
						<img class="post_thume"
							id="img' . $i . '"
							src="' . GSMS::$class['template']->info['user_url'] . 'photographer/photo_preview/' . $tempPhotos[$i]->id . '">
					</a><br/>			
					
					  عنوان تصویر :' . $tempPhotos[$i]->title . '<br/>
					  مکان :' . $tempPhotos[$i]->location . '<br/>
					  تاریخ تصویر :' . $tempPhotos[$i]->date . '<br/>
						<a class="read_more" href="javascript:void(0)" onclick="add(' . $tempPhotos[$i]->id . ')" >افزودن به پاسخ</a>
					
				</div></td>';

            $body .= (($i + 1) % 3 == 0) ? '</tr><tr>' : '';
        }
        //for
        //paging
        $body .= '</tr></table><br/><a class="back_btn" href="'
            . GSMS::$class['template']->info['user_url'] . 'users/selectPhoto">برگشت</a>';
        $inf = array('title' => 'لیست تصاویر', 'body' => $body, 'dir' => 'ltr');
        GSMS::$class['template']->index($inf);
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}