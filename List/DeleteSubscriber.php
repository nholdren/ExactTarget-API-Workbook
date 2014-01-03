<?php

$wsdl = 'https://webservice.s6.exacttarget.com/etframework.wsdl';
     
$client = new ExactTargetSoapClient($wsdl, array('trace' => 1));
$client->username = 'username';
$client->password = 'password';
 
$sub = new ExactTarget_Subscriber();
$sub->EmailAddress = 'bill@msn.com';
            
$subList = new ExactTarget_SubscriberList();
$subList->ID = 11902;
$subList->Status = ExactTarget_SubscriberStatus::Active;
$subList->Action = "delete";
            
$sub->Lists = array($subList);
            
$object = new SoapVar($sub, SOAP_ENC_OBJECT, 'Subscriber', "http://exacttarget.com/wsdl/partnerAPI");
$request = new ExactTarget_UpdateRequest();
$request->Options = NULL;
$request->Objects = array($object);
$results = $client->Update($request);


?>