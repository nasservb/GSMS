<?php //allahoma sale ala mohammad va ale mohammad
 

class listTickets
{

    function listTickets($temp)
    {
 
        $body = '';
        list($tempTickets, $begin, $itemCount) = $temp['tickets'];
		
		
        if (count($tempTickets) == 0 || !is_array($tempTickets)) 
		{
            $body = '<div class="alert alert-warning"> تیکتی یافت نشد </div><br/>
			<a class="btn btn-success" href="' .GSMS::$class['template']->info['plugin_url'] 
			. 'ticket/insertTicket/"><i class="material-icons">add</i>ثبت تیکت جدید</a>';
			
			
            GSMS::$class['template']->message('ليست تیکت های پشتیبانی',$body,$temp['level'],'', true,true , array('activeTab'=>'tickets'));
            exit();
        }
        //if


        $body .= '
		<table class="table table-bordered">
		<thead class="text-primary">
		<th class="text-right">نویسنده </th>
		<th class="text-right"> تاریخ</th>
		<th class="text-right">عنوان</th>
		<th class="text-right">وضعیت</th>
		<th class="text-right">مشاهده </th>
		</thead>';
        for ($i = 0; $i < count($tempTickets); $i++) {
            $body .= '<tr '.($tempTickets[$i]->readed == 0 ? 'class="text-info"' : ''  ).'  >' .
                '<td>' . $tempTickets[$i]->ownerName . '</td>' .
                '<td>' . $tempTickets[$i]->createDate . '</td>' .
                '<td>' . $tempTickets[$i]->title . '</td>' .
                '<td>' . ( $tempTickets[$i]->readed ==2 ? 	
											'<span class="text-success">پاسخ داده شده</span>' : 
											'<span class="text-danger">پاسخ داده نشده</span>' ) . '</td>' .
				'<td>
					<a  class="btn btn-primary btn-sm" href="' .GSMS::$class['template']->info['plugin_url'] .
					'ticket/viewTicket/'.
                                    $tempTickets[$i]->id . '">مشاهده</a>
				</td>' .
              '</tr>';
        }
        //for
        $body .= '</table><a class="btn btn-success" href="' .GSMS::$class['template']->info['plugin_url'] . 'ticket/insertTicket/"><i class="material-icons">add</i>ثبت تیکت جدید</a>
		';

        $body .= GSMS::$class['template']->paging(
            GSMS::$class['template']->info['plugin_url'] . 'ticket/listTickets/', $begin, $itemCount);
 
        GSMS::$class['template']->message('ليست تیکت های پشتیبانی', $body,$temp['level'],'',false ,false,array('activeTab'=>'tickets')); 
		
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}