<?php

    /* INTEG SUMUP */
    $templateData['fix:totalPrice'] = '?' ;
    $templateData['fix:finalDate'] = '?' ;
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['phone']) && !empty($_POST['mail'])  ) {

        $page->scripts[] = '<script src="https://gateway.sumup.com/gateway/ecom/card/v2/sdk.js"></script>';

/*
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.sumup.com/v0.1/me');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer sup_sk_0TWN2Mgo2wpGU1vkBtNWrWvFeFYHFfe5z';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        // print_r($result) ;


        $clientId = "cc_classic_11OoolJwT3c0epRBpIipJVqaLbG0e";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.sumup.com/authorize?response_type=code&client_id=' . $clientId . '&redirect_uri=https://sample-app.example.com/callback&scope=payments user.app-settings transactions.history user.profile_readonly');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        //print_r($result) ;


        //  print_r($_POST);*/

        $curl = curl_init();

        $total = 0;

        if (!empty($_SESSION['cartLBV']['products'])) {

            $products = $page->json->jsonToPhp('carte_tiller');
            unset($products['label']);

            foreach ($_SESSION['cartLBV']['products'] as $productId => $product) {
                if (is_numeric($products[$productId]['price'])) {
                    $total += $products[$productId]['price'] * $product['quantity'];
                }
            }
        }

        $uniqueId =  sha1(time()."click") ;

        $templateData['fix:totalPrice'] = number_format($total, 2) ;

        $templateData['fix:finalDate'] = date('d/m/Y H:i', strtotime($_POST['finalDate'])) ;

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sumup.com/v0.1/checkouts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
  "checkout_reference": "'.$uniqueId.'",
  "amount": '.$total.',
  "currency": "EUR",
  "merchant_code": "**",
  "pay_to_email": "**",
  "description": "string",
  "return_url": "**",
  "status": "PENDING",
  "date": "'.date('Y-m-d\TH:i:sO', time()).'",
  "valid_until": "'.date('Y-m-d\TH:i:sO', time() + 3600).'",
  "redirect_url": "https://**/panier/validation/'.$uniqueId.'",
  "payment_type": "boleto",
  "personal_details": {
    "email": "'.$_POST['mail'].'",
    "first_name": "'.$_POST['prenom'].'",
    "last_name": "'.$_POST['nom'].'",
    "tax_id": "423.378.593-47",
    "address": {
      "country": "FR",
      "city": "",
      "line_1": "",
      "state": "",
      "postal_code": ""
    }
  }
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer **'
            ),
        ));

        $getCheckOutId = curl_exec($curl);
        //     print_r($getCheckOutId) ;

        curl_close($curl);
//echo $getCheckOutId;
        $getCheckOutId = json_decode($getCheckOutId, true);
//print_r($getCheckOutId) ;
        if (!empty($getCheckOutId['id'])) {

            $collects = $page->json->jsonToPhp('click_and_collect');
            $_POST['sumUpData'] = $getCheckOutId;
            $_POST['uniqueId'] = $uniqueId ;
            $collects[$uniqueId] = $_POST;
            $collects['panier'] = $_SESSION['cartLBV'] ;
            $checkoutId = $getCheckOutId['id'];

            $page->json->phpToJson($collects, 'click_and_collect');


            $page->scripts[] = '
<script
  type="text/javascript"
  src="https://gateway.sumup.com/gateway/ecom/card/v2/sdk.js"
      ></script>
<script type="text/javascript">
window.addEventListener("load", function () {
        SumUpCard.mount({
    checkoutId: \'' . $checkoutId . '\',
    locale : \'fr-FR\',
    country :  \'FR\',
    amount : \''.$total.'€\',
    onResponse: function (type, body) {
        console.log(\'Type\', type);
        console.log(\'Body\', body);
    },
  });
          });
</script>';
        }
    } else{
        //erreur info manquante
    }
