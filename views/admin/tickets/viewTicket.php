
<?php //allahoma sale ala mohammad va ale mohammad
class viewTicket

{
	function viewTicket($temp)
	{
		$body = '';
		$tempComment = $temp['comment'];
		if (!is_object($tempComment))
		{
			$body = ' تیکت یافت نشد  ' ;
            GSMS::$class['template']->message(
				'مشاهده تیکت' ,		//title
				$body,					//body
				'user',					//part
				'alert alert-danger',	//css class
				true,					//format output
				true,						//back link
				array('activeTab'=>'ticket')); //extra argument 
            return;
		}

		// if

		$body.= '
		<div class="table-responsive">
		<table class="table table-bordered">';
		$responses = $temp['response'][0];
		if(count($responses) == 0 )
		{
			$body .= '
				<thead class="text-primary">
				<th class="text-right" >پاسخ</th>
			</thead>
			<tbody>
			<tr>
				<td class="text-danger">پاسخی داده نشده </td>
			</tr>';
		}
		else
		{
			$body .= '
			<thead class="text-primary">
				<th class="text-right" >تاریخ </th>
				<th class="text-right" >پاسخ</th>
				<th class="text-right" >پاسخگو</th>
			</thead>
			<tbody>';
		}
		foreach($responses as $response)
		{
			$body .= '
			<tr>
				<td>'.$response->createDate.'</td>
				<td>'.$response->content.'</td>
				<td>'.$response->name.'</td>
			</tr>';
		}
		
		$body.= '
		</tbody>
		</table>	
		<br />
		<br />
		<table class="table table-bordered">
    <tr>
		<td>نویسنده </td>
		<td>' . $tempComment->name . '</td>
	</tr>
	<tr>	
		<td>ایمیل </td>
		<td>' . $tempComment->email . '</td>
	</tr>	
	<tr>	
		<td>تاریخ</td>
		<td>' . $tempComment->createDate . '</td>
	</tr>	
	<tr>	
		<td>متن</td>
		<td>' . str_replace(chr(13) , '<br/>', $tempComment->content) . '</td>
	</tr>	 
	<tr>	
		<td>پاسخ</td>	
		<td>
			<form method="post" onSubmit="return checkForm()">
				<textarea name="content" id="content" class="form-control"></textarea>
				<input type="hidden" name="ticket_id" id ="ticket_id" value="' . $tempComment->id . '"  />
				<button type="submit" class="btn btn-success">
					ارسال
				</button>
			</form>
		</td>
		
	</tr>';
		$body.= '</table>
		<br/>
		<div id="checkResult" class="col-sm-6 pull-right"></div>
		
		</div>';
		$body.= '<br/><a class="btn btn-danger" href="' . GSMS::$class['template']->info['admin_url'] . 'tickets/deleteTicket/' . $tempComment->id . '">
				حذف
			</a>';
		$body .= '
		<script>  
			$("#checkResult").hide("fast");
			function checkForm() 
			{
				result  = "" ;
				if($("#content").val()  < 1 ){
						result = result + "متن پاسخ وارد نشده است.<br/>" ;
				}
				if(result.length > 1 )
				{
					$("#checkResult").addClass("alert alert-danger").html("لطفآ خطا هاي زير را بررسي کنيد : <br/>"+ result) ;
					$("#checkResult").show("slow");
					return false ; 
				} 
				$("#checkResult").hide("slow");
				return true ;
			}
		</script>
		';
		GSMS::$class['template']->message('مشاهده تیکت', $body, 'admin', '', false, false, array(
			'activeTab' => 'tickets'
		));
	}
}

// class

if (!defined("GSMS"))
{
	exit("Access denied");
}

