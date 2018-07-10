<?php //allahoma sale ala mohammad va ale mohammad
 

class listTickets
{

    function listTickets($tempCommentsArray)
    {
 
        $body = '';
        list($tempComments, $begin, $itemCount) = $tempCommentsArray['comments'];
		
		
        if (count($tempComments) == 0 || !is_array($tempComments)) 
		{
            $body = ' تیکتی یافت نشد';
            GSMS::$class['template']->message('ليست تیکت های پشتیبانی',$body,'admin','alert alert-warning', true,true , array('activeTab'=>'tickets'));
            exit();
        }
        //if


        $body .= '
		<div class="table-responsive">
		<table class="table table-bordered">
		<thead class="text-primary">
		<th class="text-right">نویسنده </th>
		<th class="text-right">نویسنده </th>
		<th class="text-right"> تاریخ</th>
		<th class="text-right">متن</th>
		<th class="text-right">مشاهده </th>
		</thead>';
        for ($i = 0; $i < count($tempComments); $i++) {
            $body .= '<tr '.($tempComments[$i]->readed == 0 ? 'class="text-info"' : ''  ).'  >' .
                '<td>' . $tempComments[$i]->name . '</td>' .
                '<td>' . $tempComments[$i]->createDate . '</td>' .
                '<td>' . $tempComments[$i]->content . '</td>' .
                '<td>' . ( $tempComments[$i]->readed ==2 ? 	
											'<span class="text-success">پاسخ داده شده</span>' : 
											'<span class="text-danger">پاسخ داده نشده</span>' ) . '</td>' .
				'<td>
					<a  class="btn btn-primary btn-sm" href="' .GSMS::$class['template']->info['admin_url'] .
					'tickets/viewTicket/'.
                                    $tempComments[$i]->id . '">مشاهده</a>
				</td>' .
              '</tr>';
        }
        //for
        $body .= '</table></div>';

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['admin_url'] . 'tickets/listTickets/', $begin, $itemCount);
 
        GSMS::$class['template']->message('ليست تیکت های پشتیبانی', $body,'admin','',false ,false,array('activeTab'=>'tickets')); 
		
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}