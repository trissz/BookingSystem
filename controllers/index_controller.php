<?php

    $view = new IndexView(
        new ViewDo()
    );

    $view->displayHTMLOpen();
    $view->displayHeader();
    $view->displayMenu();
    $view->displayContent();
    $view->displayLogs();
    $view->displayHTMLClose();

?>