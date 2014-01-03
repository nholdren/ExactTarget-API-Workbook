<?php

try
{
 
    $wsdl = 'https://on.exacttarget.com/etframework.wsdl';    
 
    $client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
 
    $client->username = 'username';
    $client->password = 'password';
 
    $content_area = new ExactTarget_ContentArea();
    $content_area->Name = 'My Example Content Area';
    $content_area->Content = 'Hello World';
 
    $content_area = new SoapVar($content_area, SOAP_ENC_OBJECT, 'ContentArea', "http://exacttarget.com/wsdl/partnerAPI");
 
    //Setup and execute the request
    $request = new ExactTarget_CreateRequest();
    $request->Objects = $content_area;
    $request->Options = NULL;
    $results = $client->Create($request);
 
    print_r($results);
 
} catch (SoapFault $e) {
    var_dump($e);
}

?>