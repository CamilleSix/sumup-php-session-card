<input type="hidden" class="disableReservationAmberieu" value="{glb:disableReservationAmberieu}" name="disableReservationAmberieu">
<input type="hidden" class="disableReservationPusignan" value="{glb:disableReservationPusignan}" name="disableReservationPusignan">


<div class="bigSpacing reservationParent" style="background-image: url({imgL:backgroundImageReservation})">
    <section class="uniformSpacing tac"  style="background-image: url({imgL:backgroundImageReservation2})">
        {fix:returnFormError}
        {fix:validReservation}
        <div class="hidden emptyCard">Votre panier est vide, rendez-vous sur les cartes de nos restaurants pour ajouter des produits.</div>
        <div class="tillerResaParent">
            <h{param:titleKinddca?2} class="title">{var:mainRedTitleClick?20}</h{param:titleKinddca?2}>
            <h{param:titleKind738?3} class="subtitle">{var:mainRedSucTitleClick?30}</h{param:titleKind738?3}>

            <form class="tillerResa" method="POST" action="../panier/paiement">

                {fix:cardProductList}

                <span class="iWant">{var:iwantClick?30}</span>
                <ul class="restaurantList">
                    <li data-value="pusignan" class="ibv leftRestaurant selectedResto" style="background-image: url({imgL:backgroundImageRestaurant2})"><span>{var:restaurant2nName?10}</span></li>
                    <li data-value="amberieu" class="ibv" style="background-image: url({imgL:backgroundImageRestaurant1})"><span>{var:restaurant1nName?10}</span></li>
                </ul>
                <div id="errorMessageAmberieu" class="hidden">
                    <span class="basicRadiusBox smallSpacing" style="background-color: #fddfd2">
                        <strong class="db fs2">Click & collect indisponible</strong>
                        <br>
                    Le click & collect pour le restaurant d'Ambérieu n'est pas encore disponible sur notre site.
                    </span>
                </div>
                <div id="errorMessagePusignan" class="hidden">
                    <span class="basicRadiusBox smallSpacing" style="background-color: #fddfd2">
                        <strong class="db fs2">Click & collect indisponible</strong>
                        <br>
                    Le click & collect pour le restaurant de Pusignan est actuellement indisponible.
                    </span>
                </div>
                <fieldset id="allReservation">

                    <label class="ibv w50 labelLeft">
                        <input type="text" name="nom" placeholder="Nom" required>
                    </label>
                    <label class="ibv w50 labelRight">
                        <input type="text" name="prenom" placeholder="Prénom" required>
                    </label>

                    <label class="ibv w50 labelLeft">
                        <input type="text" name="phone" placeholder="Téléphone" required>
                    </label>
                    <label class="ibv w50 labelRight">
                        <input type="text" name="mail" placeholder="Email" required>
                    </label>
                    <div>
                        {var:iRecupCommandText?50}
                    </div>
                    <div class="pusignanSelect">
                        <label class="ibv w50 labelLeft">
                            <select class="restaurantTriggerSelect">{fix:selectDatepusignan}</select>
                        </label>
                        <label class="ibv w50 labelRight">
                            {fix:selectHourpusignan}
                        </label>
                    </div>

                    <div class="amberieuSelect hidden">
                        <label class="ibv w50 labelLeft">
                            <select class="restaurantTriggerSelect">{fix:selectDateamberieu}</select>
                        </label>
                        <label class="ibv w50 labelRight">
                            {fix:selectHouramberieu}
                        </label>
                    </div>


                    <button class="defaultButton color2Button ibv reservationButton hoverBasicEffect" type="submit">{var:reservationButtonClickCollect?20}</button>
                </fieldset>
                <input type="hidden" name="restaurant" value="pusignan" id="hiddenRestaurant">
                <input type="hidden" name="finalDate" id="hiddenFinalDate">
            </form>
        </div>
    </section>
</div>