
<?php //allahoma sale ala mohammad va ale mohammad
class viewTicket

{
	function viewTicket($temp)
	{
		$body = '';
		$tempTicket = $temp['ticket'];
		

		// if
		$responses = $temp['response'][0];

		$body.= '
		<link href="'.GSMS::$class['template']->info['theme_url'].'css/ticket.css" rel="stylesheet" type="text/css">

		 <div  >
          <div  >
              <h3 id="timeline">'.$tempTicket->name.'</h3>
          </div>
          <ul class="timeline">';
		  $body .= '
					<li class="timeline-inverted">
						<div class="timeline-badge info"><i class="material-icons">face</i></div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">'.$tempTicket->ownerName.'</h4>
							<p><small class="text-muted"><i class="material-icons">query_builder</i>'.$tempTicket->createDate.'</small></p>
						  </div>
						   <div class="timeline-body">
							   <p>'.str_replace("\n",'<br>',$tempTicket->content).' </p>
						   </div>
						</div>
					  </li> ';	
		  if(count($responses) > 0 )
		  {
			
			foreach($responses as $response)
			{
				if($tempTicket->userId == $response->userId) 
				{
					
					$body .='<li class="timeline-inverted">
								<div class="timeline-badge info"><i class="material-icons">face</i></div>
									<div class="timeline-panel">
										<div class="timeline-heading">
											<h4 class="timeline-title">'.$response->ownerName.'</h4>								
								';
				}
				else 
				{
					$body .='<li>
								<div class="timeline-badge success"><i class="material-icons">call</i></div>
									<div class="timeline-panel">
									  <div class="timeline-heading">
										<h4 class="timeline-title">'.$response->ownerName.'</h4>';
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
		  }
		  else 
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
			
			
              $body .= '</ul>
					  </div>';
			
			
			
			
			$body .= ' 
		
		<br>
		<form  name="user_data" method="post" onsubmit="return checkForm()" >
   
				<input type="hidden"   name="ticket_id" id="ticket_id" value="'.$tempTicket->id.'" />
			  
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
		';
		GSMS::$class['template']->message('مشاهده تیکت', $body, $temp['level'], '', false, false, array(
			'activeTab' => 'tickets'
		));
	}
}

// class

if (!defined("GSMS"))
{
	exit("Access denied");
}

