<?php

	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	abstract class ProjectAbstractView extends AbstractView {

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayHTMLOpen() {
			?>
				<!doctype html>
                <html lang="en-US">
                <head>
                    <title><?php print($this->do->title); ?></title>

                    <meta charset="UTF-8" />
                    <meta http-equiv="content-type" content="text/html" />
                    <meta name="description" content="<?php print($this->do->description); ?>" />
                    <meta http-equiv="cache-control" content="max-age=0" />
                    <meta http-equiv="cache-control" content="no-cache" />
                    <meta http-equiv="expires" content="0" />
                    <meta http-equiv="pragma" content="no-cache" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">

                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/menu.css" type="text/css" />
                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/footer.css" type="text/css" />
                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/calendar.css" type="text/css" />
                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/map.css" type="text/css" />
                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/index.css" type="text/css" />
                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/login.css" type="text/css" />
                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/profile.css" type="text/css" />
                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/details.css" type="text/css" />

                    <script type="text/javascript" src="<?php print(RequestHelper::$common_url_root); ?>/js/jquery/jquery.js"></script>
                    <script type="text/javascript" src="<?php print(RequestHelper::$common_url_root); ?>/js/review.js"></script>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                    <link rel="stylesheet" href="<?php print(RequestHelper::$common_url_root); ?>/css/leaflet.css" type="text/css" />
                </head>
			<?php
		}

        /* ********************************************************
         * ********************************************************
         * ********************************************************/
        public function displayMenu() {
			?>

            <?php

            if(RequestHelper::$actor_action != "registration" && RequestHelper::$actor_action !="login")
                {

                    ?>
                        <div class="nav_cont">
                            <nav id="navbar">
                                <a href="<?php print(RequestHelper::$url_root); ?>">Főoldal</a>
                                <?php 

                                    if($_SESSION == true)
                                    {?>
                                         <a href="<?php print(RequestHelper::$url_root); ?>/user/view">Profil</a>
                                    <?php
                                    } else /*HELP ME WITH THIS :,( */  {
                                        ?>
                                             <div id="authLinks">
                                                <a href="<?php print(RequestHelper::$url_root); ?>/user/login" id="loginLink">Bejelentkezés</a>
                                                <a href="<?php print(RequestHelper::$url_root); ?>/user/registration" id="registerLink">Regisztráció</a>
                                            </div>
                                        <?php
                                    }
                                
                                ?>
                               
                               
                            </nav>    
                        </div>   
                    <?php
                }
		}

    }

?>