<?php
    $json = array(
        'err' => 1,
        'err_code' => $code,
        'title' => $controllerTitle,
        'header' => $actionTitle,
        'err_msg' => '服务器发生错误',
        'url' => $url
    );
    echo json_encode($json);
?>