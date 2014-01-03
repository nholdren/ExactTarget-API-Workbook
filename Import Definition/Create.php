<?php

 $wsdl = 'https://webservice.exacttarget.com/etframework.wsdl';
     
    /* Create the Soap Client */
    $client = new ExactTargetSoapClient($wsdl, array('trace'=-->1));
     
    /* Set username and password here */
    $client->username = 'username';
    $client->password = 'password';
     
    //Create the Import Definition on the fly
    $id = new ExactTarget_ImportDefinition();
    $id->Name = 'Test Import Defintion';
    $id->Description = 'This is a test import definition creation';
    $id->AllowErrors = true;
    $id->AllowErrorsSpecified = true;
    $id->UpdateType = ExactTarget_ImportDefinitionUpdateType::AddAndUpdate;
    $id->UpdateTypeSpecified = true;
     
    //Create a clientID object, so that correct business unit can be targeted
    $co = new ExactTarget_ClientID();
    $co->ID = 12345; // This is the ID of the business unit
    $id->Client = $co;
     
    $de = new ExactTarget_DataExtension();
    $de->CustomerKey = 'DataExtensionName';
    $id->DestinationObject =  new SoapVar($de, SOAP_ENC_OBJECT, 'DataExtension', 'http://exacttarget.com/wsdl/partnerAPI');
     
    //Specify the notification type
    $notificiation = new ExactTarget_AsyncResponse();
    $notificiation->RespondWhen = ExactTarget_RespondWhen::OnConversationComplete;
    $notificiation->ResponseType = ExactTarget_AsyncResponseType::email;
    $notificiation->ResponseAddress = 'MyEmailAddress@test.com';
     
    $id->Notification = new SoapVar($notificiation, SOAP_ENC_OBJECT, 'AsyncResponse', 'http://exacttarget.com/wsdl/partnerAPI');
                 
    //Specify the File Transfer Location (where it is coming from) (required)
    $id->RetrieveFileTransferLocation = new ExactTarget_FileTransferLocation();
    $id->RetrieveFileTransferLocation->CustomerKey = 'ExactTarget Enhanced FTP';
     
    //Map fields (required)
    $id->FieldMappingType = ExactTarget_ImportDefinitionFieldMappingType::InferFromColumnHeadings;
    $id->FieldMappingTypeSpecified = true;
     
    //Specify the file naming specifications
    $id->FileSpec = 'MyTestFile.csv';
     
    //Specify the file type
    $id->FileType = ExactTarget_FileType::CSV;
    $id->FileTypeSpecified = true;
     
    $idObject = new SoapVar($id, SOAP_ENC_OBJECT, 'ImportDefinition', 'http://exacttarget.com/wsdl/partnerAPI');
     
    $pr = new ExactTarget_PerformRequestMsg();
    $pr->Action = 'start';
    $pr->Definitions->Definition = $idObject;
     
    $results = $client->Perform($pr);
                 
?>

