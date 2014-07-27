<?php
    $json = array(
        'err' => 1,
        'err_code' => $code,
        'title' => $controllerTitle,
        'header' => $actionTitle,
        'err_msg' => $message,
        'url' => $url
    );
    echo json_encode($json);
?>