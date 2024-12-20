<?php

    // Lets redirect the user if it is already logged in.
    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
        header('Location: ' . RequestHelper::$url_root . '/user/view');
        exit();
    }

    $do = new (RequestHelper::$actor_class_name . 'Do');

    if (isset($_POST['login']) && $_POST['login'] === 'Bejelentkezés') {
        //TODO: Abstract attribute assignments...
        $do->email           = $_POST['email'];
        $do->password        = $_POST['password'];
        $do->password_hash   = $bo->getHashFromPassword($do);

        $bo->login($do);
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