<?php

    $wsdl = 'https://on.exacttarget.com/etframework.wsdl';    
 
    $client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
 
    $client->username = 'username';
    $client->password = 'password';
 
    $portfolio = new ExactTarget_Portfolio();
    $portfolio->DisplayName = '';
    $portfolio->CustomerKey = '';
    $portfolio->Source = new ExactTarget_ResourceSpecification();
 
    //Define the file properties
    $portfolio->Source->URN = '';
    $portfolio->FileName = '';
 
    $portfolio = new SoapVar($query, SOAP_ENC_OBJECT, 'Porfolio', "http://exacttarget.com/wsdl/partnerAPI");
 
    //Setup and execute the request
    $request = new ExactTarget_CreateRequest();
    $request->Objects = $portfolio;
    $request->Options = NULL;
    $results = $client->Create($request);

?>