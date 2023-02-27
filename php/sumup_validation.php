<?php
   // $_POST['id'] = $_GET['data'] ;
    if (!empty($_POST) && !empty($_POST['id'])){
        $collects = $page->json->jsonToPhp('click_and_collect');

        foreach ($collects AS $checkout_reference => $command){

            if (!empty($command['sumUpData']) && $command['sumUpData']['id'] == $_POST['id'] && $command['sumUpData']['status'] == 'PENDING'){

                // print_r($command) ; print_r($_POST['id']) ;
                // retour de webhook avec un id correspondant à une entrée du json
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.sumup.com/v0.1/checkouts/'.$command['sumUpData']['id'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Authorization: Bearer **'
                    )
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $sumUpReturn = json_decode($response);
                if ($sumUpReturn->status == "PAID") {
                    // sum up confirme bien le paiement
                    // mail de validation et de résumé de la commande
                } else {
                    // mail indiquant que le paiement a été refusé
                }
                $collects[$checkout_reference]['sumUpData'] = $sumUpReturn ;
            }
        }
        $page->json->phpToJson($collects,'click_and_collect');
    }

?>