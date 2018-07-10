<?php //allahoma sale ala mohammad va ale mohammad
include('/usr/share/pear/nusoap.php');
require_once('nusoap.php');
$soapclient = new soapclient('https://Acquirer.sb24.com/ref-payment/ws/ReferencePayment?WSDL','wsdl');
#$soapclient->debug_flag=true;
$soapProxy = $soapclient->getProxy() ;
#if( $err = $soapclient->getError() )
#	echo $err ;
#echo $soapclient->debug_str;
$res=  $soapProxy->VerifyTransaction("Refrence Number","MTID");#reference number and sellerid
if( $res <= 0 )
	echo 'verification failed' ;
else
{
	echo 'it verified';
	echo $res ;
}
?>
