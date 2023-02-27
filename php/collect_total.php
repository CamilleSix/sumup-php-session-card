<?php
    $total = '' ;

    if (!empty($_SESSION['cartLBV']['products'])){

        foreach ($_SESSION['cartLBV']['products'] AS $product){
            $total += $product['price'] ;
        }
    }

