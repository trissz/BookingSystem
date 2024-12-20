<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class UserLoginView extends ProjectAbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayContent() {
			?>
            <body class="log_reg_body">
                
                <div class="container">
                    <h1>Bejelentkezés</h1>
                    <form id="loginForm" method="POST" action="">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" placeholder="Add meg az e-mail címed" required>
                        
                        <label for="password">Jelszó:</label>
                        <input type="password" id="password" name="password" placeholder="Add meg a jelszavad" required>
                        
                        <input name="login" class="submit" type="submit" value="Bejelentkezés"/>
                        <p class="switch">
                            Nincs fiókod? <a href="<?php print(RequestHelper::$url_root); ?>/user/registration">Regisztráció</a>
                        </p>
                    </form>
                </div>

            </body>
                
			<?php
		}

    }

?>