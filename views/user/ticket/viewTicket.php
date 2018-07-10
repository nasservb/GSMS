<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system
 
class viewTicket
{

    function viewTicket($temp)
    {
		$inf = array('page_title' => 'مشاهده تیکت','activeTab'=>'ticket');
		GSMS::$class['template']->header($inf);
		GSMS::$class['template']->load($inf, 'user_header');
		
        $body = '';
        $tempComment = $temp['comment']; 
		 
        if (!is_object($tempComment)  ) 
		{ 
            $body = ' تیکت یافت نشد  ' ;
            GSMS::$class['template']->message(
							'مشاهده تیکت' ,		//title
							$body,					//body
							'user',					//part
							'alert alert-info',	//css class
							true,					//format output
							true,						//back link
							array('activeTab'=>'ticket')); //extra argument 
            return;
        }
        //if
 

		 $responses = $temp['response'][0];
		 
         $body .= '
		
		<link href="'.GSMS::$class['template']->info['theme_url'].'css/ticket.css" rel="stylesheet" type="text/css">

		 <div  >
          <div  >
              <h3 id="timeline">'.$tempComment->name.'</h3>
          </div>
          <ul class="timeline">';
		  foreach($responses as $response)
			{
				if($tempComment->userId == $response->userId) 
				{
					$body .='<li class="timeline-inverted">
								<div class="timeline-badge info"><i class="material-icons">face</i></div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">شما</h4>								
								';
				}
				else 
				{
					$body .='<li>
								<div class="timeline-badge success"><i class="material-icons">call</i></div>
									<div class="timeline-panel">
									  <div class="timeline-heading">
										<h4 class="timeline-title">کارشناس پشتیبانی : '.$response->name.'</h4>';
				}
				
				$body .= '
					 <p><small class="text-muted"><i class="material-icons">query_builder</i>'.$response->createDate.'</small></p>
                  </div>
				   <div class="timeline-body">
					   <p>'.str_replace("\n",'<br>',$response->content).' </p>
				   </div>
                </div>
              </li>
					 ';
			}//for
			
			if(count($responses) == 0 )
			{
				$body .= '
					<li>
					<div class="timeline-badge  "><i class="material-icons">person</i></div>
						<div class="timeline-panel">
						  <div class="timeline-heading">
							<h4 class="timeline-title">پاسخ</h4> 
						  </div>
						   <div class="timeline-body">
							   <p>پاسخی داده نشده </p>
						   </div>
						</div>
					  </li>  ';
			}
			$body .= '
					<li class="timeline-inverted">
						<div class="timeline-badge info"><i class="material-icons">face</i></div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">شما</h4>
							<p><small class="text-muted"><i class="material-icons">query_builder</i>'.$tempComment->createDate.'</small></p>
						  </div>
						   <div class="timeline-body">
							   <p>'.str_replace("\n",'<br>',$tempComment->content).' </p>
						   </div>
						</div>
					  </li> ';	
			
              $body .= '</ul>
					  </div>';
			
			
			
			
			$body .= ' 
		
		<br>
		<form action="'.GSMS::$class['template']->info['user_url'].'ticket/insertTicket" name="user_data" method="post" onsubmit="return checkForm()" >
   
				<input type="hidden"   name="parent_id" id="parent_id" value="'.$tempComment->id.'" />
			  
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="form-group   is-empty">
				<label class="control-label">پاسخ</label>
				<textarea  class="form-control" name="content" id="content" ></textarea>
				<span class="material-input"></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="form-group   is-empty">
				<input type="submit" class="btn btn-primary "  name="submit" id="but"  value="ارسال پاسخ"/>
			<span class="material-input"></span></div>
		</div>
	</div>
	
</form>
<div id="checkResult" ></div>

<script>
$("#checkResult").hide("fast");
function checkForm() 
{
	$("#checkResult").hide("fast");
	result  = "" ; 
	
	if( $("#content").val().length < 3 )
		result = result + " متن پاسخ را وارد کنید<br/>" ;
	if(result.length > 1 )
	{
		$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا هاي زير را بررسي کنيد : <br/>"+ result) ;
		$("#checkResult").show("slow");
		return false ; 
	} 
	$("#checkResult").hide("slow");
}
</script> 
		<br>
		<a class="btn btn-success" href="' .GSMS::$class['template']->info['user_url'] . 'ticket/insertTicket/">
			<i class="material-icons">add</i>ثبت تیکت جدید
		</a>
		';

		$inf = array('title' =>  'مشاهده تیکت', 'body' => $body);
		GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
    }

}

//class
// if (!defined("GSMS")) 
    // exit("Access denied");
