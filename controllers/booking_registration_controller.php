<?php

    $do = new (RequestHelper::$actor_class_name . 'Do');

    if (isset($_POST['registration']) && $_POST['registration'] === 'Regisztrálás') {
        //TODO: Abstract attribute assignments...
        $do->apartment_id          	= $_POST['apartment_id'];
        $do->user_id 				= $_POST['user_id'];
        $do->start_date 			= $_POST['start_date'];
        $do->end_date 	            = $_POST['end_date'];
        $do->number_of_guests       = $_POST['number_of_guests'];
        $do->total_price            = $_POST['total_price'];
        
        if ($bo->isRegistrationValid($do)) {
            $bo->create($do);
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