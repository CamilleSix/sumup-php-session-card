<div class="bigSpacing reservationParent" style="background-image: url({imgL:backgroundImageReservation})">
    <section class="uniformSpacing tac"  style="background-image: url({imgL:backgroundImageReservation2})">
        <div class="tillerResaParent {fix:displayValidation}">
            {fix:cardProductList}

            <div class="totalPayed smallSpacing mediumMarginTop">
                <span class="ibv w70 tal">Prix total payé en ligne : </span> <span class="ibv w30 tar bold"> {fix:totalPrice}€</span>
            </div>
            <span class="db tal sumUpGeo mediumMarginTop">
            {svgI:ClickCollect} Retrait au <strong>restaurant de Pusignan</strong> le <strong>{fix:finalDate}</strong>
                </span>
            <hr class="mediumMarginTop">
            <p class="validationMessage">{var:validationMessage?500}</p>
        </div>
        <div class="errorMessage {fix:displayError}">
            Le détail de cette commande n'est plus disponible
        </div>

    </section>