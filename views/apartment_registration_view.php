<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ApartmentRegistrationView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayContent() {
            $host_user_list = (new BoFactory)->get(BoFactory::USER)->getListByRole(UserDo::ROLE_HOST);
			?>
                <form action="" method="POST">
                    <label for="host_user_id">Szállásadó felhasználó azonosító: </label>
                    <select name="host_user_id">
                        <?php
                            foreach($host_user_list as $host_user) {
                                ?>
                                    <option id="<?php print($host_user->name . "_" . $host_user->id) ?>" 
                                    value="<?php print($host_user->id)?>">
                                        <?php print($host_user->name . "_" . $host_user->id) ?>
                                    </option>
                                <?php
                            }
                        ?>
                    </select><br>

                    <label for="name">Név: </label>
                    <input type="text" name="name"><br>

                    <label for="address">Cím: </label>
                    <input type="text" name="address"><br>

                    <label for="price_value">Árérték: </label>
                    <input type="number" name="price_value"><br>

                    <label for="price_uom">Ármértékegység: </label>
                    <input type="text" name="price_uom"><br>

                    <label for="price_currency">Pénznem: </label>
                    <input type="text" name="price_currency"><br>

                    <label for="description">Leírás: </label>
                    <input type="text" name="description"><br>

                    <label for="max_occupancy">Maximális létszám: </label>
                    <input type="number" name="max_occupancy"><br>

                    <input name="registration" type="submit" value="Regisztrálás"/>
                </form>
			<?php
		}

    }

?>