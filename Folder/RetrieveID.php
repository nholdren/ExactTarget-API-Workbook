<?php

try{ 
 
    $wsdl = 'https://on.exacttarget.com/etframework.wsdl'; 
 
    //Create the Soap Client
    $client = new ExactTargetSoapClient($wsdl, array('trace'=>1)); 
 
    //Set the username and password
    $client->username = 'username';
    $client->password = 'password';
 
    //First find the parent folder
    $filter = new ExactTarget_SimpleFilterPart();
    $filter->Property = "Name";
    $filter->SimpleOperator = ExactTarget_SimpleOperators::equals;
    $filter->Value = array('Data Extensions'); //Other possibilities include Emails, or any other folder name
 
    //Encode the filter object
    $filter = new SoapVar($filter, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
 
    //Setup and execute the request
 
    $rr = new ExactTarget_RetrieveRequest();
    $rr->ObjectType = 'DataFolder';
    $rr->Properties = array("ID", "Name");
    $rr->Filter = $filter;
    $rrm = new ExactTarget_RetrieveRequestMsg();
    $rrm->RetrieveRequest = $rr;
    $results = $client->Retrieve($rrm);
 
    print_r($results);
 
}catch(SoapFault $e) {
 
    var_dump($e);
 
}

?>