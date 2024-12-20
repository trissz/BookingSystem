<?php

    if(!RequestHelper::$actor_id) {
        LogHelper::addWarning("The requested apartment does not found...");
    }
    else {
        $do = new ApartmentDo($bo->getById(RequestHelper::$actor_id));
    }

    if (
        isset($_POST['apartment_image_file_upload']) &&
        $_POST['apartment_image_file_upload'] === 'Szállás kép feltöltés' &&
        $_SESSION['is_logged_in'] && isset($_SESSION['user_id']) &&
        $_SESSION['user_id'] == $do->host_user_id
    ) {
        if (isset($_FILES['apartment_image_file'])) {
            if (true) { //TODO: implement checks for the image upload.
                $do->class_actor = "Apartment";
                $image_file_bo = new ApartmentImageFileBo($_FILES['apartment_image_file'], $do);                
                LogHelper::addMessage('File uploaded successfully!');
            }
            else {
                LogHelper::addMessage('Error occured while uploading file!');
            }
        }
    }

    if (
        isset($_POST['submit_review']) &&
        $_POST['submit_review'] === 'Értékelés küldése' &&
        $_SESSION['is_logged_in'] &&
        isset($_SESSION['user_id'])
        /*&& $_SESSION['user_id'] != $do->host_user_id*/
    ) {
        $review_bo = new ReviewBo("rating");
        $review_do = new ReviewDo();
        //TODO: Abstract attribute assignments...
        $review_do->apartment_id        = $do->id;
        $review_do->user_id 			= $_SESSION['user_id'];
        $review_do->rating 			    = $_POST['rating'];
        $review_do->comment 			= $_POST['comment'];
        
        if ($review_bo->isRegistrationValid($review_do)) {
            $review_bo->create($review_do);
        }
    }

    if (isset($_POST['booking']) && $_POST['booking'] === 'Foglalás' && $_SESSION['is_logged_in'] && isset($_SESSION['user_id'])) {
        $booking_bo = new BookingBo("booking");
        $booking_do = new BookingDo();
        //TODO: Abstract attribute assignments...
        $booking_do->apartment_id          	= $do->id;
        $booking_do->user_id 				= $_SESSION['user_id'];
        $booking_do->start_date 			= $_POST['start_date'];
        $booking_do->end_date 	            = $_POST['end_date'];
        $booking_do->number_of_guests       = $_POST['number_of_guests'];
        $booking_do->total_price            = $do->price_value * $booking_do->number_of_guests; //TODO: implement UOM calculations
        
        if ($booking_bo->isRegistrationValid($booking_do)) {
            $booking_bo->create($booking_do);
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