<?php

    $do = new (RequestHelper::$actor_class_name . 'Do');

    if (isset($_POST['registration']) && $_POST['registration'] === 'Regisztrálás') {
        //TODO: Abstract attribute assignments...
        $do->name          		= $_POST['name'];
        $do->email 				= $_POST['email'];
        $do->password 			= $_POST['password'];
        $do->password_again 	= $_POST['password_again'];
        $do->password_hash      = $bo->getHashFromPassword($do);
        $do->phone              = $_POST['phone'];
        $do->role 			    = $_POST['role'];
        
        if ($bo->isRegistrationValid($do)) {
            $bo->create($do);
            LogHelper::addConfirmation('User registration was successful!');
            header("Location: " . RequestHelper::$url_root . "/user/login");
        }
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