<?php
require_once('head.php');
$page = new Page;
Site::lineHrInContainer(); ?>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <h1 class="text-info">
                <a href="/"><span class="glyphicon glyphicon-home"></span></a>
            </h1>
        </div>
        <div class="col-xs-8 text-center">
            <h1 class="text-danger"><?= Page::getTitle() ?></h1>
        </div>
        <div class="col-xs-2 text-right">
            <h1 class="text-info">
                <a href=""><span class="glyphicon glyphicon-refresh"></span></a>
            </h1>
        </div>
    </div>
</div><?php
Site::lineHrInContainer();
if ($user->getUser()) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <ul class="list-inline">
                    <li class="text-info">
                        Баланс: <?= $user->user('gold') ?> Руб
                    </li>
                    <li class="green"><?
                        if ($user->user('vip_time') > time()) {
                            echo "VIP активен еще " . Times::timeHours($user->user('vip_time') - time()) . " ";
                        } ?>
                    </li>
                    <li class="yellow">

                    </li>
                </ul>
            </div>
        </div>
    </div><?php
    Site::lineHrInContainer();
}
if (isset($_SESSION['info'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $_SESSION['info'] ?>
                </div>
            </div>
        </div>
    </div><?php
    $_SESSION['info'] = NULL;
}

if (isset($_SESSION['error'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $_SESSION['error'] ?>
                </div>
            </div>
        </div>
    </div><?php
    $_SESSION['error'] = NULL;
}

if (isset($_SESSION['ok'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $_SESSION['ok'] ?>
                </div>
            </div>
        </div>
    </div><?php
    $_SESSION['ok'] = NULL;
}