<?php
require_once('vendor/autoload.php');


$client = new \GuzzleHttp\Client();

$providerToken = "**" ;

$response = $client->request('POST', 'https://app.tillersystems.com/api/auth', [
    'headers' => [
        'accept' => 'application/json',
        'content-type' => 'application/json',
    ],
    'body' => '{"login":"**","password":"**","provider_token":"' . $providerToken . '"}'
]);


$tillerResponse = json_decode($response->getBody(), true);

if (isset($page)){
    $page->json->phpToJson($tillerResponse, 'tiller');
} else {
    $this->json->phpToJson($tillerResponse, 'tiller');
}

$token = $tillerResponse['token'];



function newOrder( $token, $providerToken, $clientData):string{
    $client = new \GuzzleHttp\Client();

    $cutDate = explode(" ", $clientData['finalDate']) ;
    $cutHour = explode(":", $cutDate[1]) ;
    $finalDate = $cutDate[0]." ".($cutHour[0] - 1).":".$cutHour[1] ;
    $jsonData = '{
    "provider_token": "'.$providerToken.'",
    "restaurant_token": "'.$token.'",
    "externalId": "'.sha1(time().$clientData['nom']).'",
    "type": 2,
    "status": "WAITING",
    "openDate": "'.$finalDate.'",
    "nbCustomers" : "'.$clientData['nPersonne'].'",
    "customer": {
      "firstname": "'.$clientData['nom'].'",
      "lastname": "'.$clientData['prenom'].'",
      "phone": "'.$clientData['phone'].'",
      "email": "'.$clientData['mail'].'"
  }
}' ;

    $response = $client->request('POST', 'https://app.tillersystems.com/api/orders', [
        'body' => $jsonData,
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
    ]);

    return $response->getBody();
}

function getOrders($page, $token, $providerToken):array{
    $client = new \GuzzleHttp\Client();

    $response = $client->request('GET', 'https://app.tillersystems.com/api/orders?restaurant_token='.$token.'&provider_token='.$providerToken.'&page=1&maxResults=null&customerInvoice=false', [
        'headers' => [
            'accept' => 'application/json',
        ],
    ]);
    $tillerOrderResponse = json_decode($response->getBody(), true);

    $page->json->phpToJson($tillerOrderResponse,'tiller_orders') ;
    return $tillerOrderResponse ;
}

function getBooking($page, $token, $providerToken):array{


    $client = new \GuzzleHttp\Client();

    $response = $client->request('GET', 'https://app.tillersystems.com/api/orders/booking?restaurant_token='.$token.'&provider_token='.$providerToken, [
        'headers' => [
            'accept' => 'application/json',
        ],
    ]);

    $tillerOrderResponse = json_decode( $response->getBody(), true);
    $page->json->phpToJson($tillerOrderResponse,'booking') ;
    return $tillerOrderResponse ;
}

