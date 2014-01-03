<?php

//The API endpoint
$wsdl = 'https://on.exacttarget.com/etframework.wsdl'; 
 
try{ 
        //Create the Soap Client 
        $client = new ExactTargetSoapClient($wsdl, array('trace'=>1)); 
 
        //Set the username and password
        $client->username = 'username'; 
        $client->password = 'password';
 
        //Create the ExactTarget data extension object
        $DE = new ExactTarget_DataExtensionObject();
        $DE->CustomerKey = 'CustomerKey'; 
 
        //Initialize properties array
        $properties = Array();
 
        //Define email properties
        $properties[0] = new ExactTarget_APIProperty();
        $properties[0]->Name = 'email';
        $properties[0]->Value = 'n@nickholdren.com';
 
        $properties[1] = new ExactTarget_APIProperty();
        $properties[1]->Name = 'update_time';
        $properties[1]->Value = date('c');
 
        //Assign properties to the data extension and build SOAP package              
        $DE->Properties = $properties;
        $object = new SoapVar($DE, SOAP_ENC_OBJECT, 'DataExtensionObject', "http://exacttarget.com/wsdl/partnerAPI"); 
 
        // Asynchronous Options
        $opt = new ExactTarget_UpdateOptions;
        $opt->RequestType = ExactTarget_RequestType::Asynchronous;
        $opt->RequestTypeSpecified = true;
        $opt->SendResponseTo->ResponseType = ExactTarget_AsyncResponseType::email;
        $opt->SendResponseTo->ResponseAddress = 'myemail@email.com';
 
        // Respond when call is complete
        $opt->SendResponseTo->RespondWhen = ExactTarget_RespondWhen::OnCallComplete;
 
        // Include objects and results
        $opt->SendResponseTo->IncludeObjects = true;
        $opt->SendResponseTo->IncludeObjectsSpecified = true;
        $opt->SendResponseTo->IncludeResults = true;
        $opt->SendResponseTo->IncludeResultsSpecified = true;
        $opt->SendResponseTo->OnlyIncludeBase = false;
 
        //Create update request object
        $request = new ExactTarget_UpdateRequest();
 
        //Create an Upsert command
        $saveOpt = new ExactTarget_SaveOption();
        $saveOpt->SaveAction = ExactTarget_SaveAction::UpdateAdd;
        $saveOpt->PropertyName = $DE;
 
        //Add the options to the array
        $options = array();
        $options[] = $saveOpt;
        $options[] = $opt;
 
        //Build the request
        $request->Options = $options;
        $request->Objects = array($object); 
        $results = $client->Update($request);
 
}catch(SoapFault $e) {
 
    var_dump($e);
 
}

?>