<?php

$wsdl = 'https://webservice.exacttarget.com/etframework.wsdl';
 
    /* Create the Soap Client */
    $client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
 
    /* Set username and password here */
    $client->username = 'username';
    $client->password = 'password';
 
    $rr = new ExactTarget_RetrieveRequest();
    $rr->ObjectType = "DataExtensionObject[ExampleDE]";   // ExampleDE is the name of the data extension
    $rr->Properties =  array();
    $rr->Properties[] = "SubscriberKey";//Field you would like to return
 
    // Setup a simple filter based on the key column you want to match on
    $left_filter = new ExactTarget_SimpleFilterPart();
    $left_filter->Value =  array($start_date, $end_date);
    $left_filter->SimpleOperator = ExactTarget_SimpleOperators::between;
    $left_filter->Property= "UpdateTime";
 
    $right_filter = new ExactTarget_SimpleFilterPart();
    $right_filter->Value = 'Some Value';
    $right_filter->SimpleOperator = ExactTarget_SimpleOperators::equals;
    $right_filter->Property = 'Name';
 
    //SOAP encode the filters
    $left_filter = new SoapVar($left_filter, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
    $right_filter = new SoapVar($right_filter, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
 
    //Create complex filter
    $cfp = new ExactTarget_ComplexFilterPart();
    $cfp->LeftOperand = $left_filter;
    $cfp->LogicalOperator = ExactTarget_LogicalOperators::_AND;
    $cfp->RightOperand = $right_filter;
 
    //Execute filter       
    $rr->Filter = new SoapVar($cfp, SOAP_ENC_OBJECT, 'ComplexFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
    $rr->Options = NULL;
    $rrm = new ExactTarget_RetrieveRequestMsg();
    $rrm->RetrieveRequest = $rr;       
    $results = $client->Retrieve($rrm); 
 
    var_dump($results);
 
    //Get addition results            
    while ($results->OverallStatus=="MoreDataAvailable") {
 
        $rr = new ExactTarget_RetrieveRequest();
        $rr->ContinueRequest = $results->RequestID;
        $rrm = new ExactTarget_RetrieveRequestMsg();
        $rrm->RetrieveRequest = $rr;
        $results = null;
        $results = $client->Retrieve($rrm);
        $tempRequestID = $results->RequestID;
        print_r($results->OverallStatus.' : '.$results->RequestID.' : '.count($results->Results));                   
 
    }
 
} catch (Exception  $e) {
    var_dump($e);
}

?>