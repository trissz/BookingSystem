<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class UserViewView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayContent() {
			$bookings_list = (new BoFactory)->get(BoFactory::BOOKING)->getBookingsByUserId($this->do->do->id);
			$apartment_do_list = (new BoFactory)->get(BoFactory::APARTMENT)->getList($this->do->do->id);
			$apartment_bo = (new BoFactory)->get(BoFactory::APARTMENT);

			if($this->do->do->role === UserDo::ROLE_HOST) {
				?>
				<br><br>
				<body class="host_body">
					<div class="profile_container">
						<h1>Host Dashboard</h1>
						<form id="addListingForm" method="POST" action="" enctype="multipart/form-data">
							<h2>Új Szállás Feltöltése</h2>
							<label for="apartment_name">Szállás Neve:</label>
							<input type="text" id="apartment_name" name="apartment_name" required>
							
							<label for="apartment_address">Cím:</label>
							<input type="text" id="apartment_address" name="apartment_address" required>
							
							<label for="apartment_price_value">Ár:</label>
							<input type="number" id="apartment_price_value" name="apartment_price_value" required>

							<label for="apartment_price_uom">Ár mértékegység</label>
							<select id="apartment_price_uom" name="apartment_price_uom" required>
								<option value="/fő/éj">/fő/éj</option>
								<option value="/szoba/éj">/szoba/éj</option>
								<option value="/apartman/éj">/apartman/éj</option>
							</select>

							<label for="apartment_price_currency">Pénznem</label>
							<input type="text" id="apartment_price_currency" name="apartment_price_currency"><br>
							
							<label for="apartment_description">Leírás:</label>
							<textarea id="apartment_description" name="apartment_description" required></textarea>

							<label for="apartment_max_occupancy">Max befogadó képesség</label>
							<input type="number" id="apartment_max_occupancy" name="apartment_max_occupancy" required>
							
							<input name="apartment_upload" class="submit" type="submit" value="Szállás feltöltés"/>
						</form>

						<h2>Szállásaim</h2>
						<div id="listingsContainer">
							<?php
								
									foreach ($apartment_do_list as $apartment_do) {
										if($this->do->do->id == $apartment_do->host_user_id) {?>
										<div class="own_listings">
											<h3><?php echo htmlspecialchars($apartment_do->name); ?></h3>
											<a href="<?php echo htmlspecialchars(RequestHelper::$common_url_root . '/apartment/view/' . $apartment_do->id); ?>">
												Megnézem
											</a>
										</div>
									
									<?php 
								}
							}
							?>
						</div>
					</div>
				</body>
				<?php
			}

			if($this->do->do->role === UserDo::ROLE_ADMIN) {
				?>
					<div class="container">
						<h1>Admin Dashboard</h1>
						<p>Üdvözöljük, Admin!</p>
					
						<button id="viewBookings">Foglalások megtekintése</button>
					</div>
				<?php
			}

			if($this->do->do->id === $_SESSION['user_id']) {
				?>
					<body class="profile_body">
						<div class="profile_container">

							<form id="modification" method="POST" action="">
								<h1>
									Üdvözöljük, 
										<input name="name" type="text" id="user_name" value="<?php print($this->do->do->name); ?>"/>
									!
								</h1>
								<p>
									E-mail: 
										<input name="email" type="text" id="email" value="<?php print($this->do->do->email); ?>"/>
								</p>
								<input name="modification" class="submit" type="submit" value="Módosítás"/>
							</form>
							<form id="logout" method="POST" action="<?php print(RequestHelper::$url_root . '/' . RequestHelper::$actor_name . '/' . 'logout') ?>">
								<input name="logout" class="submit" type="submit" value="Kijelentkezés"/>
							</form>
							<h2>Foglalásaid</h2>
							<div id="bookingsList">
								<?php
								foreach($bookings_list as $booking) {
									$booked_apartment = new ApartmentDo($apartment_bo->getById($booking->apartment_id));
								?>
								<div class="booking_list_element">
									<div class="booking_info">
										<p class="info_label">Szállás neve:</p>
										<p class="info_value"><?php print($booked_apartment->name); ?></p>
									</div>
									<div class="booking_info">
										<p class="info_label">Szállás címe:</p>
										<p class="info_value"><?php print($booked_apartment->address); ?></p>
									</div>
									<div class="booking_dates">
										<p class="info_label">Időszak:</p>
										<p class="info_value"><?php print($booking->start_date); ?> - <?php print($booking->end_date); ?></p>
									</div>
								</div>
								<?php
								}
								?>
							</div>
						</div>
					</body>
				<?php
			}
			else
			{
				?>
					<body class="profile_body">
						<div class="profile_container">
							<h1>Üdvözöljük, <span id="user_name">
								<?php
									print($this->do->do->name);
								?>
							</span>!</h1>
							<p>E-mail: <span id="email">
								<?php
									print($this->do->do->email);
								?>
							</span></p>
						</div>
					</body>
				<?php
			}
		}

    }

?>