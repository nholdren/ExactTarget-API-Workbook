<?php

try{
 
    $wsdl = 'https://on.exacttarget.com/etframework.wsdl';
 
    //Create the Soap Client 
    $client = new ExactTargetSoapClient($wsdl, array('trace'=>1)); 
 
    //Set the username and password
    $client->username = 'username'; 
    $client->password = 'password';
 
    $folder = new ExactTarget_Folder();
    $folder->Name = 'My New Folder';
    $folder->CustomerKey = 'My New Folder';
    $folder->Description = 'An Example of a folder created through the API';
    $folder->IsActive = true;
    $folder->IsEditable = true;
    $folder->AllowChildren = true;
 
    //Reference the parent folder to create new folder below it
    $folder->ParentFolder = new ExactTarget_Folder();
    $folder->ParentFolder->ID = $parent_folder_id;
    $folder->ParentFolder->IDSpecified = true;
    $folder->ContentType = 'dataextension'; //Other possibilities include email
 
    //Encode the filter object
    $folder = new SoapVar($folder, SOAP_ENC_OBJECT, 'DataFolder', "http://exacttarget.com/wsdl/partnerAPI");
 
    //Setup and execute the request
    $request = new ExactTarget_CreateRequest();
    $request->Objects = $folder;
    $request->Options = NULL;
    $results = $client->Create($request);
 
    print_r($results);
 
}catch(SoapFault $e) {
 
    var_dump($e);
 
}

?>