<?php

    /* ********************************************************
	 * *** Models *********************************************
	 * ********************************************************/

        /* ********************************************************
         * *** Business Objects ***********************************
         * ********************************************************/
        
        require(RequestHelper::$file_root . '/models/bos/database_connection_bo.php');
        require(RequestHelper::$file_root . '/models/bos/abstract_bo.php');
        require(RequestHelper::$file_root . '/models/bos/security_bo.php');
        require(RequestHelper::$file_root . '/models/bos/user_bo.php');
        require(RequestHelper::$file_root . '/models/bos/apartment_bo.php');
        require(RequestHelper::$file_root . '/models/bos/apartment_image_bo.php');
        require(RequestHelper::$file_root . '/models/bos/apartment_image_file_bo.php');
        require(RequestHelper::$file_root . '/models/bos/booking_bo.php');
        require(RequestHelper::$file_root . '/models/bos/review_bo.php');
        require(RequestHelper::$file_root . '/models/bos/currency_bo.php');


        /* ********************************************************
         * *** Data Access Objects ********************************
         * ********************************************************/
        require(RequestHelper::$file_root . '/models/daos/abstract_dao.php');
        require(RequestHelper::$file_root . '/models/daos/user_dao.php');
        require(RequestHelper::$file_root . '/models/daos/apartment_dao.php');
        require(RequestHelper::$file_root . '/models/daos/apartment_image_dao.php');
        require(RequestHelper::$file_root . '/models/daos/booking_dao.php');
        require(RequestHelper::$file_root . '/models/daos/review_dao.php');
        require(RequestHelper::$file_root . '/models/daos/currency_dao.php');


        /* ********************************************************
         * *** Data Objects ***************************************
         * ********************************************************/
        require(RequestHelper::$file_root . '/models/dos/view_do.php');
        require(RequestHelper::$file_root . '/models/dos/abstract_do.php');
        require(RequestHelper::$file_root . '/models/dos/user_do.php');
        require(RequestHelper::$file_root . '/models/dos/apartment_do.php');
        require(RequestHelper::$file_root . '/models/dos/apartment_image_do.php');
        require(RequestHelper::$file_root . '/models/dos/booking_do.php');
        require(RequestHelper::$file_root . '/models/dos/review_do.php');
        require(RequestHelper::$file_root . '/models/dos/currency_do.php');



        /* ********************************************************
         * *** Helpers ********************************************
         * ********************************************************/
        require(RequestHelper::$file_root . '/models/helpers/log_helper.php');
        require(RequestHelper::$file_root . '/models/helpers/actor_helper.php');
        require(RequestHelper::$file_root . '/models/helpers/string_helper.php');
        require(RequestHelper::$file_root . '/models/helpers/datetime_helper.php');
        require(RequestHelper::$file_root . '/models/helpers/permission_helper.php');


        /* ********************************************************
         * *** Factories ******************************************
         * ********************************************************/
        require(RequestHelper::$file_root . '/models/factories/bo_factory.php');
        require(RequestHelper::$file_root . '/models/factories/dao_factory.php');
        require(RequestHelper::$file_root . '/models/factories/do_factory.php');


    /* ********************************************************
	 * *** Views **********************************************
	 * ********************************************************/
    require(RequestHelper::$file_root . '/views/abstract_view.php');
    require(RequestHelper::$file_root . '/views/project_abstract_view.php');
    require(RequestHelper::$file_root . '/views/index_view.php');
    require(RequestHelper::$file_root . '/views/user_registration_view.php');
    require(RequestHelper::$file_root . '/views/user_list_view.php');
    require(RequestHelper::$file_root . '/views/user_login_view.php');
    require(RequestHelper::$file_root . '/views/user_view_view.php');
    require(RequestHelper::$file_root . '/views/apartment_registration_view.php');
    require(RequestHelper::$file_root . '/views/apartment_view_view.php');



?>