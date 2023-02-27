<div class="bigSpacing reservationParent" style="background-image: url({imgL:backgroundImageReservation})">
    <section class="uniformSpacing tac"  style="background-image: url({imgL:backgroundImageReservation2})">
        <div class="tillerResaParent">
            {fix:cardProductList}

            <div class="totalPriceDisplay mediumSpacing mediumMarginTop">
                <span class="ibv w70 tal">Prix total à payer : </span> <span class="ibv w30 tar"> {fix:totalPrice}€</span>
            </div>
            <span class="db tal sumUpGeo mediumMarginTop">
            {svgI:ClickCollect} Retrait au <strong>restaurant de Pusignan</strong> le <strong>{fix:finalDate}</strong>
                </span>
            <hr class="mediumMarginTop">

            <div id="sumup-card"></div>
        </div>

    </section>