<?php

	if (empty($_SESSION['user_id'])){
		header(
			"Location: " . 	
			RequestHelper::$url_root . "/" . 
			RequestHelper::$actor_name . "/" . 
			"login"
		);
		exit();
	}

    if(!RequestHelper::$actor_id) {
        $do = new UserDo($bo->getById($_SESSION['user_id']));
    }
    else {
        $do = new UserDo($bo->getById(RequestHelper::$actor_id));
    }

    if (isset($_POST['apartment_upload']) && $_POST['apartment_upload'] === 'Szállás feltöltés') {
        $apartment_bo = new ApartmentBo('apartment');
        $apartment_do = new ApartmentDo();
        //TODO: Abstract attribute assignments...
        $apartment_do->host_user_id     = $_SESSION['user_id'];
        $apartment_do->name             = $_POST['apartment_name'];
        $apartment_do->address          = $_POST['apartment_address'];
        $apartment_do->price_value      = $_POST['apartment_price_value'];
        $apartment_do->price_uom        = $_POST['apartment_price_uom'];
        $apartment_do->price_currency   = $_POST['apartment_price_currency'];
        $apartment_do->description      = $_POST['apartment_description'];
        $apartment_do->max_occupancy    = $_POST['apartment_max_occupancy'];
        
        if ($apartment_bo->isRegistrationValid($apartment_do)) {
            $apartment_bo->create($apartment_do);
            LogHelper::addConfirmation('Apartment creation was successful!');
            //header("Location: " . RequestHelper::$url_root . '/' . RequestHelper::$actor_name . '/' . 'login');
            //TODO: Password modification
        }
    }

    if (isset($_POST['modification']) && $_POST['modification'] === 'Módosítás') {
        //TODO: Abstract attribute assignments...
        $do->id = $_SESSION['user_id'];
        $do->name = $_POST['name'];
        
        //if ($bo->isRegistrationValid($do)) {
            $bo->update($do);
            LogHelper::addConfirmation('User update was successful!');
            //header("Location: " . RequestHelper::$url_root . '/' . RequestHelper::$actor_name . '/' . 'login');
            //TODO: Password modification
        //}
    }
	
	$view = new (RequestHelper::$actor_class_name . ucfirst(RequestHelper::$actor_action) . 'View')(
        new ViewDo(
            RequestHelper::$project_name . ' > ' . RequestHelper::$actor_name . ' > ' . RequestHelper::$actor_action,
            'DESCRIPTION - ' . RequestHelper::$project_name . ' > ' . RequestHelper::$actor_name . ' > ' . RequestHelper::$actor_action,
            null,
            $do
        ),
    );

    $view->displayHTMLOpen();
    $view->displayHeader();
    $view->displayMenu();
    $view->displayContent();
    $view->displayFooter();
    $view->displayLogs();
    $view->displayHTMLClose();
 ?>