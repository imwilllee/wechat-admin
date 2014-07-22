<?php
    $title = $controllerTitle;
    if (!is_null($actionTitle)) {
        $title .= Configure::read('WeChat.title_separator') . $actionTitle;
    }
    $title .= Configure::read('WeChat.title_separator') . Configure::read('WeChat.name');
    $this->assign('title', $title); 
?>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->fetch('title'); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE -->
        <link href="/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<?php echo $this->fetch('append_head'); ?>

    </head>