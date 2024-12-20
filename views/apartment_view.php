<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ApartmentView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/

         public function displayContent() {
			?>
                    <main>
                        <div id="listingDetails">Betöltés...</div>
                    
                        <div id="ratingSection" >
                            <h2>Értékeld ezt a szállást!</h2>
                            <div id="stars">
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <textarea id="comment" placeholder="Írd le véleményed..."></textarea>
                            <button id="submitReview">Értékelés küldése</button>
                            <p id="reviewMessage"></p>
                        </div>
                    
                        <div id="bookingForm" style="display: none;">
                            <h2>Foglalás</h2>
                            <form id="bookingFormElement">
                                <label for="startDate">Kezdő dátum:</label>
                                <input type="date" id="startDate" required>
                    
                                <label for="endDate">Befejező dátum:</label>
                                <input type="date" id="endDate" required>
                    
                                <label for="guests">Vendégek száma:</label>
                                <input type="number" id="guests" min="1" required>
                    
                                <button type="submit">Foglalás</button>
                            </form>
                            <p id="bookingMessage"></p>
                        </div>
                    </main>


            <?php
         }
    }
?>