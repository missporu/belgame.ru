<?php
date_default_timezone_set('Europe/Moscow');
session_start();
ob_start();
$timeregen = microtime(as_float: TRUE);
require_once "sys.php"; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Видео и фото от Miss Po 18+ из невошедшего в соц сети. Общение с misspo напрямую! Все вопросы и ответы">
    <meta name="keywords" content="misspo, Miss Po, 18+, видео, выступления, клубничка, фото, фото 18+, видео 18+"/>
    <meta name="robots" content="all"/>
    <meta name="author" content="misspo">
    <link rel="icon" href="/war-game.ico"><?php
    if (empty($title)) {
        $title = Site::NAME;
    }
    Page::setTitle($title);
    echo '<title>' . Page::getTitle() . '</title>'; ?>

    <meta property="og:title" content="<?= Page::getTitle() ?>"/>
    <meta property="og:description"
          content="Видео и фото от Miss Po 18+ из невошедшего в соц сети. Общение с misspo напрямую! Все вопросы и ответы"/>
    <meta property="og:image" content="//<?= Site::getDomen() ?>/images/logotips/logo.jpg"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:image:width" content="400"/>
    <meta property="og:image:height" content="300"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="//<?= Site::getDomen() ?>"/>
    <meta property="og:image:secure_url" content="https://<?= Site::getDomen() ?>"/>

    <!-- Bootstrap core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="//<?= Site::getDomen() ?>/style/style.css">
    <link rel="stylesheet" href="//<?= Site::getDomen() ?>/style/standart/style.css">

    <!-- IE 10 css -->
    <link rel="stylesheet" href="//<?= Site::getDomen() ?>/style/ie10-viewport-bug-workaround.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="//<?= Site::getDomen() ?>/add.js"></script>
</head>
<body>