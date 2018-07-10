<?php //allahoma sale ala mohammad va ale mohammad
/***********************************************************************************
      Sample code for working with Saman Electronic Payment webservices and PHP 5+
      (C) 2008, By Amir Hosein Rushenas (rushenas@sep.ir) under the license of GPL.
      For more information about GPL, please refer to www.gnu.org/licenses/gpl.html
***********************************************************************************/

      $client = new SoapClient("https://acquirer.sb24.com/ref-payment/ws/ReferencePayment?WSDL");

      # In case https doesn't work, comment above line, then uncomment the following line
      # $client = new SoapClient("http://acquirer.sb24.com/ref-payment/ws/ReferencePayment?WSDL");

      $result = $client->VerifyTransaction("RefNum", "merchant_id");

      if ( $result <= 0 )
            echo 'Verification failed:'.$result;
      else
            echo 'It verified. The amount of transaction is: '.$result;
?>