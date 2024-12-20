<?php

    //TODO: Maybe this should be a helper class?
    /* ********************************************************
	 * ********************************************************
	 * ********************************************************/
    class SecurityBo {

        /* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public static function runCheck() {
            //TODO: We should have here extensive cross-reference check
            //  in order to validate user session by cookie.
            //  Maybe implement a signed cookie with hash check.
            //var_dump($_SERVER);
            //var_dump($_SESSION);
            //var_dump($_COOKIE);
            
            // Evaluate if user has a cookie.
            // Evaluate if cookie is valid.
            //      Chech cookies session id with user_login table
            // If cookie is valid
            //      refresh the session
            //      restart the 30 day on cookie validity
            
            //if (isset($_COOKIE['PHPSESSID'])) {
            if (isset($_COOKIE['user_id'])) {
                setcookie(
                    'user_id', 
                    $_COOKIE['user_id'], 
                    time() + (86400 * 30), // 30 days expiration time
                    "/", 
                    "", 
                    true, // Secure flag: only send over HTTPS
                    true // HttpOnly flag: JavaScript cannot access the cookie
                );
                
                $user_do = new UserDo((new BoFactory)->get(ActorHelper::USER)->getById($_COOKIE['user_id']));
    
                $_SESSION['user_id']      = $user_do->id;
                $_SESSION['user_name']    = $user_do->name;
                $_SESSION['is_logged_in'] = true;
            }
            
        }

        /* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public static function getRequestDetails() {
            return [
                'HTTP_SEC_CH_UA_PLATFORM'   => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'],
                'HTTP_USER_AGENT'           => $_SERVER['HTTP_USER_AGENT'],
                'HTTP_ACCEPT_LANGUAGE'      => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                'HTTP_COOKIE'               => $_SERVER['HTTP_COOKIE'],
                'PHPSESSID'                 => $_COOKIE['PHPSESSID'],
                'REMOTE_ADDR'               => $_SERVER['REMOTE_ADDR'],
                'REMOTE_PORT'               => $_SERVER['REMOTE_PORT'],
                'REQUEST_TIME'              => $_SERVER['REQUEST_TIME']
            ];
        }

        /* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		public static function getRequestDetailsInJSON() {
            return json_encode(Self::getRequestDetails());
        }



    }

?>