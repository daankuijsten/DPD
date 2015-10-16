<?php

	require_once 'vendor/autoload.php';
	
use MCS\DPDAuthorisation;
use MCS\DPDShipment;
	
try{
    // Authorize
    $authorisation = new DPDAuthorisation([
        'staging' => true,
        'delisId' => '<delisId>',
        'password' => '<password>',
        'messageLanguage' => 'en_EN',
        'customerNumber' => '<customerNumber>'
    ]);

    // Init the shipment with authorisation
    $shipment = new DPDShipment($authorisation);

    // Set the language for the track&trace link
    $shipment->setTrackingLanguage('nl_NL');

    // Enable saturday delivery
    $shipment->setSaturdayDelivery(true);   

    // Enable DPD B2C delivery method
    $shipment->setPredict([
        'channel' => 'email',
        'value' => 'someone@mail.com',
        'language' => 'EN'
    ]);

    // Set the general shipmentdata
    $shipment->setGeneralShipmentData([
        'product' => 'CL',
        'mpsCustomerReferenceNumber1' => 'Test shipment'
    ]);

    // Set the printer options
    $shipment->setPrintOptions([
        'printerLanguage' => 'PDF',
        'paperFormat' => 'A6',
    ]);     

    // Set the sender's address
    $shipment->setSender([
        'name1' => 'Your Company',
        'street' => 'Street 12',
        'country' => 'NL',
        'zipCode' => '1234AB',
        'city' => 'Amsterdam',
        'email' => 'contact@yourcompany.com',
        'phone' => '1234567645'
    ]);

    // Set the receiver's address
    $shipment->setReceiver([
        'name1' => 'Joh Doe',         
        'name2' => null,       
        'street' => 'Street',       
        'houseNo' => '12',    
        'zipCode' => '1234AB',     
        'city' => 'Amsterdam',        
        'country' => 'NL',           
        'contact' => null,        
        'phone' => null,                 
        'email' => null,             
        'comment' => null 
    ]);

    // Add as many parcels as you want
    $shipment->addParcel([
        'weight' => 3000, // In gram
        'height' => 10, // In centimeters
        'width' => 10,
        'length' => 10
    ]);

    $shipment->addParcel([
        'weight' => 5000, // In gram
        'height' => 20, // In centimeters
        'width' => 30,
        'length' => 20
    ]);

    // Submit the shipment
    $shipment->submit();

    // Get the trackingdata
    $trackinglinks = $shipment->getParcelResponses();

    // Show the pdf label
    header('Content-Type: application/pdf');
    echo $shipment->getLabels();


}catch(Exception $e){
    echo $e->getMessage();		
}



