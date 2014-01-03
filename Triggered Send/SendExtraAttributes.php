<?php

$wsdl = 'https://webservice.exacttarget.com/etframework.wsdl';
 
try{
 
    //Create the Soap Client
    $client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
 
    // Set username and password here
    $client->username = 'username';
    $client->password = 'password';
 
    //Define the subscriber
    $subscriber = new ExactTarget_Subscriber();
    $subscriber->EmailAddress = 'test@test.com';
    $subscriber->SubscriberKey = 'test@test.com';
 
    //Define the attribute
    $company = new ExactTarget_Attribute();
    $company->Name = 'company_name';
    $company->Value = 'attribute_value';
 
    //Define the triggered send
    $ts = new ExactTarget_TriggeredSend();
    $ts->TriggeredSendDefinition = new ExactTarget_TriggeredSendDefinition();
    $ts->TriggeredSendDefinition->CustomerKey = 'TriggeredSendCustomerKey';
    $ts->TriggeredSendDefinition->Priority = "High";
 
    //Define the request options
    $options = new ExactTarget_CreateOptions();
    $options->RequestType = ExactTarget_RequestType::Asynchronous;
    $options->RequestTypeSpecified = true;
    $options->QueuePriority = ExactTarget_Priority::High;
    $options->QueuePrioritySpecified = true;
 
    //Add the subscriber
    $ts->Subscribers[] = $subscriber;
 
    //SOAP encode the triggered send object
    $ts = new SoapVar($ts, SOAP_ENC_OBJECT,'TriggeredSendDefinition', "http://exacttarget.com/wsdl/partnerAPI");
 
    //Execute
    $request = new ExactTarget_CreateRequest();
    $result = $client->Create($request);
 
    var_dump($result);
 
} catch (SoapFault $e) {
 
    var_dump($e);
}?>