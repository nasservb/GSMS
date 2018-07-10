<?php //allahoma sale ala mohammad va ale mohammad
 

class viewFacture
{
    function viewFacture($tempFacture)
    {
        //---------------initializing-----------
        $inf = array('page_title' => 'نمایش صورتحساب ','activeTab' => 'accounting');
        GSMS::$class['template']->header($inf);
        GSMS::$class['template']->load($inf,'admin_header');
		$inf['title'] = $inf['page_title'] ;
		$user=GSMS::$class['session']->getUser();
		$internetTransactions = $tempFacture['internetTransactions'];
		$manTransactions = $tempFacture['manTransactions'];
		$balanceType = $tempFacture['balanceType'];
        //------------------------
		
		$userOrder = $tempFacture['userOrder']; 
		//var_dump($tempFacture['facture']);
		$facture = $tempFacture['facture']; 
        $body = '';
		
		$verifiySt= '';
		
			

        $body .= '
		<div class="message-info table-responsive">
		<table dir="rtl" class="table " >
		<tr><td><img id="imgicon" style="width:20%" src="'. GSMS::$siteURL.GSMS::$outputDir .'assets/images/biglogo.png"/></td><td>';
		if( intval($facture->totalAmount)-intval($facture->recieve)>0)
		{
			$body .= '<div><h4 class="text-danger" >پرداخت نشده</h4></div>';
			 
		}
		else 
		{
			$body .= '<div><h4 class="text-success" >پرداخت شده</h4></div>';
		}
		 $body .= '</td></tr>
		</table>
		<br/>
		<table dir="rtl" class="table table-bordered" >
		
		<tr><td>صورتحساب برای</td><td>پرداخت به</td></tr>
		<tr><td>
		<table dir="rtl" class="table" >
		<tr><td>شماره :</td><td>'.$tempFacture['admin']->id.'</td></tr>
		<tr><td>نام:</td><td>'.$tempFacture['admin']->name . ' ' . $tempFacture['admin']->family.'</td></tr>
		<tr><td>ایمیل:</td><td>'.$tempFacture['admin']->mail.'</td></tr>
		<tr><td>تلفن همراه:</td><td>'.$tempFacture['admin']->mobile.'</td></tr>';
		if(!empty($userOrder) && $userOrder->id>0 ){
			$body .= '
			<tr><td>شماره سفارش:</td><td>'.$userOrder->id.'</td></tr>
			<tr><td>عنوان سفارش:</td><td>'.$userOrder->name.'</td></tr>
			<tr>
			<td>جزییات سفارش</td>
			<td><a class="btn btn-primary btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orders/viewOrderDetail/'.$userOrder->id.'">نمايش</a></td>
			</tr>
			<tr>
			<td>تراکنش مالی سفارش</td>
			<td><a class="btn btn-success btn-sm" href="'.GSMS::$class['template']->info['admin_url'] .'orders/viewOrderFinancialDetail/'.$userOrder->id.'">نمايش</a></td>
			</tr>';
		}
	
		$body .= '</table>
		</td>
		<td>
		
		<table dir="rtl" class="table" >
		
		<tr><td>نام بانک :</td><td> ملت </td></tr>
		<tr><td>شماره حساب :</td><td>45-45467678</td></tr>
		<tr><td>شماره کارت :</td><td>5655-6768-6667-6768</td></tr>
		<tr><td>شماره شبا :</td><td>IR5678800008777564343343</td></tr>
		<tr><td>نام صاحب حساب :</td><td> پرتوی مهر</td></tr>
			
		</table>
		
		</td></tr>
		</table>
		
		<div><h3>شناسه صورتحساب :'.$facture->id.'</h3></div>
		<div><h4>تاریخ صورتحساب :'.$facture->insertDate.'</h4></div>
		<div><h4>تاریخ سررسید :'.$facture->dateDue.'</h4></div>
		<table dir="rtl" class="table table-bordered">
		
		<tr><td>عنوان</td><td>'.$facture->title.'</td></tr>
		<tr><td>مبلغ کل (ريال)</td><td>'.$facture->totalAmount.'</td></tr>
		<tr><td>مبلغ پرداخت شده (ريال)</td><td>'.$facture->recieve.'</td></tr>
		
		<tr><td>وضعیت</td><td>
		<span class="' . ($facture->isaccept>0 ? 'text-success"> فاکتور صادر و تایید شد' : 'text-danger"> در انتظار تایید ' )
						 . '</span>
		</td></tr>
		<tr><td>صادر کننده</td><td>'.$tempFacture['publisher']->name. ' ' . $tempFacture['publisher']->family.'</td></tr>
		<tr><td>نام کاربری صادر کننده</td><td>'.$tempFacture['publisher']->username.'</td></tr>
		'.$verifiySt.'
		<tr><td>توضیحات</td><td>'.$facture->description.'</td></tr>
		</table>
		
		<div><h3>لیست تراکنش های این فاکتور</h3></div>';
		if(count($manTransactions[0]) == 0 && count($internetTransactions[0]) == 0){
			$body .= '<div class="alert alert-danger col-lg-2 col-md-3 col-sm-3 pull-right">این فاکتور تراکنشی ندارد</div>';
		}
		else
		{
			$body .='
			<table class="table table-bordered" >
			<thead class="text-primary">
			<th class="text-right" >شماره تراکنش :</th>
			<th class="text-right">نوع پرداخت</th>
			<th class="text-right">وضعیت</th> 
			<th class="text-right">مبلغ</th>
			<th class="text-right">جزییات</th>
			</thead>
			<tbody>';
			
			//var_dump($internetTransactions);
			for($i=0 ; $i<$manTransactions[2] ; $i++){
				$isAccept = intval($manTransactions[0][$i]->isAccept);
				$body .= '<tr>
				<td>'.$manTransactions[0][$i]->id.'</td><td>';
				foreach($balanceType as $typeValue){
					if($typeValue['id']==$manTransactions[0][$i]->manualtransTypeId)
					{
						$body .= $typeValue['name'];
						break;
					}	
				}
				$body .= '</td>
				<td'.($isAccept > 0 ? ' class="text-success"> تایید شده' : ' class="text-danger"> تایید نشده').'</td>
				<td>'.$manTransactions[0][$i]->totalAmount.'</td>
				<td><a  class="btn btn-primary" href=\''.GSMS::$class['template']->info['admin_url'].'accounting/viewReceipt/' 
						. $manTransactions[0][$i]->id . '\'>نمایش</a></td>
				</tr>';
			}
			for($i=0 ; $i<$internetTransactions[2] ; $i++){
				
				$body .= '<tr>
				<td>'.$internetTransactions[0][$i]->id.'</td>
				<td>پرداخت آنلاین</td>
				<td'.(empty($internetTransactions[0][$i]->refNum) ? ' class="text-danger"> ناموفق' : ' class="text-success"> موفق')
				.'</span>
				</td>
				<td>'.$internetTransactions[0][$i]->totalAmount.'</td>
				<td><a  class="btn btn-primary" href=\''.GSMS::$class['template']->info['admin_url'].'accounting/viewIntTrans/' 
						. $internetTransactions[0][$i]->id . '\'>نمایش</a></td>
				</tr>';
			}
			
			$body .= '
			</tbody>
			</table>';
		}
		
		$body .='</div><br/>';

        $inf['body'] = $body ;
        GSMS::$class['template']->load($inf,'admin_index');
        GSMS::$class['template']->load($inf,'admin_footer');
    }

}

//class
if (!defined("GSMS")) {
    exit("Access denied");
}