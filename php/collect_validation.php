<?php

    $templateData['fix:totalPrice'] = '?' ;
    $templateData['fix:finalDate'] = '?' ;

    $templateData['fix:displayValidation'] = '' ;
    $templateData['fix:displayError'] = 'hidden' ;

    if (!empty($_GET['data']) && !empty($_SESSION['cartLBV'])) {
        $collects = $page->json->jsonToPhp('click_and_collect');

        if (!empty($collects[$_GET['data']])){
            $templateData['fix:totalPrice'] = number_format($collects[$_GET['data']]['sumUpData']['amount'], 2) ;
            $templateData['fix:finalDate'] =  date('d/m/Y H:i', strtotime($collects[$_GET['data']]['finalDate'])) ;
        }
        unset($_SESSION['cartLBV']) ;
    } else{
        //erreur info manquante
        $templateData['fix:displayValidation'] = 'hidden' ;
        $templateData['fix:displayError'] = '' ;
    }
