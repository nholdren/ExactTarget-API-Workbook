<?php

try
{
 
    $wsdl = 'https://on.exacttarget.com/etframework.wsdl';    
 
    $client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
 
    $client->username = 'username';
    $client->password = 'password';
 
    //Define the query definition
    $query = new ExactTarget_QueryDefinition();
    $query->Name = "Test Query";
    $query->CustomerKey = "TestQuery";
    $query->Description = "Test Query Description";
    $query->TargetUpdateType = "Overwrite";
    $query->TargetType = "DE";
    $query->QueryText = "SELECT * FROM table";
 
    //Set the targeted data extension
    $ibo = new ExactTarget_InteractionBaseObject();
    $ibo->CustomerKey = "Targeted Data Extension";
    $ibo->Name = "Test Send";
    $query->DataExtensionTarget = $ibo;
 
    $query = new SoapVar($query, SOAP_ENC_OBJECT, 'QueryDefinition', "http://exacttarget.com/wsdl/partnerAPI");
 
    //Setup and execute the request
    $request = new ExactTarget_CreateRequest();
    $request->Objects = $query;
    $request->Options = NULL;
    $results = $client->Create($request);
 
    print_r($results);
 
} catch (SoapFault $e) {
    var_dump($e);
}

?>