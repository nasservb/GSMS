<?php //allahoma sale ala mohammad va ale mohammad
//class settings for all setting and bug managment choice on view layer start 11-2-91 by nasser niazy in gooya smslearning system

class index
{
	function index($data)
	{
		$inf = array('activeTab'=>'accounting');
		
		GSMS::$class['template']->header($inf);
		
        GSMS::$class['template']->load($inf, 'user_header');
		
	
		$body .= '<div class="content">
				<div class="container-fluid">
					<div class="row">
					
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="red">
									<i class="material-icons">history</i>
								</div>
								<div class="card-content">
									<p class="category">تراکنش های ناموفق</p>
									<h3 class="title">'.(intval($data['failedTransaction'] )>0 ? $data['failedTransaction'] : 'بدون' ).'<small>مورد</small></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons">history</i> تراکنش های ناموفق 
									</div>
								</div>
							</div>
						</div>
					
					
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="blue">
									<i class="material-icons">assignment</i>
								</div>
								<div class="card-content">
									<p class="category">فاکتورهای پرداخت نشده </p>
									<h3 class="title">'.(intval($data['unpayedCount'] )>0 ? $data['unpayedCount'] : 'بدون' ).'<small>مورد</small></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons">assignment</i> فاکتورهای پرداخت نشده 
									</div>
								</div>
							</div>
						</div>
						
						
						
						
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="green">
									<i class="material-icons">done</i>
								</div>
								<div class="card-content">
									<p class="category"> تراکنش های موفق </p>
									<h3 class="title">'.(intval($data['successTransaction'] )>0 ? $data['successTransaction'] : 'بدون' ).'<small>مورد</small></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons">done</i> تراکنش های موفق 
									</div>
								</div>
							</div>
						</div>
						
						

						
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="orange">
									<i class="material-icons">list</i>
								</div>
								<div class="card-content">
									<p class="category">همه  تراکنش ها </p>
									<h3 class="title">'.(intval($data['allTransaction'] )>0 ? $data['allTransaction'] : 'بدون' ).'<small>مورد</small></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons">list</i> همه تراکنش های اینترنتی 
									</div>
								</div>
							</div>
						</div>
						
						
						
					</div>
					
				<a class="btn btn-success" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/insertOnMoney" ><i class="material-icons">payment</i>واریز وجه آنلاین</a> 
				<a class="btn btn-info" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/transactions" ><i class="material-icons">laptop</i>مشاهده تراکنش ها</a>
				<a class="btn btn-primary" href="'.
						GSMS::$class['template']->info['user_url'] 
						.'accounting/listFactures" ><i class="material-icons">reorder</i>مشاهده پیش فاکتورها</a>
				
				
			</div>';
		
		

        $inf = array('title' => 'امور مالی', 'body' => $body);
        GSMS::$class['template']->load($inf,'user_index');
        GSMS::$class['template']->load($inf,'user_footer');
		
	}
}

if (!defined("GSMS")) 
{
    exit("Access denied");
}
?>