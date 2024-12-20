<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ApartmentViewView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayContent() {
            $apartment_bo = new ApartmentBo('apartment');
            $apartment_image_list = $apartment_bo->getImagesById($this->do->do->id, ApartmentImageFileBo::CONVERTED_FILE_REPRESENTER_LARGE);
            $user_bo = new UserBo('user');
            $apartment_host_user_do = new UserDo($user_bo->getById($this->do->do->host_user_id));
            $review_bo = new ReviewBo('review');
            $apartment_review_do_list = $review_bo->getListByApartmentId($this->do->do->id);
			?>

            <body class="details_body">
                
                <div id="listingDetails">
                    <h1><?php print($this->do->do->name); ?></h1>
                    <div class="image_cont">
                    <?php
                        foreach ($apartment_image_list as $apartment_image) {
                            if (!empty($apartment_image->file_path)) {
                        ?>
                            <img src="<?php echo htmlspecialchars(RequestHelper::$url_root . '/cdn/apartment_images/' . $apartment_image->file_name); ?>" alt="Szállás képe">
                        <?php
                            } else {
                                echo '<p>Image not available.</p>';
                            }
                        }
                        if ($this->do->do->host_user_id === $_SESSION['user_id']) {
                            ?>
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <label for="apartment_image_file">Kép feltöltése</label>
                                    <input type="file" id="apartment_image_file" name="apartment_image_file" required/>
                                    <input name="apartment_image_file_upload" class="submit" type="submit" value="Szállás kép feltöltés"/>
                                </form>
                            <?php
                        }
                    ?>
                    </div>
                    <p><strong>Cím:</strong> <?php print($this->do->do->address); ?></p>
                    <p><strong>Ár:</strong> <?php print($this->do->do->price_value . " " . $this->do->do->price_currency . " " .  $this->do->do->price_uom);?></p>
                    <p><strong>Leírás:</strong> <?php print($this->do->do->description); ?></p>
                    <p><strong>Értékelés:</strong> <?php print($review_bo->getAverageRatingByApartmentId($this->do->do->id) != "-" ? round($review_bo->getAverageRatingByApartmentId($this->do->do->id), 1) : "-"); ?>&#9733;</p>
                    <p><strong>Elérhetőségek:</strong></p>
                    <p><strong>Név:</strong> <?php print($apartment_host_user_do->name); ?></p>
                    <p><strong>E-mail:</strong> <?php print($apartment_host_user_do->email); ?></p>
                    <p><strong>Telefonszám:</strong> <?php print($apartment_host_user_do->phone); ?></p>
                    
                </div>
                <div id="ratingSection" >
                    <h2>Értékeld ezt a szállást!</h2>
                    <div id="stars">
                        <span data-value="1">&#9733;</span>
                        <span data-value="2">&#9733;</span>
                        <span data-value="3">&#9733;</span>
                        <span data-value="4">&#9733;</span>
                        <span data-value="5">&#9733;</span>
                    </div>
                    <form method="POST" action="">
                        <input type="text" id="rating" name="rating" value="5" hidden/>
                        <textarea id="comment" name="comment" placeholder="Írd le véleményed..."></textarea>
                        <input name="submit_review" class="submit" type="submit" value="Értékelés küldése"/>
                    </form>
                    <p id="reviewMessage"></p>
                </div>

                <div id="review_container">
                    <?php
                        foreach($apartment_review_do_list as $apartment_review_do) {
                            $user_do_list = $user_bo->getById($apartment_review_do->user_id);
                            $user_do = new UserDo($user_do_list);

                            ?>
                                <div class="apartmentReviewListElement">
                                <p>Felhasználó: <?php print($user_do->name) ?></p>
                                <p>Értékelés: <?php print($apartment_review_do->rating != "-" ? round($apartment_review_do->rating, 1) : "-") ?>&#9733;</p>
                                <p>Megjegyzés: <?php print($apartment_review_do->comment) ?></p>
                                </div>
                            <?php
                        }
                    ?>
                </div>


                <div id="bookingForm" <?php if($_SESSION == false) { ?> style="display:none" <?php } ?>>
                    <form method="POST" action="">

                        <label for="start_date">Kezdő dátum:</label>
                        <input type="date" id="start_date" name="start_date"/>

                        <label for="end_date">Befejező dátum:</label>
                        <input type="date" id="end_date" name="end_date"/>

                        <label for="number_of_guests">Vendégek száma:</label>
                        <input type="number" id="number_of_guests" name="number_of_guests" min="1"/>

                        <input name="booking" class="submit" type="submit" value="Foglalás"/>
                    </form>
                </div>
            </body>
			<?php
        }

    }

?>