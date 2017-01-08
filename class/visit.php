<?php //allahoma sale ala mohammad va ale mohammad 

//class for contain all photo functionality on control(controller) layer start 24-7-93 by nasser niazy
class visit
{
	public $id;
	public $date;
	public $time;
	public $ip;
	public $referrer;
	public $device;
	public $screen;
	public $admin;
	public $os;
	public $browser;
	public $isMobile;
	public $part;
	public $data;
	
	public $isAds;
	public $planRegisteredId;
	public $price;

 	public function __construct()
	{
		GSMS::load('log','class');	
		$this->id=0;
       
		$this->date=GSMS::$class['calendar']->now();
		GSMS::$class['system_log']->log('DEBUG','visit class Initialized');
	}//fun
	
	 function __set($propertyName,$propertyValue)
	 {
		$this->propertyName=$propertyValue;
	 }//fun

	 public function save()
	 {
		 // $tempVisit = R::dispense('visit');
		 // if($this->id != 0)
		 // {
			// $tempVisit = R::load('visit',$this->id);
		 // }
		
		$row='';
		$max=0;	
		GSMS::$class['DB']->run(
				 'INSERT INTO `visit`(
					 `id`, 
					 `date`, 
					 `time`,
					 `ip`,
					 `device`, 
					 `screen`, 
					 `admin`, 
					 `os`, 
					 `browser`, 
					 `is_mobile`, 
					 `part`, 
					 `data`, 
					 `is_ads`, 
					 `plan_registered_id`, 
					 `price`, 
					 `referrer`) 
				 VALUES 
					 (NULL,
					 \''.$this->date.'\',
					 \''.$this->time.'\',
					 \''.$this->ip.'\',
					 \''.$this->device.'\',
					 \''.$this->screen.'\',
					 \''.$this->admin.'\',
					 \''.$this->os.'\',
					 \''.$this->browser.'\',
					 \''.$this->isMobile.'\',
					 \''.$this->part.'\',
					 \''.$this->data.'\',
					 \''.$this->isAds.'\',
					 \''.$this->planRegisteredId.'\',
					 \''.$this->price.'\',
					 \'\')'
		,
								'visit.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'log visit'	//sql code subject	
								);
		 				
		

		 //$this->id = R::store( $tempVisit );
		
	 }//func
	
	 public function log($part,$data='')
	 {
		 

		 $useragent=$_SERVER['HTTP_USER_AGENT'];

		$tempPlan = new visit() ;
		
		$tempPlan->date =  GSMS::$class['calendar']->date('Y-m-d');		
		$tempPlan->time = date( 'H:i:s');		
		$tempPlan->ip = GSMS::$class['input']->ip_address();			
		$tempPlan->referrer='';	
		$tempPlan->device='';		
		$tempPlan->screen='';		
		$tempPlan->admin='';		
		$tempPlan->os=$useragent;			
		$tempPlan->browser='';	
		$tempPlan->part=$part;	
		$tempPlan->data=$data;	
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		
			$tempPlan->isMobile=1;	
		else 
			$tempPlan->isMobile=0;

		
		$tempPlan->save();

		
	 }
	 
	 public function logAds($part,$plan, $price)
	 {
		 
		
		 $tempVisit = new visit();
		 $tempVisit->date				=GSMS::$class['calendar']->date('Y-m-d');		
		 $tempVisit->time				= date( 'H:i:s');	
		 $tempVisit->ip					= GSMS::$class['input']->ip_address();	
		 $tempVisit->referrer			='';
		 $tempVisit->device				='';
		 $tempVisit->screen				='';
		 $tempVisit->admin				='';
		 $tempVisit->os					=$useragent;	
		 $tempVisit->browser			='';
		 
		 
		 $tempVisit->part				=$part;	
		 $tempVisit->data				='';
		 
		 $tempVisit->isAds 				=1 	;
		 $tempVisit->planRegisteredId	=$plan	;
		 $tempVisit->price				=$price	;
		
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		
			$tempVisit->isMobile=1;	
		else 
			$tempVisit->isMobile=0;


		$row='';
		$max=0;	
		GSMS::$class['DB']->run(
				 'INSERT INTO `adsvisit`(
					 `id`, 
					 `date`, 
					 `time`,
					 `ip`,
					 `device`, 
					 `screen`, 
					 `admin`, 
					 `os`, 
					 `browser`, 
					 `is_mobile`, 
					 `part`, 
					 `data`, 
					 `is_ads`, 
					 `plan_registered_id`, 
					 `price`, 
					 `referrer`) 
				 VALUES 
					 (NULL,
					 \''.$tempVisit->date.'\',
					 \''.$tempVisit->time.'\',
					 \''.$tempVisit->ip.'\',
					 \''.$tempVisit->device.'\',
					 \''.$tempVisit->screen.'\',
					 \''.$tempVisit->admin.'\',
					 \''.$tempVisit->os.'\',
					 \''.$tempVisit->browser.'\',
					 \''.$tempVisit->isMobile.'\',
					 \''.$tempVisit->part.'\',
					 \''.$tempVisit->data.'\',
					 \''.$tempVisit->isAds.'\',
					 \''.$tempVisit->planRegisteredId.'\',
					 \''.$tempVisit->price.'\',
					 \'\')'
		,
								'visit.php',	//file of code
								$row,			//variable to return first row			
								$max,			//variable to return row count	
								'log visit'	//sql code subject	
								);
		 		
	 }
	 
	 public function getCount()
	 {
		$tempComment = R::dispense('visit');
		$row = R::getAll('select count(`id`)as cnt from  `visit` ');
		return  $row[0]['cnt'];
	
	 }//func
	
}//class
 if ( !defined( "GSMS" ) )
{
    exit( "Access denied" );
}
