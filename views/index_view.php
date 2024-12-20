<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class IndexView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayContent() {
          $apartment_bo = (new BoFactory)->get(BoFactory::APARTMENT);
          $apartment_do_list = $apartment_bo->getList();
          $review_bo = new ReviewBo('review');
          
			?>
       <body class="index_body">
          <h1>Szállások</h1>
          <main>
              <div id="listingsContainer">
                  <?php foreach ($apartment_do_list as $apartment_do) {
                      $apartment_image_list = $apartment_bo->getImagesById($apartment_do->id, ApartmentImageFileBo::CONVERTED_FILE_REPRESENTER_MEDIUM); ?>
                      <div class="listing">
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
                          ?>
                          <div class="listing-content">
                              <div class="left_side">
                                <h2><?php echo htmlspecialchars($apartment_do->name); ?></h2>
                                <p><strong><i style="font-size:16px" class="fa">&#xf041;</i> <?php echo htmlspecialchars($apartment_do->address); ?></strong> </p>
                              </div>
                              <div class="right_side">
                              <p style="color:goldenrod"><strong>Értékelés:</strong> <?php print($review_bo->getAverageRatingByApartmentId($apartment_do->id) != "-" ? round($review_bo->getAverageRatingByApartmentId($apartment_do->id), 1) : "-"); ?>&#9733;</p>
                                <p><strong><?php echo htmlspecialchars($apartment_do->price_value . " " . $apartment_do->price_currency ); ?></strong> </p>
                                <p><strong><?php echo htmlspecialchars($apartment_do->price_uom)?></strong></p>
                                <a href="<?php echo htmlspecialchars(RequestHelper::$common_url_root . '/apartment/view/' . $apartment_do->id); ?>">
                                    Megnézem
                                </a>
                              </div>
                          </div>
                      </div>
                  <?php } ?>
              </div>
          </main>
        </body>

                
			<?php
		}

    }

?>