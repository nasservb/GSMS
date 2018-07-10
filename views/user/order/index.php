<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class index
{
	function index($data)
	{
		$inf = array('activeTab'=>'orders','activeTab'=>'orders');
		
		GSMS::$class['template']->header($inf);
		
        GSMS::$class['template']->load($inf, 'user_header');
		
	
		$body .= '<div class="content">
				<div class="container-fluid">
				

					<a class="btn btn-success" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/orderRegister" ><i class="material-icons">add</i> ثبت سفارش جدید</a>
	
					<a class="btn btn-warning" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/taxOrderRegister" ><i class="material-icons">add</i> ثبت سفارش مالیاتی</a>
	
					<a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'orders/allOrders" ><i class="material-icons">list</i>لیست همه سفارش ها</a>
				

					<div class="row">
								
								
								
						<div class="col-lg-6 col-md-12">
							<div class="card">
	                            <div class="card-header" data-background-color="orange">
	                                <h4 class="title">سفارش های مالیاتی</h4>
	                            </div>
	                            <div class="card-content table-responsive">
	                                <table class="table table-hover">
	                                    <thead class="text-warning">
	                                        <tr>
	                                    	<th>عنوان</th>
	                                    	<th>تاریخ ثبت</th>
	                                    	<th>وضعیت</th>
	                                    	<th><i class="material-icons">visibility</i></th>
	                                    </tr></thead>
	                                    <tbody>
	                                        ';
											
	                               for($i = 0; $i < intval($data['taxOrders'][2]); $i++)
								   {	
										$status='';
										for($j = 0; $j < count($data['orderStatus']); $j++)
										{
											if(intval($data['orderStatus'][$j]['id']) == $data['taxOrders'][0][$i]->statusId)
												$status=$data['orderStatus'][$j]['status'];
										}
									
										$body .='<tr>
	                                        	<td>'.$data['taxOrders'][0][$i]->name.'</td>
	                                        	<td>'.$data['taxOrders'][0][$i]->createDate.'</td>
	                                        	<td>'.$status.'</td>
												<td><button onclick="goView('.$data['taxOrders'][0][$i]->id.')" type="button" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="نمایش سفارش">
														<i class="material-icons">visibility</i>
													</button></td>
	                                        </tr>';
								   }
								   if(intval($data['taxOrders'][2]) == 0 )
									  $body .= '<tr><td></td><td>موردی یافت نشد</td></tr>';
								  
									$body .='</tbody>
	                                </table>
	                            </div>
	                        </div>
						</div>




						
						<div class="col-lg-6 col-md-12">
							<div class="card card-nav-tabs">
								<div class="card-header" data-background-color="purple">
									<div class="nav-tabs-navigation">
										<h4 class="title">لیست سفارش ها										
										</h4>
									</div>
								</div>
								<script>
									function goEdit(id){
										document.location="'.GSMS::$class['template']->info['user_url'].'orders/editOrder/"+id ;
									}
									function goView(id){
										document.location="'.GSMS::$class['template']->info['user_url'].'orders/viewOrderDetail/"+id ;
									}
								</script>
								<div class="card-content">
									<div class="tab-content">
										<div class="tab-pane active" id="profile">
											<table class="table table-hover">
	                                    <thead class="text-info">
	                                        <tr>
	                                    	<th>عنوان</th>
	                                    	<th>تاریخ ثبت</th>
	                                    	<th>وضعیت</th>
	                                    	<th><i class="material-icons">visibility</i></th>
	                                    </tr></thead>
	                                    <tbody>';
								for($i = 0; $i < count($data['simpleOrder'][0]); $i++)
								{	
									$status='';
									for($j = 0; $j < count($data['orderStatus']); $j++)
									{
										if(intval($data['orderStatus'][$j]['id']) == $data['simpleOrder'][0][$i]->statusId)
											$status=$data['orderStatus'][$j]['status'];
									}
								
									$body .='<tr>
											<td>'.$data['simpleOrder'][0][$i]->name.'</td>
											<td>'.$data['simpleOrder'][0][$i]->createDate.'</td>
											<td>'.$status.'</td>
											<td><button onclick="goView('.$data['simpleOrder'][0][$i]->id.')" type="button" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="نمایش سفارش">
													<i class="material-icons">visibility</i>
												</button></td>
										</tr>';
								}
								if(intval($data['simpleOrder'][2]) == 0 )
									  $body .= '<tr><td></td><td>موردی یافت نشد</td></tr>';
								  					
								$body .='
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
										
						
						
						
						
					</div>
				</div>
			
			</div>';
		
		

        $inf = array('title' => 'ليست سفارش ها', 'body' => $body);
        GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
		
	}
}

if (!defined("GSMS")) 
{
    exit("Access denied");
}
?>