<?php
    $now = time() ; // timestamps au chargement de la page
    $currentHour = date('G', $now) ; // heure actuelle sur 24

    $jours = ["lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"] ;
    $mois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre","octobre", "novembre", "décembre"] ;

    $days = ['monday' =>'Lundi', "tuesday" =>"Mardi", "wednesday"=>"Mercredi",
        "thursday"=>"Jeudi", "friday" => "Vendredi","saturday" => "Samedi", "sunday" =>"Dimanche"] ;

    $restaurants = [ "pusignan","amberieu"] ;

  require_once 'sumup.php' ;

    $horairesJson = $page->json->jsonToPhp('restaurants') ;



    for ($r = 1 ; $r < 3; $r++) {
        $count = 1 ;
        foreach ($days as $key => $availableHours) {

            if (!empty($horairesJson[$r]['clickCollectHours2'][$key])) {
                foreach ($horairesJson[$r]['clickCollectHours2'][$key] as $dDay) {
                    if ($dDay['startHour'] >= 12 && $dDay['startHour'] <= 14) {
                        $keyTexte = "midi";
                    } else {
                        $keyTexte = "soir";
                    }
                    $hourRef = $dDay['startHour'];
                    $minuteRef = $dDay['startMinute'];

                    while ($hourRef <= $dDay['endHour']) {
                        if ($r == 1 ){
                            $resto = "amberieu" ;
                        } else {
                            $resto = "pusignan" ;
                        }
                        $horaires[$resto][$count][$keyTexte][] = $hourRef . ":" . $minuteRef;
                        $minuteRef += 30;
                        if ($minuteRef == 60) {
                            $minuteRef = "00";
                            $hourRef++;
                        }
                    }


                }

            }

            $count++;
        }
    }

   //$booking = getBooking($page,$token, $providerToken) ;

    $saveBooking = [] ;

//    foreach ($booking['orders'] AS $b){
//        if (!empty($b['status']) && $b['status'] == "WAITING") {
//            $saveBooking[$b['openDate']][] = $b['id'] ;
//        }
//    }

    $display = [] ;
    if ($currentHour < 11){
        // possibilité de réserver pour le midi si il n'est pas encore 10 heures du matin
        $display[] = 'midi' ;
    }

    if ($currentHour < 18){
        // possibilité de réserver pour l'après midi si il n'est pas encore 14 heures
        $display[] = 'soir' ;
    }

    $templateData["fix:selectDateamberieu"] = '' ;
    $templateData["fix:selectHouramberieu"] = '' ;


    $templateData["fix:selectDatepusignan"] = '' ;
    $templateData["fix:selectHourpusignan"] = '' ;

    $activeSelect = false ;

    for ($nJour = 0; $nJour < 7; $nJour++ ) {
        $dayTime = $now + $nJour * 3600 * 24;
        $defaultDisplay = ['midi', 'soir'] ;

        if ($nJour == 0){
            $defaultDisplay = $display ;
        }

        foreach ($restaurants as $restaurant) {

            if (!empty($horaires[$restaurant][date('N', $dayTime)]) && !empty($defaultDisplay)) {



                $templateData["fix:selectDate".$restaurant] .= '<option value="' . date('d-m-Y', $dayTime) . '">Le ' . ucfirst($jours[date('N', $dayTime) - 1]) . ' ' . date('d', $dayTime) . ' ' . ucfirst($mois[date('n', $dayTime) - 1]) . '</option>';

                $classSelect = "hourSelect" ;


                $savedContent = '' ;
                foreach ($defaultDisplay AS $dayPart){
                    if (!empty($horaires[$restaurant][date('N', $dayTime)][$dayPart])) {

                        foreach ($horaires[$restaurant][date('N', $dayTime)][$dayPart] as $dispoMidi) {
                            //  echo date('Y-m-d', $dayTime).'T'.$dispoMidi.':00+0000'.PHP_EOL ;

                                if ($activeSelect == false){
                                    $classSelect .= " activeSelect" ;
                                    $activeSelect = true ;
                                }
                                $savedContent.= '<option value="' . date('Y-m-d', $dayTime) . ' ' . $dispoMidi . '">' . $dispoMidi . '</option>';

                        }
                    }
                }
                $templateData["fix:selectHour".$restaurant] .= '<select class="'.$classSelect.' d' . date('d-m-Y', $dayTime) . '">'. $savedContent."</select>" ;



            }

        }
    }

    $templateData['fix:returnFormError'] = '' ;
    if (!empty($_SESSION['erreurReservation'] )){
        $templateData['fix:returnFormError'] = "<div class='smallSpacing errorBloc ibv'>".$_SESSION['erreurReservation']."</div>"  ;
        $_SESSION['erreurReservation'] = NULL ;
    }

    $templateData['fix:validReservation'] = '' ;
    if (!empty($_SESSION['validReservation'] )){
        $reworkDate =  date('d/m/Y à H:i',strtotime($_SESSION['validReservation'] ['finalDate']));
        $templateData['fix:validReservation'] = "<div class='smallSpacing validReservation ibv tal'><strong class='fs2 db thanks tac'> ".svgColor('regular/calendar-check', "#FFF")." Merci !</strong> Votre réservation de table à bien été prise en compte par le restaurant de **Pusignan**, un email récapitulatif vient de vous être envoyé.
<span class='dataReservation'>
<h2 class='db fs1_2'>Vos informations :</h2>
Table pour <strong>{$_SESSION['validReservation'] ['nPersonne']}</strong> personnes, le <strong>{$reworkDate}</strong> au nom de <strong>{$_SESSION['validReservation'] ['nom']} {$_SESSION['validReservation']['prenom']}.</strong></span> </div>"  ;
        $_SESSION['validReservation'] = NULL ;
    }


?>