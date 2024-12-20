<?php

    /* ********************************************************
	 * ********************************************************
	 * ********************************************************/
    class UserDo extends AbstractDo {

        public $name;
        public $email;
        public $password;
        public $password_again;
        public $password_hash;
        public $phone;
        public $role;

        public $profile_icon_file_path;
        public $profile_small_file_path;
        public $profile_medium_file_path;
        public $profile_large_file_path;
        public $profile_icon_url;
        public $profile_small_url;
        public $profile_medium_url;
        public $profile_large_url;

        const ROLE_USER = "user";
        const ROLE_HOST = "host";
        const ROLE_ADMIN = "admin";

    }

?>