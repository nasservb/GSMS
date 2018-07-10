<?php //allahoma sale ala mohammad va ale mohammad
include('/usr/share/pear/nusoap.php');
require_once('nusoap.php');
$soapclient = new soapclient('http://Acquirer.sb24.com/ref-payment/ws/ReferencePayment?WSDL','wsdl');
$soapProxy = $soapclient->getProxy() ;
$res=  $soapProxy->ReverseTransaction("Refrence Number","MTID","Password","Reverse Number");#reference number,sellerid,password,reverse amount
if( $res == 1 )
	echo 'reversed successfully' ;
else
	echo 'reversed failed' ;
?>
