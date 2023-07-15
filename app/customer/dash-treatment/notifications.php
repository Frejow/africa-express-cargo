<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $notificationId = $_POST['id'];
    
    if (deleteNotification($notificationId)) {
        http_response_code(200);
    } else {
        http_response_code(400);
    }
    
} else {

    http_response_code(400);
}

