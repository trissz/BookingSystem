<?php

    header('Content-Type: text/html; charset=utf-8');
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 1);
    require($_SERVER['DOCUMENT_ROOT'] . '/booking_system/models/helpers/request_helper.php');

    RequestHelper::$common_file_root    = $_SERVER['DOCUMENT_ROOT'] . '/booking_system/';
    RequestHelper::$project_name        = 'Booking system';
    RequestHelper::$project_url_name    = 'booking_system'; //StringHelper::toURLSafeString(RequestHelper::$project_name);
    RequestHelper::$file_root           = dirname(__FILE__);
    RequestHelper::$request_uri         = $_SERVER['REQUEST_URI'];
    RequestHelper::$url_root            = RequestHelper::$url_domain
     . RequestHelper::$project_url_name;
    RequestHelper::$common_url_root     = RequestHelper::$url_domain . 'booking_system';

    require(RequestHelper::$file_root . '/require.php');

    LogHelper::addMessage('Request uri: ' . RequestHelper::$request_uri);

    /* ********************************************************
	 * *** Security... ****************************************
	 * ********************************************************/
    session_start();
    SecurityBo::runCheck();

    /* ********************************************************
	 * *** Here is the main controlling logic... **************
	 * ********************************************************/
	RequestHelper::$request_array       = explode('/', RequestHelper::$request_uri);
    RequestHelper::$actor_name          = empty(RequestHelper::$request_array[2]) ? 'index' : RequestHelper::$request_array[2];
    RequestHelper::$actor_action        = isset(RequestHelper::$request_array[3]) ? RequestHelper::$request_array[3] : 'list';
    RequestHelper::$actor_id            = isset(RequestHelper::$request_array[4]) ? RequestHelper::$request_array[4] : null;
    RequestHelper::$actor_class_name    = StringHelper::toPascalCase(RequestHelper::$actor_name);
    LogHelper::addMessage('project_name: ' . RequestHelper::$project_name);
    LogHelper::addMessage('actor_name: ' . RequestHelper::$actor_name);
    LogHelper::addMessage('actor_action: ' . RequestHelper::$actor_action);
    LogHelper::addMessage('actor_id: ' . RequestHelper::$actor_id);

    $bo_factory = new BoFactory();
    $do_factory = new DoFactory();

    /* ********************************************************
	 * *** Lets require controller by request... **************
	 * ********************************************************/
	require(
        RequestHelper::$file_root . '/controllers/' . 
        RequestHelper::$actor_name . '_controller.php'
    );
?>