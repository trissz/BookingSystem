<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class UserRegistrationView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayContent() {
			?>
                


            <body class="log_reg_body">
                <div class="container">
                    <h1>Regisztráció</h1>
                    <form id="registerForm" method="POST" action="">
                    <label for="name">Felhasználónév:</label>
                    <input type="text" id="username" name="name" placeholder="Add meg a felhasználóneved" required>
                    
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="Add meg az e-mail címed" required>
                    
                    <label for="role">Válassz szerepet:</label>
                    <select name="role" id="role">
                        <option value="User">User</option>
                        <option value="Host">Host</option>
                    </select>

                    <label for="password">Jelszó:</label>
                    <input type="password" id="password" name="password" placeholder="Add meg a jelszavad" required>
                    
                    <label for="password_again">Jelszó újra: </label>
                    <input type="password" name="password_again"  placeholder="Add meg a jelszavad újra" required>

                    <label for="phone">Telefonszám: </label>
                    <input type="text" name="phone" placeholder="Add meg a telefonszámodat" required>


                    <input name="registration" class="submit" type="submit" value="Regisztrálás"/>
                    <p class="switch">
                        Már van fiókod? <a href="<?php print(RequestHelper::$url_root); ?>/user/login">Bejelentkezés</a>
                    </p>
                    </form>
                </div>
            </body>


			<?php
		}

    }

?>