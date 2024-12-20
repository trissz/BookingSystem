<?php

    $do = new (RequestHelper::$actor_class_name . 'Do');

    if (isset($_POST['registration']) && $_POST['registration'] === 'Regisztrálás') {
        //TODO: Abstract attribute assignments...
        $do->host_user_id          		= $_POST['host_user_id'];
        $do->name 				        = $_POST['name'];
        $do->address 			        = $_POST['address'];
        $do->price_value 	            = $_POST['price_value'];
        $do->price_uom                  = $_POST['price_uom'];
        $do->price_currency             = $_POST['price_currency'];
        $do->description 			    = $_POST['description'];
        $do->max_occupancy 			    = $_POST['max_occupancy'];
        
        if ($bo->isRegistrationValid($do)) {
            $bo->create($do);
            LogHelper::addConfirmation('Apartment registration was successful!');
        }
    }

    if(isset($_POST['apartment_image_file']) && $_POST['apartment_image_file'] === 'Feltöltés') {
        if (isset($_FILES['apartment_image_file'])) {
            if (true) { //TODO: implement checks for the image upload.
                $image_file_bo = new ApartmentImageFileBo($_FILES['apartment_image_file'], $do);
                
                LogHelper::addMessage('File uploaded successfully!');
            }
            else {
                LogHelper::addMessage('Error occured while uploading file!');
            }
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