<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system
 
class listTicket
{

    function listTicket($tempCommentsArray)
    {
		//---------------initializing-----------
		$inf = array('page_title' => 'لیست تیکت های قبلی','activeTab'=>'ticket');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		
        $body = '';
        list($tempCommentsArray) = $tempCommentsArray;
        list($tempComments, $begin, $itemCount) = $tempCommentsArray;
		 
        if (count($tempComments) == 0 || !is_array($tempComments)) 
		{ 
            $body = '
			<div class="alert alert-info">
			موردی یافت نشد
			</div>
			<br> 
			<a class="btn btn-success" href="' .GSMS::$class['template']->info['user_url'] . 'ticket/insertTicket/"><i class="material-icons">add</i>ثبت تیکت جدید</a>
			
			' ;
            GSMS::$class['template']->message(
							'لیست تیکت های قبلی' ,		//title
							$body,					//body
							'user',					//part
							'',	//css class
							false,					//format output
							true,						//back link
							array('activeTab'=>'ticket')); //extra argument 
            return;
        }
        //if
 

        $body .= '<table class="table table-hover " dir=rtl>
		<thead class="text-primary">
			<th class="text-right" >عنوان </th>
			<th class="text-right" >تاریخ</th>
			<th class="text-right" >متن</th>
			<th class="text-right" >وضعیت </th>
			<th class="text-right" >مشاهده </th>
		</thead>';
        for ($i = 0; $i < count($tempComments); $i++) 
		{
            $body .= '<tr '.($tempComments[$i]->accepted == 1 ? '' : 'class="unread"'  ).'  >' .  
               '<td>' . $tempComments[$i]->name . '</td>' .
                '<td>' . $tempComments[$i]->createDate . '</td>' .
                '<td>' . substr( $tempComments[$i]->content,0,50) . '...</td>' .
                '<td>' . ( $tempComments[$i]->readed ==2 ? 	
											'<span class="text-success">پاسخ داده شده</span>' : 
											'<span class="text-danger">پاسخ داده نشده</span>' ) . '</td>' .
                '<td><a class="btn btn-info btn-sm" href="' .GSMS::$class['template']->info['user_url'] . 'ticket/viewTicket/'.
                                    $tempComments[$i]->id . '"><i class="material-icons">dvr</i>مشاهده</a></td>' .
                '</td>' .
              '</tr>';
        }
        //for
        $body .= '</table>
		
		
		<a class="btn btn-success" href="' .GSMS::$class['template']->info['user_url'] . 'ticket/insertTicket/"><i class="material-icons">add</i>ثبت تیکت جدید</a>
		';

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'ticket/listTickets/', $begin, $itemCount); 
        
		$inf = array('title' =>  'لیست تیکت های قبلی', 'body' => $body);
		GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
		
        
    }

}

//class
// if (!defined("GSMS")) 
    // exit("Access denied");
